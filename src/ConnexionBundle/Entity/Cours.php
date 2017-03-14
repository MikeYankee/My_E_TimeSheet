<?php

namespace ConnexionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cours
 *
 * @ORM\Table(name="Cours")
 * @ORM\Entity(repositoryClass="ConnexionBundle\Repository\CoursRepository")
 */
class Cours
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
     * @ORM\Column(name="horaire", type="datetime")
     */
    private $horaire;

    /**
     * @var bool
     *
     * @ORM\Column(name="enseignantAbsent", type="boolean")
     */
    private $enseignantAbsent;

    /**
     * @var bool
     *
     * @ORM\Column(name="estValide", type="boolean")
     */
    private $estValide;

    /**
     * Many Cours have One Enseignant.
     * @ORM\ManyToOne(targetEntity="User", inversedBy="lesCoursEnseignants")
     */
    private $enseignant;

    /**
     * Many Cours have One Matiere.
     * @ORM\ManyToOne(targetEntity="Matiere", inversedBy="lesCours")
     */
    private $matiere;

    /**
     * Many Cours have One ETimeSheet.
     * @ORM\ManyToOne(targetEntity="ETimeSheet", inversedBy="lesCours")
     */
    private $ets;

    /**
     * One Cours has One Type.
     * @ORM\OneToOne(targetEntity="Type")
     */
    private $type;

    /**
     * One Cours has Many User_cours.
     * @ORM\OneToMany(targetEntity="User_cours", mappedBy="leCours")
     */
    private $lesEtudiantsPresents;


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
     * Set horaire
     *
     * @param \DateTime $horaire
     * @return Cours
     */
    public function setHoraire($horaire)
    {
        $this->horaire = $horaire;

        return $this;
    }

    /**
     * Get horaire
     *
     * @return \DateTime 
     */
    public function getHoraire()
    {
        return $this->horaire;
    }

    /**
     * Set enseignantAbsent
     *
     * @param boolean $enseignantAbsent
     * @return Cours
     */
    public function setEnseignantAbsent($enseignantAbsent)
    {
        $this->enseignantAbsent = $enseignantAbsent;

        return $this;
    }

    /**
     * Get enseignantAbsent
     *
     * @return boolean 
     */
    public function getEnseignantAbsent()
    {
        return $this->enseignantAbsent;
    }

    /**
     * Set estValide
     *
     * @param boolean $estValide
     * @return Cours
     */
    public function setEstValide($estValide)
    {
        $this->estValide = $estValide;

        return $this;
    }

    /**
     * Get estValide
     *
     * @return boolean 
     */
    public function getEstValide()
    {
        return $this->estValide;
    }

    /**
     * Set enseignant
     *
     * @param string $enseignant
     * @return Cours
     */
    public function setEnseignant($enseignant)
    {
        $this->enseignant = $enseignant;

        return $this;
    }

    /**
     * Get enseignant
     *
     * @return string 
     */
    public function getEnseignant()
    {
        return $this->enseignant;
    }

    /**
     * Set matiere
     *
     * @param string $matiere
     * @return Cours
     */
    public function setMatiere($matiere)
    {
        $this->matiere = $matiere;

        return $this;
    }

    /**
     * Get matiere
     *
     * @return string 
     */
    public function getMatiere()
    {
        return $this->matiere;
    }

    /**
     * Set ets
     *
     * @param string $ets
     * @return Cours
     */
    public function setEts($ets)
    {
        $this->ets = $ets;

        return $this;
    }

    /**
     * Get ets
     *
     * @return string 
     */
    public function getEts()
    {
        return $this->ets;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Cours
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
     * Set lesEtudiants
     *
     * @param string $lesEtudiants
     * @return Cours
     */
    public function setLesEtudiants($lesEtudiants)
    {
        $this->lesEtudiants = $lesEtudiants;

        return $this;
    }

    /**
     * Get lesEtudiants
     *
     * @return string 
     */
    public function getLesEtudiants()
    {
        return $this->lesEtudiants;
    }
}
