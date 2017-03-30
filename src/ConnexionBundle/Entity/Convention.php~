<?php

namespace ConnexionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Convention
 *
 * @ORM\Table(name="Convention")
 * @ORM\Entity(repositoryClass="ConnexionBundle\Repository\ConventionRepository")
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
     * One Convention has One Type.
     * @ORM\OneToOne(targetEntity="Type")
     */
    private $type;

    /**
     * Many Conventions have One Promotion.
     * @ORM\ManyToOne(targetEntity="Promotion", inversedBy="lesConventions")
     */
    private $promotion;


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
     * @param string $promotion
     * @return Convention
     */
    public function setPromotion($promotion)
    {
        $this->promotion = $promotion;

        return $this;
    }

    /**
     * Get promotion
     *
     * @return string 
     */
    public function getPromotion()
    {
        return $this->promotion;
    }
}
