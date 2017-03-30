<?php

namespace ConnexionBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * Utilisateur
 *
 * @ORM\Table(name="User")
 * @ORM\Entity(repositoryClass="ConnexionBundle\Repository\UtilisateurRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", nullable=true, length=255)
     */
    protected $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", nullable=true, length=255)
     */
    protected $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", nullable=true, length=10)
     */
    protected $tel;


    /**
     * Many Users have One Promotion.
     * @ORM\ManyToOne(targetEntity="Promotion", inversedBy="lesUtilisateurs")
     */
    private $promotion;

    /**
     * Many Users have Many Matieres.
     * @ORM\ManyToMany(targetEntity="Matiere", mappedBy="lesEnseignants")
     */
    private $lesMatieres;

    /**
     * One User has Many User_cours.
     * @ORM\OneToMany(targetEntity="User_cours", mappedBy="lEtudiant")
     */
    private $lesCours;

    /**
     * Many User has One Promotion.
     * @ORM\ManyToOne(targetEntity="Promotion", inversedBy="lesResponsables")
     */
    private $promotionResp;

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
     * Set nom
     *
     * @param string $nom
     * @return User
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set tel
     *
     * @param string $tel
     * @return User
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string 
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set mail
     *
     * @param string $mail
     * @return User
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string 
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set promotion
     *
     * @param \ConnexionBundle\Entity\Promotion $promotion
     * @return User
     */
    public function setPromotion(\ConnexionBundle\Entity\Promotion $promotion = null)
    {
        $this->promotion = $promotion;

        return $this;
    }

    /**
     * Get promotion
     *
     * @return \ConnexionBundle\Entity\Promotion 
     */
    public function getPromotion()
    {
        return $this->promotion;
    }

    /**
     * Add lesMatieres
     *
     * @param \ConnexionBundle\Entity\Matiere $lesMatieres
     * @return User
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
     * Get lesMatieres
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLesMatieres()
    {
        return $this->lesMatieres;
    }

    /**
     * Add lesEtudiants
     *
     * @param \ConnexionBundle\Entity\User_cours $lesEtudiants
     * @return User
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
     * To string
     *
     * @return string
     */
    public function __toString()
    {
        if(!is_null($this->prenom) or !is_null($this->nom)){
            $return = $this->prenom." ".strtoupper($this->nom);
        }
        else{
            $return = $this->email;
        }
        return $return;
    }

    /**
     * Add lesCours
     *
     * @param \ConnexionBundle\Entity\User_cours $lesCours
     * @return User
     */
    public function addLesCour(\ConnexionBundle\Entity\User_cours $lesCours)
    {
        $this->lesCours[] = $lesCours;

        return $this;
    }

    /**
     * Remove lesCours
     *
     * @param \ConnexionBundle\Entity\User_cours $lesCours
     */
    public function removeLesCour(\ConnexionBundle\Entity\User_cours $lesCours)
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

    /**
     * Set promotionResp
     *
     * @param \ConnexionBundle\Entity\Promotion $promotionResp
     * @return User
     */
    public function setPromotionResp(\ConnexionBundle\Entity\Promotion $promotionResp = null)
    {
        $this->promotionResp = $promotionResp;

        return $this;
    }

    /**
     * Get promotionResp
     *
     * @return \ConnexionBundle\Entity\Promotion 
     */
    public function getPromotionResp()
    {
        return $this->promotionResp;
    }
}
