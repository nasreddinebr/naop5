<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * News
 *
 * @ORM\Table(name="tl_news")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NewsRepository")
 */
class News
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
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotBlank(message="Ajouter un Titre de l'article")
     * @Assert\Length(
     *     min = 5,
     *     max = 80
     * )
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="news_date", type="datetime")
     * @Assert\DateTime()
     */
    private $newsDate;

    /**
     * @var string
     *
     * @ORM\Column(name="post", type="text")
     * @Assert\Length(
     *     min = 250,
     *     minMessage = "Un article doit obligatoirement contenir au moin 250 caractéres"
     * )
     */
    private $post;

    /**
     * @var bool
     *
     * @ORM\Column(name="published", type="boolean", nullable=true)
     */
    private $published;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Users" , inversedBy="news")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Picture", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $picture;

    /**
     * Constructor
     *
     */
    public function __construct()
    {
        //$this->pictures = new ArrayCollection();
        $this->newsDate = new \Datetime('now');
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
     * Set title
     *
     * @param string $title
     *
     * @return News
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set newsDate
     *
     * @param \DateTime $newsDate
     *
     * @return News
     */
    public function setNewsDate($newsDate)
    {
        $this->newsDate = $newsDate;

        return $this;
    }

    /**
     * Get newsDate
     *
     * @return \DateTime
     */
    public function getNewsDate()
    {
        return $this->newsDate;
    }

    /**
     * Set post
     *
     * @param string $post
     *
     * @return News
     */
    public function setPost($post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return string
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return News
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return bool
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\Users $user
     *
     * @return News
     */
    public function setUser(Users $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\Users
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set picture.
     *
     * @param \AppBundle\Entity\Picture $picture
     *
     * @return News
     */
    public function setPicture(\AppBundle\Entity\Picture $picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture.
     *
     * @return \AppBundle\Entity\Picture
     */
    public function getPicture()
    {
        return $this->picture;
    }
}
