<?php
// src/AppBundle/Entity/Users.php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="tl_user")
 */
class Users extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
    * @ORM\Column(name="name", type="string", length=255, nullable=true)
    */
    private $name;

    /**
    * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
    */
    private $firstname;

    /**
    * @ORM\Column(name="profession", type="string", length=255, nullable=true)
    */
    private $profession;

    /**
    * @ORM\Column(name="isnaturalist", type="boolean", nullable=true)
    */
    private $isnaturalist;

    /**
    * @var \DateTime
    * @ORM\Column(name="birthday", type="datetime", nullable=true)
    */
    private $birthday;

    /**
     * @ORM\Column(name="facebook_id", type="string", length=255, nullable=true)
     */
    private $facebook_id;

    /**
     * @ORM\Column(name="facebook_access_token", type="string", length=255, nullable=true)
     */
    private $facebook_access_token;

    /**
     * @ORM\Column(name="google_id", type="string", length=255, nullable=true)
     */
    private $google_id;

    /**
     * @ORM\Column(name="google_access_token", type="string", length=255, nullable=true)
     */
    private $google_access_token;

    /**
     * @ORM\Column(name="twitter_id", type="string", length=255, nullable=true)
     */
    private $twitter_id;

    /**
     * @ORM\Column(name="twitter_access_token", type="string", length=255, nullable=true)
     */
    private $twitter_access_token;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Observation", mappedBy="users", cascade={"remove"})
     */
    private $observations;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\News" ,mappedBy="user", cascade={"remove"})
     */
    private $news;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Picture", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $picture;

    /**
     * Set name.
     *
     * @param string|null $name
     *
     * @return Users
     */
    public function setName($name = null)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set firstname.
     *
     * @param string|null $firstname
     *
     * @return Users
     */
    public function setFirstname($firstname = null)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname.
     *
     * @return string|null
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set profession.
     *
     * @param string|null $profession
     *
     * @return Users
     */
    public function setProfession($profession = null)
    {
        $this->profession = $profession;

        return $this;
    }

    /**
     * Get profession.
     *
     * @return string|null
     */
    public function getProfession()
    {
        return $this->profession;
    }

    /**
     * Set isnaturalist.
     *
     * @param bool|null $isnaturalist
     *
     * @return Users
     */
    public function setIsnaturalist($isnaturalist = null)
    {
        $this->isnaturalist = $isnaturalist;

        return $this;
    }

    /**
     * Get isnaturalist.
     *
     * @return bool|null
     */
    public function getIsnaturalist()
    {
        return $this->isnaturalist;
    }

    /**
     * Set birthday.
     *
     * @param \DateTime|null $birthday
     *
     * @return Users
     */
    public function setBirthday($birthday = null)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday.
     *
     * @return \DateTime|null
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set facebookId.
     *
     * @param string|null $facebookId
     *
     * @return Users
     */
    public function setFacebookId($facebookId = null)
    {
        $this->facebook_id = $facebookId;

        return $this;
    }

    /**
     * Get facebookId.
     *
     * @return string|null
     */
    public function getFacebookId()
    {
        return $this->facebook_id;
    }

    /**
     * Set facebookAccessToken.
     *
     * @param string|null $facebookAccessToken
     *
     * @return Users
     */
    public function setFacebookAccessToken($facebookAccessToken = null)
    {
        $this->facebook_access_token = $facebookAccessToken;

        return $this;
    }

    /**
     * Get facebookAccessToken.
     *
     * @return string|null
     */
    public function getFacebookAccessToken()
    {
        return $this->facebook_access_token;
    }

    /**
     * Set googleId.
     *
     * @param string|null $googleId
     *
     * @return Users
     */
    public function setGoogleId($googleId = null)
    {
        $this->google_id = $googleId;

        return $this;
    }

    /**
     * Get googleId.
     *
     * @return string|null
     */
    public function getGoogleId()
    {
        return $this->google_id;
    }

    /**
     * Set googleAccessToken.
     *
     * @param string|null $googleAccessToken
     *
     * @return Users
     */
    public function setGoogleAccessToken($googleAccessToken = null)
    {
        $this->google_access_token = $googleAccessToken;

        return $this;
    }

    /**
     * Get googleAccessToken.
     *
     * @return string|null
     */
    public function getGoogleAccessToken()
    {
        return $this->google_access_token;
    }

    /**
     * Set twitterId.
     *
     * @param string|null $twitterId
     *
     * @return Users
     */
    public function setTwitterId($twitterId = null)
    {
        $this->twitter_id = $twitterId;

        return $this;
    }

    /**
     * Get twitterId.
     *
     * @return string|null
     */
    public function getTwitterId()
    {
        return $this->twitter_id;
    }

    /**
     * Set twitterAccessToken.
     *
     * @param string|null $twitterAccessToken
     *
     * @return Users
     */
    public function setTwitterAccessToken($twitterAccessToken = null)
    {
        $this->twitter_access_token = $twitterAccessToken;

        return $this;
    }

    /**
     * Get twitterAccessToken.
     *
     * @return string|null
     */
    public function getTwitterAccessToken()
    {
        return $this->twitter_access_token;
    }

    /**
     * Add observation.
     *
     * @param \AppBundle\Entity\Observation $observation
     *
     * @return Users
     */
    public function addObservation(\AppBundle\Entity\Observation $observation)
    {
        $this->observations[] = $observation;
        $observation->setUsers($this);
        return $this;
    }

    /**
     * Remove observation.
     *
     * @param \AppBundle\Entity\Observation $observation
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeObservation(\AppBundle\Entity\Observation $observation)
    {
        $this->observations->removeElement($observation);
    }

    /**
     * Get observations.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getObservations()
    {
        return $this->observations;
    }

    /**
     * Add news.
     *
     * @param \AppBundle\Entity\News $news
     *
     * @return Users
     */
    public function addNews(\AppBundle\Entity\News $news)
    {
        $this->news[] = $news;

        return $this;
    }

    /**
     * Remove news.
     *
     * @param \AppBundle\Entity\News $news
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeNews(\AppBundle\Entity\News $news)
    {
        return $this->news->removeElement($news);
    }

    /**
     * Get news.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNews()
    {
        return $this->news;
    }

    /**
     * Set picture.
     *
     * @param \AppBundle\Entity\Picture|null $picture
     *
     * @return Users
     */
    public function setPicture(\AppBundle\Entity\Picture $picture = null)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture.
     *
     * @return \AppBundle\Entity\Picture|null
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param $role
     * @param EntityManager $em
     * @return array
     */
    public function findEmailByUserRole($role, EntityManager $em){
        // Connect to the database and recover all users
        // who have the naturalistic role.
        $classMetaData = new ORM\ClassMetadata(Users::class);
        $entityReposytory = new EntityRepository($em, $classMetaData);
        $queryBuilder = $entityReposytory->createQueryBuilder('u');
        $queryBuilder
            ->where('u.roles LIKE :role')
            ->setParameter('role', "%$role%");
        $usersRolesNaturalist = $queryBuilder->getQuery()->getResult();

        return $usersRolesNaturalist;
    }

    public function findAllUsers(EntityManager $em) {
        $entityRepository = $this->entityRepository($em);
        $queryBuilder = $entityRepository
            ->createQueryBuilder('u')
            ->leftJoin('u.picture', 'pic')
            ->addSelect('pic');
        $users = $queryBuilder->getQuery()->getResult();

        return $users;
    }

    public function entityRepository(EntityManager $em){
        $classMetaData = new ORM\ClassMetadata(Users::class);
        $entityReposytory= new EntityRepository($em, $classMetaData);
        return$entityReposytory;
    }
}
