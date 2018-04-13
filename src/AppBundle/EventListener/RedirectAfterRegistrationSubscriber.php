<?php

namespace AppBundle\EventListener;

use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class RedirectAfterRegistrationSubscriber
 * @package AppBundle\EventListener
 * @author  El bouni Radouan <relbouni69@gmail.com>
 * this class redirects to the profile_edit page after a subscription
 */

class RedirectAfterRegistrationSubscriber implements EventSubscriberInterface

{

    private $router;


    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;

    }



    public function onRegistrationSuccess(FormEvent $event)
    {


            $url = $this->router->generate('profile_edit');
            $response = new RedirectResponse($url);
            $event->setResponse($response);


    }


    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess',

        );
    }

}

