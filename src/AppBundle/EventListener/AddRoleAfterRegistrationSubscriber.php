<?php
/**
 * Created by PhpStorm.
 * User: radoncode
 * Date: 03/01/18
 * Time: 11:49
 */

namespace AppBundle\EventListener;



use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AddRoleAfterRegistrationSubscriber implements EventSubscriberInterface
{

    public function onRegistrationSuccess(FormEvent $event)
    {
        $user = $event->getForm()->getData();
        $user->setRoles(array('ROLE_PARTICULAR'));

    }

    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess',
        );
    }
}