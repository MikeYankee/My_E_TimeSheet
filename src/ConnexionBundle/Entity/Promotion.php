<?php

namespace ConnexionBundle\Entity;

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
    private $convention;

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
    private $lesUtilisateurs;

    /**
     * One Promotion has Many Factures.
     * @ORM\OneToMany(targetEntity="Facture", mappedBy="promotion")
     */
    private $lesFactures;


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
     * @param string $convention
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
     * @return string 
     */
    public function getConvention()
    {
        return $this->convention;
    }

    /**
     * Set lesETS
     *
     * @param string $lesETS
     * @return promotion
     */
    public function setLesETS($lesETS)
    {
        $this->lesETS = $lesETS;

        return $this;
    }

    /**
     * Get lesETS
     *
     * @return string 
     */
    public function getLesETS()
    {
        return $this->lesETS;
    }

    /**
     * Set lesMatieres
     *
     * @param string $lesMatieres
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
     * @return string 
     */
    public function getLesMatieres()
    {
        return $this->lesMatieres;
    }

    /**
     * Set lesUtilisateurs
     *
     * @param string $lesUtilisateurs
     * @return promotion
     */
    public function setLesUtilisateurs($lesUtilisateurs)
    {
        $this->lesUtilisateurs = $lesUtilisateurs;

        return $this;
    }

    /**
     * Get lesUtilisateurs
     *
     * @return string 
     */
    public function getLesUtilisateurs()
    {
        return $this->lesUtilisateurs;
    }

    /**
     * Set lesFactures
     *
     * @param string $lesFactures
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
     * @return string 
     */
    public function getLesFactures()
    {
        return $this->lesFactures;
    }
}
