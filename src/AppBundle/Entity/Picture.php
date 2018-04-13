<?php

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Picture
 *
 * @ORM\Table(name="tl_picture")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PictureRepository")
 */
class Picture
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
     *
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Observation", inversedBy="pictures",cascade={"persist", "remove"})
     */
    private $observation;

    /**
     * @Assert\Image()
     */
    private $file;

    /**
     * Get id
     *
     * @return integer
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
     * @return Picture
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
     * Set url
     *
     * @param string $url
     *
     * @return Picture
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set alt
     *
     * @param string $alt
     *
     * @return Picture
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set observation
     *
     * @param \AppBundle\Entity\Observation $observation
     *
     * @return Picture
     */
    public function setObservation(Observation $observation = null)
    {
        $this->observation = $observation;

        return $this;
    }

    /**
     * Get observation
     *
     * @return Observation
     */
    public function getObservation()
    {
        return $this->observation;
    }

    /**
     * Set file
     * @param $file
     * @return $this
     */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    public function upload($uploadRootDir){
        //If there is no file, we do nothing.
        if (null === $this->file) {
            return;
        }

        // We recover the original name of the uploaded file.
        $tmpName = $this->file->getClientOriginalName($uploadRootDir);
        $fileName = md5(uniqid()).'.'.$this->file->guessExtension();

        // We move the file to the 'web / img' directory.
        $this->file->move($this->getUploadRootDir($uploadRootDir), $fileName);
        $this->setName($fileName);
        $this->setAlt($tmpName);
        $this->setUrl($uploadRootDir);
    }

    /*public function getUploadDir() {
        // We return the relative path to the image for a browser (relative to the directory / web).
        return 'img';
    }*/

    public function getUploadRootDir($uploadDir){
        // We return the relative path to the image for PHP code.
        //return __DIR__.'/../../../web/'.$this->getUploadDir();
        return __DIR__.'/../../../web/'.$uploadDir;
    }
}
