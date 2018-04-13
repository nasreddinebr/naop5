<?php

namespace AppBundle\Service;


use AppBundle\Entity\Picture;
use AppBundle\Entity\Users;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class MailNotification
{
    private $mailer;
    private $templating;
    private $doctrine;

    public function __construct(\Swift_Mailer $mailer, EngineInterface $templating, EntityManager $doctrine) {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->doctrine = $doctrine;
    }

    /**
     * @param Users $user
     * @param Picture $picture
     */
    public function sendMailNotification(Users $user, Picture $picture){
        $view= 'Core/email_notification_add_observation.html.twig';
        $subject = 'Une Observation à été ajoutée';
        $usr = new Users();
        $naturalistUsers = $usr->findEmailByUserRole("ROLE_NATURALIST", $this->doctrine);
        foreach ($naturalistUsers as $natUser) {
            $mailAdress = $natUser->getEmail();
            $parameters = array(
                'username'  => $user->getUserName(),
                'birdname'  => $picture->getObservation()->getAves()->getTlName(),
                'natuser'   => $natUser
            );
            $this->sendMailer($mailAdress, $view, $parameters, $subject);
        }
    }

    public function sendMailContact($contact){
        $mailAdress = 'riped.man@gmail.com';
        $view = 'Core/email_contact.html.twig';
        $parmeters = array('contact' => $contact);
        $this->sendMailer($mailAdress, $view, $parmeters, $contact->getSubject());
    }

    /**
     * @param $mailAdress
     * @param $view
     * @param $parameters
     * @param $subject
     */
    public function sendMailer($mailAdress, $view, $parameters, $subject){
        $mail = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom(array('berrachednasr@gmail.com' => 'Nos Amis les Oiseaux'))
            ->setTo($mailAdress)
            ->setCharset('utf-8')
            ->setContentType('text/html')
            ->setBody($this->templating->render($view, $parameters));
        $this->mailer->send($mail);
    }

}