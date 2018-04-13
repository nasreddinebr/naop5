<?php
namespace AppBundle\Controller;


use AppBundle\Entity\Observation;
use AppBundle\Entity\Picture;
use AppBundle\Entity\Users;
use AppBundle\Form\PictureType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ObservationController extends Controller
{
    /**
     * @Route("/add_observation", name="add_observation")
     */
    public function addAction(Request $request) {
        $picture = new Picture();
        $observation = new Observation();

        // Send today's date to the form
        $picture->setObservation($observation->setObservationDate(new \DateTime()));
        $form = $this->createForm(PictureType::class,$picture);
        $em = $this->getDoctrine()->getManager();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            // We check if the connected user is a naturalist, and we reset the parameter $isValid = true.
            if ($this->get('security.authorization_checker')->isGranted('ROLE_NATURALIST')) {
                $observation->setIsValid(true);
            }
            // We recover the bird by his tlName.
            $bird = $em
                ->getRepository('AppBundle:Aves')
                ->findOneByTlName(trim(strtolower(substr(strrchr($picture->getObservation()->getAves()->getTlName(), '|'), 1))));
            $observation->hydrate($this->getUser(), $bird);
            $picture->setObservation($observation);

            ($picture->getFile()) ? $picture->upload('img') ?: $em->persist($picture) : $em->persist($observation);
            $em->flush();

            // We check if the connected user is not a naturalist,
            if (!$this->get('security.authorization_checker')->isGranted('ROLE_NATURALIST')) {
                // Service: Send Email Notification to all naturalist
                $serviceSendMail = $this->container->get('mail_notification');
                $serviceSendMail->sendMailNotification($this->getUser(), $picture);
                return $this->render('Core/observation_confirmation.html.twig');
            }

            return $this->render('Core/observation_naturalist_confirmation.html.twig');
        }

        return $this->render('Core/add_observation.html.twig', array(
            'form'  => $form->createView()
        ));
    }


    /**
     * @Route("/search-for-observation",name="search_for_observation")
     *
     * @return Response
     */
    public function searcheFromTermAction (Request $request){
        // Recuperate search results
        // Escapes special characters in a string
        $link = "";
        if (!empty($request->request)) {
            // Escapes special characters in a string
            $characters = $request->request->get('q');
            $results = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('AppBundle:Aves')
                ->findByName($characters);

            // If no results were found
            if (empty($results))
                return new Response("<li>Aucune espèce trouvée</li>");

            // Create the response and return it
            foreach ($results as $result) {
                $link .= '<li class="list-group-item result">' . $result->getNameVern() . ' | '
                    . $result->getTlName() .
                    '</li>';
            }
        }
        return new Response($link);

    }

    /**
     * @Route("/observation/validate/{id}",name="observationValidate",requirements={"id"="\d+"})
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function validateAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();

        $observation= $em->getRepository('AppBundle:Observation')->findOneById($id);
        $observation->setIsValid(true);
        $em->flush();

        $session= $request->getSession();
        $session->getFlashBag()->add('success','Oservation validée avec succès.');

        return $this->redirectToRoute('profile_edit');
    }

    /**
     * @Route("/observation/edit/{id}",name="observationEdit",requirements={"id"="\d+"})
     * @param $id
     * @param Request $request
     * @return Response
     */
    public function editObsAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $observation= $em->getRepository('AppBundle:Observation')->findOneById($id);
        $picture = $em->getRepository('AppBundle:Picture')->findOneByObservation($id);

        if (!$picture){
            $picture = new Picture();
            $picture->setObservation($observation);
        }

        $form = $this->createForm(PictureType::class,$picture);
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            // We check if a file has been uploaded
            if ($form->getData()->getFile()) {
                // We check if an image already exists or not,
                if (!$picture->getName()){
                    $picture->upload('img');
                    $em->persist($picture);
                }else {
                    $actualName = $picture->getName();
                    unlink('img/'.$actualName);
                    $picture->upload('img');
                }
            }
            $em->flush();

            $session= $request->getSession();
            $session->getFlashBag()->add('success','L\'observation à été modifié avec succès.');
            return $this->redirectToRoute('profile_edit');
        }
        return $this->render('Core/edit_observation.html.twig', array(
           'form'       => $form->createView(),
           'picture'    => $picture
        ));
    }

    /**
     * @Route("/observation/remove/{id}",name="observationRemove",requirements={"id"="\d+"})
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $observation= $em->getRepository('AppBundle:Observation')->findOneById($id);
        $picture = $em->getRepository('AppBundle:Picture')->findOneByObservation($id);

        if ($picture) {
            $pictureName = $picture->getName();
            unlink('img/'.$pictureName);
            $em->remove($picture);
        }
        $em->remove($observation);
        $em->flush();

        $session= $request->getSession();
        $session->getFlashBag()->add('success','Oservation supprimer avec succès.');

        return $this->redirectToRoute('profile_edit');
    }

}
