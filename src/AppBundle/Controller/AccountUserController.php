<?php

/**
 * Created by PhpStorm.
 * User: radoncode
 * Date: 31/12/17
 * Time: 12:39
 */

namespace AppBundle\Controller;

use AppBundle\Form\EmailUsersEditType;
use AppBundle\Form\PasswordUsersEditType;
use AppBundle\Form\UsersEditType;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Controller\ProfileController as BaseProfileController;


/**;
 * Class AccountUserController
 * @package AppBundle\Controller
 *
 */

class AccountUserController extends BaseProfileController
{
    /**
     * @Route("/profile/edit",name="profile_edit")
     * @param Request $request
     * @return null|RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     */

   public function editAction(Request $request)
   {
       $observationsNotValidated= array();
       $user = $this->getUser();

       // Create all Form for editing user profile
       $formAddUser = $this->createForm(UsersEditType::class, $user);
       $formChangeEmail = $this->createForm(EmailUsersEditType::class, $user);
       $formChangePassword  = $this->createForm(PasswordUsersEditType::class, $user);

       if ($request->isMethod('POST') && $formAddUser->handleRequest($request)->isValid()){
           return $this->editInfoUser($request, $user, $formAddUser);
       }

       if ($request->isMethod('POST') && $formChangePassword->handleRequest($request)->isValid()){
           return $this->editPasword($request, $user, $formChangePassword);
       }

       if ($request->isMethod('POST') && $formChangeEmail->handleRequest($request)->isValid()){
           return $this->editEmail($request, $user, $formChangeEmail);
       }

       // We check if the connected user is a naturalist,
       if ($this->get('security.authorization_checker')->isGranted('ROLE_NATURALIST')) {
           $serviceRecoverObservations = $this->container->get('observations_not_validate');
           $observationsNotValidated = $serviceRecoverObservations->pendingObservations();
       }

       return $this->render('@FOSUser/Profile/edit.html.twig', array(
           'formAddUser'                => $formAddUser->createView(),
           'formChangeEmail'            => $formChangeEmail->createView(),
           'formChangePassword'         => $formChangePassword->createView(),
           'observationNotValidated'    => $observationsNotValidated
       ));
   }


   public function editEmail(Request $request, $user, $formChangeEmail){
        $dispatcher = $this->dipatcher($user, $request);

        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        $event = new FormEvent($formChangeEmail, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);
        $userManager->updateUser($user);

        if (null === $response = $event->getResponse()) {
            $url = $this->generateUrl('fos_user_profile_edit');
            $response = new RedirectResponse($url);}$dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

        return $response;
    }


    public function editPasword(Request $request, $user, $formChangePassword) {
        $dispatcher = $this->dipatcher($user, $request);

        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        $event = new FormEvent($formChangePassword , $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);
        $userManager->updateUser($user);
        if (null === $response = $event->getResponse()) {
            $url = $this->generateUrl('fos_user_profile_edit');
            $response = new RedirectResponse($url);
        }
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

        return $response;
    }

    public function editInfoUser(Request $request, $user, $formAddUser) {
        $dispatcher = $this->dipatcher($user, $request);
        /** @var $userManager UserManagerInterface */
        if ($user->getPicture()) {
            $user->getPicture()->upload('uploads');
        }

        $userManager = $this->get('fos_user.user_manager');
        $event = new FormEvent($formAddUser, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);
        $userManager->updateUser($user);

        if (null === $response = $event->getResponse()) {
            $url = $this->generateUrl('fos_user_profile_edit');
            $response = new RedirectResponse($url);
        }
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

        return $response;
    }

   public function dipatcher($user, $request) {
       /** @var $dispatcher EventDispatcherInterface */
       $dispatcher = $this->get('event_dispatcher');
       $event = new GetResponseUserEvent($user, $request);
       $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);
       if (null !== $event->getResponse()) {
           return $this->event->getResponse();
       }
       return $dispatcher;
   }



}