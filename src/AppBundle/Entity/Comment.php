<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Comment
 *
 * @ORM\Table(name="tl_comment")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommentRepository")
 */
class Comment
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
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="comment_date", type="datetime")
     */
    private $commentDate;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     * @Assert\NotBlank(message = "Vous devez entrer un commentaire")
     * @Assert\Length(
     *     min = 10,
     *     max = 350,
     *     minMessage="Le commentaire doit contenir 10 caractaires minimum",
     *     maxMessage="Le commentaire ne doit pas dépasser 350 caractaires"
     * )
     */
    private $content;

    /**
     * @var bool
     *
     * @ORM\Column(name="readed", type="boolean",nullable=true)
     */
    private $readed;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\News")
     * @ORM\JoinColumn(nullable=false)
     */
    private $news;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->readed = false;
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
     * Set author
     *
     * @param string $author
     *
     * @return Comment
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set commentDate
     *
     * @param \DateTime $commentDate
     *
     * @return Comment
     */
    public function setCommentDate($commentDate)
    {
        $this->commentDate = $commentDate;

        return $this;
    }

    /**
     * Get commentDate
     *
     * @return \DateTime
     */
    public function getCommentDate()
    {
        return $this->commentDate;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Comment
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set readed
     *
     * @param boolean $readed
     *
     * @return Comment
     */
    public function setReaded($readed)
    {
        $this->readed = $readed;

        return $this;
    }

    /**
     * Get readed
     *
     * @return bool
     */
    public function getReaded()
    {
        return $this->readed;
    }

    /**
     * Set news
     *
     * @param \AppBundle\Entity\News $news
     *
     * @return Comment
     */
    public function setNews(News $news)
    {
        $this->news = $news;

        return $this;
    }

    /**
     * Get news
     *
     * @return \AppBundle\Entity\News
     */
    public function getNews()
    {
        return $this->news;
    }
    

    /**
     * Set user
     *
     * @param \AppBundle\Entity\Users $user
     *
     * @return Comment
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

    public function hydrate(Users $user, News $news) {
        $this->setAuthor($user->getUsername());
        $this->setCommentDate(date_create('now'));
        $this->setNews($news);
        $this->setUser($user);
    }
}
