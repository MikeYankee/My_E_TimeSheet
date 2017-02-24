<?php

namespace ConnexionBundle\Entity\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Convention
 *
 * @ORM\Table(name="entity_convention")
 * @ORM\Entity(repositoryClass="ConnexionBundle\Repository\Entity\ConventionRepository")
 */
class Convention
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
     * @ORM\Column(name="prixHeure", type="decimal", precision=10, scale=2)
     */
    private $prixHeure;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="promo", type="string", length=255)
     */
    private $promo;


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
     * Set prixHeure
     *
     * @param string $prixHeure
     * @return Convention
     */
    public function setPrixHeure($prixHeure)
    {
        $this->prixHeure = $prixHeure;

        return $this;
    }

    /**
     * Get prixHeure
     *
     * @return string 
     */
    public function getPrixHeure()
    {
        return $this->prixHeure;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Convention
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set promo
     *
     * @param string $promo
     * @return Convention
     */
    public function setPromo($promo)
    {
        $this->promo = $promo;

        return $this;
    }

    /**
     * Get promo
     *
     * @return string 
     */
    public function getPromo()
    {
        return $this->promo;
    }
}
