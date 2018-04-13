<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Form\ContactFormType;
use AppBundle\Form\CommentFormType;
use Symfony\Component\HttpFoundation\Request;
use Twig_Extensions_Extension_Text;


class CoreController extends Controller
{
    /**
     * @Route("/",name="home")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction()
    {
        $obsPicture = array();
        $today = date_create('now')->format('Y-m-d H:i:s');
        $repository = $this->getDoctrine()->getManager();

        // Retrieve the news
        $news = $repository->getRepository('AppBundle:News')->findByNewsDate($today);

        // Retrieve the observations
        $observations = $repository->getRepository('AppBundle:Observation')->findByObsDate($today);

        foreach ($observations as $observation){
            $obsPicture[] = $repository->getRepository('AppBundle:Picture')
                ->findOneByObservation($observation->getId());
        }

        return $this->render('Core/home.html.twig',array(
            'news'         => $news,
            'observations' => $observations,
            'obsPicture'   => $obsPicture
        ));
    }

    /**
     * @Route("/association",name="association")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function associationAction()
    {
        return $this->render('Core/association.html.twig');
    }

    /**
     * @Route("/landing",name="landing")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function landingAction()
    {
        return $this->render('Core/landing.html.twig');
    }

    /**
     * @Route("/news/{page}", name="news")
     * @param $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newsAction($page,Request $request)
    {
        $newsTotal = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:News')
            ->findNbNews();

        $pagesTotal = ceil($newsTotal[1]/6);
        $testPage = $request->query->get('page',$page);
        
        if  (isset($testPage)
            and !empty($testPage)
            and ($testPage > 0)
            and ($testPage <= $pagesTotal)
            )
                    {
                    $curentPage = intval($testPage);
                    }else {
                    $curentPage = 1;
        }

        // Retrieve the 6 news

        $news = $this->getDoctrine()
            ->getManager()->getRepository('AppBundle:News')
            ->find6News($curentPage);

        return $this->render('Core/news.html.twig',array(
            'news'         => $news,
            'page'         => $curentPage,
            'pageTotal'    => $pagesTotal
        ));

    }

    /**
     * @Route("/article/{id}",name="article", requirements={"id"="\d+"})
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function articleAction($id, Request $request)
    {
        $comment = new Comment();
        $user = $this->getUser();
        $em= $this->getDoctrine()->getManager();

        // Retrieve the article
        $news = $em->getRepository('AppBundle:News')->findOneById($id);
        // Retrieve all comment by news
        $artComments = $em->getRepository('AppBundle:Comment')->findByNews($id);

        $form = $this->createForm(commentFormType::class, $comment);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $comment->hydrate($user, $news);
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('article', array('id'=>$id));
        }
        return $this->render('Core/article.html.twig', array(
            'commentForm'   => $form->createView(),
            'article'       => $news,
            'artComments'   => $artComments,
        ));
    }


    /**
     * @Route("/contact",name="contact")
     * @param $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contactAction(Request $request)
    {
        /* Form */
        $form = $this->createForm(contactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            /* recording contact */
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            //Sending email to naturalists
            $serviceSendMail = $this->container->get('mail_notification');
            $serviceSendMail->sendMailContact($contact);

            $this->get('session')->getFlashBag()->add('success', 'Votre message a bien été envoyé');
            return $this->redirect($this->generateUrl('contact'));
        }

        return $this->render('Core/contact.html.twig', ['contactForm' => $form->createView()]);
    }

    /**
     * @Route("/mentions_legales", name="mentionsLegales")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mentionsLegalesAction() {
        return $this->render('Core/mentions_legales.html.twig');
    }
}
