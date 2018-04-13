<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\News;
use AppBundle\Entity\Picture;
use AppBundle\Form\Admin\NewsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * News controller.
 *
 * @Route("admin")
 */
class NewsController extends Controller
{
    /**
     * Lists all news entities.
     *
     * @Route("/news", name="news_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $news = $em->getRepository('AppBundle:News')->findAll();

        return $this->render('CoreAdmin/news/index.html.twig', array(
            'news' => $news,
        ));
    }


    /**
     * Creates a new news entity.
     *
     * @Route("/news/new", name="news_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $news = new News();

        // initialize date
        $news->setNewsDate(date_create('now'));

        $form = $this->createForm(NewsType::class, $news);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();

            // if publiched change date
            if ($news->getPublished()){
                $news->setNewsDate(date_create('now'));
            }
            if ($news->getPicture()) {
                $news->getPicture()->upload('uploads');
            }

            $em->persist($news);
            $em->flush();

            return $this->redirectToRoute('news_show', array('id' => $news->getId()));
        }

        return $this->render('CoreAdmin/news/new.html.twig', array(
            'news' => $news,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a news entity.
     *
     * @Route("/news/show/{id}", name="news_show")
     * @Method("GET")
     */
    public function showAction(News $news)
    {
        $deleteForm = $this->createDeleteForm($news);

        return $this->render('CoreAdmin/news/show.html.twig', array(
            'news' => $news,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing news entity.
     *
     * @Route("/news/{id}/edit", name="news_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, News $news)
    {
        $deleteForm = $this->createDeleteForm($news);
        $editForm = $this->createForm('AppBundle\Form\Admin\NewsType', $news);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            // if publiched change date
            if ($news->getPublished()){
                $news->setNewsDate(date_create('now'));
                $this->getDoctrine()->getManager()->persist($news);
            }
            if ($news->getPicture()) {
                $news->getPicture()->upload('uploads');
            }

            $this->getDoctrine()->getManager()->flush();

            $session= $request->getSession();
            $session->getFlashBag()->add('success','L\'article à été modifié avec succès.');
            return $this->redirectToRoute('news_edit', array('id' => $news->getId()));
        }

        return $this->render('CoreAdmin/news/edit.html.twig', array(
            'news' => $news,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a news entity.
     *
     * @Route("/news/{id}", name="news_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, News $news)
    {
        $form = $this->createDeleteForm($news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $comments = $em
                ->getRepository('AppBundle:Comment')
                ->findByNews($news->getId());
            foreach ($comments as $comment) {
                $em->remove($comment);
            }

            if ($news->getPicture()){
                unlink('uploads/' . $news->getPicture()->getName());
            }

            $em->remove($news);
            $em->flush();
        }

        return $this->redirectToRoute('news_index');
    }

    /**
     * Creates a form to delete a news entity.
     *
     * @param News $news The news entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(News $news)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('news_delete', array('id' => $news->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
