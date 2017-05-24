<?php

namespace ConnexionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Type
 *
 * @ORM\Table(name="Type")
 * @ORM\Entity(repositoryClass="ConnexionBundle\Repository\TypeRepository")
 */
class Type
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
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;

    /**
     * One Type has Many Cours.
     * @ORM\OneToMany(targetEntity="Cours", mappedBy="type")
     */
    private $lesCours;

    /**
     * One Type has Many Conventions.
     * @ORM\OneToMany(targetEntity="Convention", mappedBy="type")
     */
    private $lesConventions;


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
     * Set libelle
     *
     * @param string $libelle
     * @return Type
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * To string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->libelle;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lesCours = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add lesCours
     *
     * @param \ConnexionBundle\Entity\Cours $lesCours
     * @return Type
     */
    public function addLesCour(\ConnexionBundle\Entity\Cours $lesCours)
    {
        $this->lesCours[] = $lesCours;

        return $this;
    }

    /**
     * Remove lesCours
     *
     * @param \ConnexionBundle\Entity\Cours $lesCours
     */
    public function removeLesCour(\ConnexionBundle\Entity\Cours $lesCours)
    {
        $this->lesCours->removeElement($lesCours);
    }

    /**
     * Get lesCours
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLesCours()
    {
        return $this->lesCours;
    }
}
