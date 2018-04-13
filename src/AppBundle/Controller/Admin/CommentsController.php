<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/28/18
 * Time: 11:38 AM
 */

namespace AppBundle\Controller\Admin;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * User controller.
 *
 * @Route("admin")
 */
class CommentsController extends Controller
{

    /**
     * @Route("/unread-comments", name="unreadComments")
     * @return Response
     */
    public function allUnreadCommentsAction() {
        $em = $this
            ->getDoctrine()
            ->getManager();

        $unreadComments = $em
            ->getRepository('AppBundle:Comment')
            ->findAllUnreadComments();

        // TODO: a supprimer
        foreach ($unreadComments as $unreadComment) {
            $new = $em
                ->getRepository('AppBundle:News')
                ->findOneById($unreadComment->getNews());
        }

        return $this->render('CoreAdmin/comments/comments.html.twig', array(
            'comments'      => $unreadComments
        ));
    }

    /**
     * @Route("/comment-read/{id}", name="comment_read", requirements={"id"="\d+"})
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function readCommentAction($id, Request $request) {
        $em = $this
            ->getDoctrine()
            ->getManager();
        $comment = $em
            ->getRepository('AppBundle:Comment')
            ->findOneById($id);
        $comment->setReaded(true);
        $em->flush();

        $session = $request->getSession();
        $session->getFlashBag()->add('success','Le commentaire à été marquer comme lu.');

        return $this->redirectToRoute('unreadComments');

    }


    /**
     * @Route("/comment-delete/{id}", name="comment_delete", requirements={"id"="\d+"})
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteCommentAction($id, Request $request) {
        $em = $this
            ->getDoctrine()
            ->getManager();
        $comment = $em
            ->getRepository('AppBundle:Comment')
            ->findOneById($id);

        $em->remove($comment);
        $em->flush();

        $session = $request->getSession();
        $session->getFlashBag()->add('success','Le commentaire à été supprimer avec succèss.');

        return $this->redirectToRoute('unreadComments');
    }


}