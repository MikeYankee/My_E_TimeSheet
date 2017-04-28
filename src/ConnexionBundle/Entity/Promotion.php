<?php

namespace ConnexionBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * promotion
 *
 * @ORM\Table(name="Promotion")
 * @ORM\Entity(repositoryClass="ConnexionBundle\Repository\promotionRepository")
 */
class Promotion
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
     * One Promotion has Many Conventions.
     * @ORM\OneToMany(targetEntity="Convention", mappedBy="promotion")
     */
    private $lesConventions;

    /**
     * One Promotion has Many ETimeSheets.
     * @ORM\OneToMany(targetEntity="ETimeSheet", mappedBy="promotion")
     */
    private $lesETS;

    /**
     * One Promotion has Many Matieres.
     * @ORM\OneToMany(targetEntity="Matiere", mappedBy="promotion")
     */
    private $lesMatieres;

    /**
     * One Promotion has Many Users.
     * @ORM\OneToMany(targetEntity="User", mappedBy="promotion")
     */
    private $lesEtudiants;

    /**
     * One Promotion has Many Factures.
     * @ORM\OneToMany(targetEntity="Facture", mappedBy="promotion")
     */
    private $lesFactures;

    /**
     * Many Promotion has Many Users.
     * @ORM\ManyToMany(targetEntity="User", inversedBy="promotionResp")
     */
    private $lesResponsables;


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
     * @return promotion
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
     * Set convention
     *
     * @param \ConnexionBundle\Entity\Convention $convention
     * @return promotion
     */
    public function setConvention($convention)
    {
        $this->convention = $convention;

        return $this;
    }

    /**
     * Get convention
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getConvention()
    {
        return $this->lesConventions;
    }

    /**
     * Set lesETS
     *
     * @param \ConnexionBundle\Entity\ETimeSheet $lesETS
     * @return promotion
     */
    public function setLesETS($lesETS)
    {
        $this->lesETS[] = $lesETS;

        return $this;
    }

    /**
     * Get lesETS
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getLesETS()
    {
        return $this->lesETS;
    }

    /**
     * Set lesMatieres
     *
     * @param \ConnexionBundle\Entity\Matiere $lesMatieres
     * @return promotion
     */
    public function setLesMatieres($lesMatieres)
    {
        $this->lesMatieres = $lesMatieres;

        return $this;
    }

    /**
     * Get lesMatieres
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getLesMatieres()
    {
        return $this->lesMatieres;
    }

    /**
     * Set lesEtudiants
     *
     * @param \ConnexionBundle\Entity\User $lesEtudiants
     * @return promotion
     */
    public function setLesEtudiants($lesEtudiants)
    {
        $this->lesEtudiants = $lesEtudiants;

        return $this;
    }

    /**
     * Set lesFactures
     *
     * @param \ConnexionBundle\Entity\Facture $lesFactures
     * @return promotion
     */
    public function setLesFactures($lesFactures)
    {
        $this->lesFactures = $lesFactures;

        return $this;
    }

    /**
     * Get lesFactures
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getLesFactures()
    {
        return $this->lesFactures;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lesConventions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->lesETS = new \Doctrine\Common\Collections\ArrayCollection();
        $this->lesMatieres = new \Doctrine\Common\Collections\ArrayCollection();
        $this->lesEtudiants = new \Doctrine\Common\Collections\ArrayCollection();
        $this->lesFactures = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add lesConventions
     *
     * @param \ConnexionBundle\Entity\Convention $lesConventions
     * @return Promotion
     */
    public function addLesConvention(\ConnexionBundle\Entity\Convention $lesConventions)
    {
        $this->lesConventions[] = $lesConventions;

        return $this;
    }

    /**
     * Remove lesConventions
     *
     * @param \ConnexionBundle\Entity\Convention $lesConventions
     */
    public function removeLesConvention(\ConnexionBundle\Entity\Convention $lesConventions)
    {
        $this->lesConventions->removeElement($lesConventions);
    }

    /**
     * Get lesConventions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLesConventions()
    {
        return $this->lesConventions;
    }

    /**
     * Add lesETS
     *
     * @param \ConnexionBundle\Entity\ETimeSheet $lesETS
     * @return Promotion
     */
    public function addLesETS(\ConnexionBundle\Entity\ETimeSheet $lesETS)
    {
        $this->lesETS[] = $lesETS;

        return $this;
    }

    /**
     * Remove lesETS
     *
     * @param \ConnexionBundle\Entity\ETimeSheet $lesETS
     */
    public function removeLesETS(\ConnexionBundle\Entity\ETimeSheet $lesETS)
    {
        $this->lesETS->removeElement($lesETS);
    }

    /**
     * Add lesMatieres
     *
     * @param \ConnexionBundle\Entity\Matiere $lesMatieres
     * @return Promotion
     */
    public function addLesMatiere(\ConnexionBundle\Entity\Matiere $lesMatieres)
    {
        $this->lesMatieres[] = $lesMatieres;

        return $this;
    }

    /**
     * Remove lesMatieres
     *
     * @param \ConnexionBundle\Entity\Matiere $lesMatieres
     */
    public function removeLesMatiere(\ConnexionBundle\Entity\Matiere $lesMatieres)
    {
        $this->lesMatieres->removeElement($lesMatieres);
    }

    /**
     * Add lesUtilisateurs
     *
     * @param \ConnexionBundle\Entity\User $lesUtilisateurs
     * @return Promotion
     */
    public function addLesEtudiants(\ConnexionBundle\Entity\User $lesEtudiants)
    {
        $this->lesEtudiants[] = $lesEtudiants;

        return $this;
    }

    /**
     * Remove lesUtilisateurs
     *
     * @param \ConnexionBundle\Entity\User $lesUtilisateurs
     */
    public function removeLesEtudiants(\ConnexionBundle\Entity\User $lesEtudiants)
    {
        $this->lesEtudiants->removeElement($lesEtudiants);
    }

    /**
     * Add lesFactures
     *
     * @param \ConnexionBundle\Entity\Facture $lesFactures
     * @return Promotion
     */
    public function addLesFacture(\ConnexionBundle\Entity\Facture $lesFactures)
    {
        $this->lesFactures[] = $lesFactures;

        return $this;
    }

    /**
     * Remove lesFactures
     *
     * @param \ConnexionBundle\Entity\Facture $lesFactures
     */
    public function removeLesFacture(\ConnexionBundle\Entity\Facture $lesFactures)
    {
        $this->lesFactures->removeElement($lesFactures);
    }

    /**
     * Add lesEtudiants
     *
     * @param \ConnexionBundle\Entity\User $lesEtudiants
     * @return Promotion
     */
    public function addLesEtudiant(\ConnexionBundle\Entity\User $lesEtudiants)
    {
        $this->lesEtudiants[] = $lesEtudiants;

        return $this;
    }

    /**
     * Remove lesEtudiants
     *
     * @param \ConnexionBundle\Entity\User $lesEtudiants
     */
    public function removeLesEtudiant(\ConnexionBundle\Entity\User $lesEtudiants)
    {
        $this->lesEtudiants->removeElement($lesEtudiants);
    }

    /**
     * Get lesEtudiants
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLesEtudiants()
    {
        return $this->lesEtudiants;
    }

    /**
     * Add lesResponsables
     *
     * @param \ConnexionBundle\Entity\User $lesResponsables
     * @return Promotion
     */
    public function addLesResponsable(\ConnexionBundle\Entity\User $lesResponsables)
    {
        $this->lesResponsables[] = $lesResponsables;

        return $this;
    }

    /**
     * Remove lesResponsables
     *
     * @param \ConnexionBundle\Entity\User $lesResponsables
     */
    public function removeLesResponsable(\ConnexionBundle\Entity\User $lesResponsables)
    {
        $this->lesResponsables->removeElement($lesResponsables);
    }

    /**
     * Get lesResponsables
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLesResponsables()
    {
        return $this->lesResponsables;
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
}
