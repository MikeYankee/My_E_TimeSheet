<?php

namespace ConnexionBundle\Entity\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Matiere
 *
 * @ORM\Table(name="entity_matiere")
 * @ORM\Entity(repositoryClass="ConnexionBundle\Repository\Entity\MatiereRepository")
 */
class Matiere
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
     * @var float
     *
     * @ORM\Column(name="nbHeuresMaquetteCours", type="float")
     */
    private $nbHeuresMaquetteCours;

    /**
     * @var float
     *
     * @ORM\Column(name="nbHeuresMaquetteTD", type="float")
     */
    private $nbHeuresMaquetteTD;

    /**
     * @var float
     *
     * @ORM\Column(name="nbHeuresMaquetteExam", type="float")
     */
    private $nbHeuresMaquetteExam;

    /**
     * @var float
     *
     * @ORM\Column(name="nbHeuresMaquetteSoutenance", type="float")
     */
    private $nbHeuresMaquetteSoutenance;

    /**
     * @var string
     *
     * @ORM\Column(name="lesCours", type="string", length=255)
     */
    private $lesCours;

    /**
     * @var string
     *
     * @ORM\Column(name="promo", type="string", length=255)
     */
    private $promo;

    /**
     * @var string
     *
     * @ORM\Column(name="lesEnseignants", type="string", length=255)
     */
    private $lesEnseignants;


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
     * @return Matiere
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
     * Set nbHeuresMaquetteCours
     *
     * @param float $nbHeuresMaquetteCours
     * @return Matiere
     */
    public function setNbHeuresMaquetteCours($nbHeuresMaquetteCours)
    {
        $this->nbHeuresMaquetteCours = $nbHeuresMaquetteCours;

        return $this;
    }

    /**
     * Get nbHeuresMaquetteCours
     *
     * @return float 
     */
    public function getNbHeuresMaquetteCours()
    {
        return $this->nbHeuresMaquetteCours;
    }

    /**
     * Set nbHeuresMaquetteTD
     *
     * @param float $nbHeuresMaquetteTD
     * @return Matiere
     */
    public function setNbHeuresMaquetteTD($nbHeuresMaquetteTD)
    {
        $this->nbHeuresMaquetteTD = $nbHeuresMaquetteTD;

        return $this;
    }

    /**
     * Get nbHeuresMaquetteTD
     *
     * @return float 
     */
    public function getNbHeuresMaquetteTD()
    {
        return $this->nbHeuresMaquetteTD;
    }

    /**
     * Set nbHeuresMaquetteExam
     *
     * @param float $nbHeuresMaquetteExam
     * @return Matiere
     */
    public function setNbHeuresMaquetteExam($nbHeuresMaquetteExam)
    {
        $this->nbHeuresMaquetteExam = $nbHeuresMaquetteExam;

        return $this;
    }

    /**
     * Get nbHeuresMaquetteExam
     *
     * @return float 
     */
    public function getNbHeuresMaquetteExam()
    {
        return $this->nbHeuresMaquetteExam;
    }

    /**
     * Set nbHeuresMaquetteSoutenance
     *
     * @param float $nbHeuresMaquetteSoutenance
     * @return Matiere
     */
    public function setNbHeuresMaquetteSoutenance($nbHeuresMaquetteSoutenance)
    {
        $this->nbHeuresMaquetteSoutenance = $nbHeuresMaquetteSoutenance;

        return $this;
    }

    /**
     * Get nbHeuresMaquetteSoutenance
     *
     * @return float 
     */
    public function getNbHeuresMaquetteSoutenance()
    {
        return $this->nbHeuresMaquetteSoutenance;
    }

    /**
     * Set lesCours
     *
     * @param string $lesCours
     * @return Matiere
     */
    public function setLesCours($lesCours)
    {
        $this->lesCours = $lesCours;

        return $this;
    }

    /**
     * Get lesCours
     *
     * @return string 
     */
    public function getLesCours()
    {
        return $this->lesCours;
    }

    /**
     * Set promo
     *
     * @param string $promo
     * @return Matiere
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

    /**
     * Set lesEnseignants
     *
     * @param string $lesEnseignants
     * @return Matiere
     */
    public function setLesEnseignants($lesEnseignants)
    {
        $this->lesEnseignants = $lesEnseignants;

        return $this;
    }

    /**
     * Get lesEnseignants
     *
     * @return string 
     */
    public function getLesEnseignants()
    {
        return $this->lesEnseignants;
    }
}
