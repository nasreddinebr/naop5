<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/23/18
 * Time: 1:09 AM
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NewsLetterController extends Controller
{
    /**
     * @Route("/subscribe-newsletter", name="subscribe-newsletters")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mailChimpSubscribeAction(Request $request) {
        if ($request->isMethod('POST') && !empty($request->request->get('email'))){
            $email = $request->request->get('email');

            // Subscription service to the newsletter.
            $serviceSubscribe = $this->container->get('newsletter_subscribe');
            $render = $serviceSubscribe->subscribe($email);

            return $this->render($render->view, $render->parameters);
        }
        $title = "E-mail erreur";
        $content = 'Un problème est survenu, veuillez entrer une adresse mail valide.';
        return $this->render('Core/newsletter_confirmation.html.twig',array(
            'title'     => $title,
            'content'   => $content
        ));
    }
}