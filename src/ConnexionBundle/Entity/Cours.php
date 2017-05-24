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
     * @var string
     *
     * @ORM\Column(name="horaire", type="string")
     */
    private $horaire;

    /**
     * @var bool
     *
     * @ORM\Column(name="enseignantAbsent", type="boolean", nullable=true , options={"default":false})
     */
    private $enseignantAbsent;

    /**
     * @var bool
     *
     * @ORM\Column(name="estValide", type="boolean", nullable=true)
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
     * @ORM\ManyToOne(targetEntity="Type", inversedBy="lesCours")
     */
    private $type;

    /**
     * One Cours has Many User_cours.
     * @ORM\OneToMany(targetEntity="User_cours", mappedBy="leCours")
     */
    private $lesEtudiants;


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
     * @param string $horaire
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
     * @return string
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
     * @param \ConnexionBundle\Entity\User $enseignant
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
     * @return \ConnexionBundle\Entity\User
     */
    public function getEnseignant()
    {
        return $this->enseignant;
    }

    /**
     * Set matiere
     *
     * @param \ConnexionBundle\Entity\Matiere $matiere
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
     * @return \ConnexionBundle\Entity\Matiere
     */
    public function getMatiere()
    {
        return $this->matiere;
    }

    /**
     * Set ets
     *
     * @param \ConnexionBundle\Entity\ETimeSheet $ets
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
     * @return \ConnexionBundle\Entity\ETimeSheet
     */
    public function getEts()
    {
        return $this->ets;
    }

    /**
     * Set type
     *
     * @param \ConnexionBundle\Entity\Type $type
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
     * @return \ConnexionBundle\Entity\Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set lesEtudiants
     *
     * @param \ConnexionBundle\Entity\User $lesEtudiants
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
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getLesEtudiants()
    {
        return $this->lesEtudiants;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lesEtudiants = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add lesEtudiants
     *
     * @param \ConnexionBundle\Entity\User_cours $lesEtudiants
     * @return Cours
     */
    public function addLesEtudiant(\ConnexionBundle\Entity\User_cours $lesEtudiants)
    {
        $this->lesEtudiants[] = $lesEtudiants;

        return $this;
    }

    /**
     * Remove lesEtudiants
     *
     * @param \ConnexionBundle\Entity\User_cours $lesEtudiants
     */
    public function removeLesEtudiant(\ConnexionBundle\Entity\User_cours $lesEtudiants)
    {
        $this->lesEtudiants->removeElement($lesEtudiants);
    }


}
