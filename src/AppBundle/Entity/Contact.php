<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Contact
 *
 * @ORM\Table(name="tl_contact")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContactRepository")
 */
class Contact
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank(message="Entrez votre nom s'il vous plait.")
     * @Assert\Length(
     *     min = 2,
     *     max = 35,
     *     minMessage="Saisire minimum 2 caractaires",
     *     maxMessage="Saisire maximum 35 caractaires"
     * )
     *
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     * @Assert\NotBlank(
     *     message="Entrez votre prénom s'il vous plait."
     * )
     * @Assert\Length(
     *     min = 2,
     *     max = 35,
     *     minMessage="Saisire minimum 2 caractaires",
     *     maxMessage="Saisire maximum 35 caractaires"
     * )
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\Email(
     *     message="{{ value }} n'est pas un email valide.",
     *     checkMX = true
     * )
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min = 5,
     *     max = 70,
     *     minMessage="Saisire minimum 5 caractaires",
     *     maxMessage="Saisire maximum 70 caractaires"
     * )
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     * @Assert\Length(
     *     min = 50,
     *     max = 400,
     *     minMessage="Message trop court 50 caractaires minimum",
     *     maxMessage="Message trop long 400 caractaires maximum"
     * )
     */
    private $message;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Contact
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Contact
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Contact
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Contact
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return Contact
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }
}
