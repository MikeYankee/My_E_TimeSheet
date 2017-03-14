<?php

namespace ConnexionBundle\Entity\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User_cours
 *
 * @ORM\Table(name="User_cours")
 * @ORM\Entity(repositoryClass="ConnexionBundle\Repository\User_coursRepository")
 */
class User_cours
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
     * @ORM\Column(name="commentaire", type="string", length=255, nullable=true)
     */
    private $commentaire;

    /**
     * @var bool
     *
     * @ORM\Column(name="etudiantPresent", type="boolean")
     */
    private $etudiantPresent;

    /**
     * Many User_cours have One Cours.
     * @ORM\ManyToOne(targetEntity="Cours", inversedBy="lesEtudiantsPresents")
     */
    private $leCours;

    /**
     * Many Users have One User.
     * @ORM\ManyToOne(targetEntity="User", inversedBy="lesEtudiantsPresents")
     */
    private $lEtudiant;


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
     * Set commentaire
     *
     * @param string $commentaire
     * @return User_cours
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string 
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set etudiantPresent
     *
     * @param boolean $etudiantPresent
     * @return User_cours
     */
    public function setEtudiantPresent($etudiantPresent)
    {
        $this->etudiantPresent = $etudiantPresent;

        return $this;
    }

    /**
     * Get etudiantPresent
     *
     * @return boolean 
     */
    public function getEtudiantPresent()
    {
        return $this->etudiantPresent;
    }

    /**
     * Set lesEtudiants
     *
     * @param string $lesEtudiants
     * @return User_cours
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

    /**
     * Set lesCours
     *
     * @param string $lesCours
     * @return User_cours
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
}
