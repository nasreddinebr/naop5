<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Aves
 *
 * @ORM\Table(name="tl_aves")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AvesRepository")
 */
class Aves
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
     * @ORM\Column(name="tlOrder", type="string", length=255)
     */
    private $tlOrder;

    /**
     * @var string
     *
     * @ORM\Column(name="family", type="string", length=255)
     */
    private $family;

    /**
     * @var string
     *
     * @ORM\Column(name="rank", type="string", length=6)
     */
    private $rank;

    /**
     * @var string
     *
     * @ORM\Column(name="tlName", type="string", length=255)
     */
    private $tlName;

    /**
     * @var string
     *
     * @ORM\Column(name="tlAuthor", type="string", length=255)
     */
    private $tlAuthor;

    /**
     * @var string
     *
     * @ORM\Column(name="nameVern", type="string", length=255, nullable=true)
     */
    private $nameVern;

    /**
     * @var string
     *
     * @ORM\Column(name="nameVernEng", type="string", length=255, nullable=true)
     */
    private $nameVernEng;

    /**
     * @var int
     *
     * @ORM\Column(name="habitat", type="integer")
     */
    private $habitat;


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
     * Set tlOrder
     *
     * @param string $tlOrder
     *
     * @return Aves
     */
    public function setTlOrder($tlOrder)
    {
        $this->tlOrder = $tlOrder;

        return $this;
    }

    /**
     * Get tlOrder
     *
     * @return string
     */
    public function getTlOrder()
    {
        return $this->tlOrder;
    }

    /**
     * Set family
     *
     * @param string $family
     *
     * @return Aves
     */
    public function setFamily($family)
    {
        $this->family = $family;

        return $this;
    }

    /**
     * Get family
     *
     * @return string
     */
    public function getFamily()
    {
        return $this->family;
    }

    /**
     * Set rank
     *
     * @param string $rank
     *
     * @return Aves
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank
     *
     * @return string
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set tlName
     *
     * @param string $tlName
     *
     * @return Aves
     */
    public function setTlName($tlName)
    {
        $this->tlName = $tlName;

        return $this;
    }

    /**
     * Get tlName
     *
     * @return string
     */
    public function getTlName()
    {
        return $this->tlName;
    }

    /**
     * Set tlAuthor
     *
     * @param string $tlAuthor
     *
     * @return Aves
     */
    public function setTlAuthor($tlAuthor)
    {
        $this->tlAuthor = $tlAuthor;

        return $this;
    }

    /**
     * Get tlAuthor
     *
     * @return string
     */
    public function getTlAuthor()
    {
        return $this->tlAuthor;
    }

    /**
     * Set nameVern
     *
     * @param string $nameVern
     *
     * @return Aves
     */
    public function setNameVern($nameVern)
    {
        $this->nameVern = $nameVern;

        return $this;
    }

    /**
     * Get nameVern
     *
     * @return string
     */
    public function getNameVern()
    {
        return $this->nameVern;
    }

    /**
     * Set nameVernEng
     *
     * @param string $nameVernEng
     *
     * @return Aves
     */
    public function setNameVernEng($nameVernEng)
    {
        $this->nameVernEng = $nameVernEng;

        return $this;
    }

    /**
     * Get nameVernEng
     *
     * @return string
     */
    public function getNameVernEng()
    {
        return $this->nameVernEng;
    }

    /**
     * Set habitat
     *
     * @param integer $habitat
     *
     * @return Aves
     */
    public function setHabitat($habitat)
    {
        $this->habitat = $habitat;

        return $this;
    }

    /**
     * Get habitat
     *
     * @return int
     */
    public function getHabitat()
    {
        return $this->habitat;
    }
}
