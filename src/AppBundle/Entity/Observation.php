<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;


/**
 * Observation
 *
 * @ORM\Table(name="tl_observation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ObservationRepository")
 */
class Observation
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
     * @var \DateTime
     *
     * @ORM\Column(name="observation_date", type="datetime")
     */
    private $observationDate;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="decimal", precision=10, scale=8)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="decimal", precision=10, scale=8)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="observation_comment", type="string", length=1000)
     */
    private $observationComment;

    /**
     * @var bool
     * ORM\ManyToOne(targetEntity="AppBundle\Entity\Users", inversedBy="observations")
     * @ORM\Column(name="is_valid", type="boolean", nullable=true)
     */
    private $isValid;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Users", inversedBy="observations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Picture", mappedBy="observation",cascade={"remove"})
     */
    private $pictures;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Aves")
     * @ORM\JoinColumn(nullable=false)
     */
    private $aves;

    public function __construct()
    {
        $this->observationDate = new DateTime();
        $this->isValid = false;
    }


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
     * Set observationDate
     *
     * @param \DateTime $observationDate
     *
     * @return Observation
     */
    public function setObservationDate($observationDate)
    {
        $this->observationDate = $observationDate;

        return $this;
    }

    /**
     * Get observationDate
     *
     * @return \DateTime
     */
    public function getObservationDate()
    {
        return $this->observationDate;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     *
     * @return Observation
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     *
     * @return Observation
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set observationComment
     *
     * @param string $observationComment
     *
     * @return Observation
     */
    public function setObservationComment($observationComment)
    {
        $this->observationComment = $observationComment;

        return $this;
    }

    /**
     * Get observationComment
     *
     * @return string
     */
    public function getObservationComment()
    {
        return $this->observationComment;
    }

    

    /**
     * Set users
     *
     * @param \AppBundle\Entity\Users $users
     *
     * @return Observation
     */
    public function setUsers(Users $users)
    {
        $this->users = $users;

        return $this;
    }

    /**
     * Get users
     *
     * @return \AppBundle\Entity\Users
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set aves
     *
     * @param \AppBundle\Entity\Aves $aves
     *
     * @return Observation
     */
    public function setAves(Aves $aves)
    {
        $this->aves = $aves;

        return $this;
    }

    /**
     * Get aves
     *
     * @return \AppBundle\Entity\Aves
     */
    public function getAves()
    {
        return $this->aves;
    }

    /**
     * Add picture
     *
     * @param \AppBundle\Entity\Picture $picture
     *
     * @return Observation
     */
    public function addPicture(Picture $picture)
    {
        $this->pictures[] = $picture;
        $picture->setObservation($this);
        return $this;
    }

     /**
     * Set isValid
     *
     * @param boolean $isValide
     *
     * @return Observation
     */
    public function setIsValid($isValid)
    {
        $this->isValid = $isValid;


        return $this;
    }

    /**
     * Remove picture
     *
     * @param \AppBundle\Entity\Picture $picture
     */
    public function removePicture(Picture $picture)
    {
        $this->pictures->removeElement($picture);
    }

    /**
     * Get pictures
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPictures()
    {
        return $this->pictures;
    }

    /**
     * Get isValid
     *
     * @return boolean
     */
    public function getIsValid()
    {
        return $this->isValid;

    }

    public function hydrate(Users $user, Aves $aves) {
        $this->setUsers($user);
        $this->setAves($aves);
    }
}
