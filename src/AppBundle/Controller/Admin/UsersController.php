<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;



/**
 * User controller.
 *
 * @Route("admin")
 */
class UsersController extends Controller
{
    /**
     * Lists all user entities.
     *
     * @Route("/", name="admin_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this
            ->getDoctrine()
            ->getManager();
        $users = new Users();
        $allUsers = $users->findAllUsers($em);
        return $this->render('CoreAdmin/users/index.html.twig', array(
            'users' => $allUsers,
        ));
    }


    /**
     * Creates a new user entity.
     * @Route("/new", name="admin_new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $user = new Users();
        $form = $this->createForm('AppBundle\Form\Admin\UsersType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user->setRoles(array($request->request->get('roles')));
            $user->setEnabled(1);
            $em->persist($user);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice-new', 'L\'utilisateur a bien été crée.');
            return $this->redirectToRoute('admin_show', array('id' => $user->getId()));
        }

        return $this->render('CoreAdmin/users/new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/{id}", name="admin_show")
     * @Method("GET")
     */
    public function showAction(Users $user)
    {
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('CoreAdmin/users/show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/{id}/edit", name="admin_edit")
     * @param Request $request
     * @param Users $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Users $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('AppBundle\Form\Admin\UsersEditType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em =  $this->getDoctrine()->getManager();

            if ($request->request->get('roles') != 'Aucun'){
                $user->setRoles(array($request->request->get('roles')));
            }

            $em->persist($user);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice-edit', 'L\'utilisateur a bien été modifié.');
            return $this->redirectToRoute('admin_edit', array('id' => $user->getId()));
        }

        return $this->render('CoreAdmin/users/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a user entity.
     *
     * @Route("/{id}", name="admin_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Users $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($user->getPicture()){
                unlink('uploads/' . $user->getPicture()->getName());
            }

            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('admin_index');
    }

    /**
     * Creates a form to delete a user entity.
     *
     * @param Users $user The user entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Users $user)
    {

        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
