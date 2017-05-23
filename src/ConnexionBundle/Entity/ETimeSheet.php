<?php

namespace ConnexionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ETimeSheet
 *
 * @ORM\Table(name="E_time_sheet")
 * @ORM\Entity(repositoryClass="ConnexionBundle\Repository\ETimeSheetRepository")
 */
class ETimeSheet
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
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="string", length=255, nullable=true)
     */
    private $commentaire;

    /**
     * Many ETimeSheets have One Promotion.
     * @ORM\ManyToOne(targetEntity="Promotion", inversedBy="lesETS")
     */
    private $promotion;

    /**
     * One ETimeSheets has Many Cours.
     * @ORM\OneToMany(targetEntity="Cours", mappedBy="ets")
     */
    private $lesCours;


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
     * Set date
     *
     * @param \DateTime $date
     * @return ETimeSheet
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     * @return ETimeSheet
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
     * Set promo
     *
     * @param string $promo
     * @return ETimeSheet
     */
    public function setPromo($promotion)
    {
        $this->promo = $promotion;

        return $this;
    }

    /**
     * Get promo
     *
     * @return string 
     */
    public function getPromo()
    {
        return $this->promotion;
    }

    /**
     * Set lesCours
     *
     * @param string $lesCours
     * @return ETimeSheet
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
     * Constructor
     */
    public function __construct()
    {
        $this->lesCours = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set promotion
     *
     * @param \ConnexionBundle\Entity\Promotion $promotion
     * @return ETimeSheet
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
     * Add lesCours
     *
     * @param \ConnexionBundle\Entity\Cours $lesCours
     * @return ETimeSheet
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

    public function validees()
    {
        $query = $this->_em->createQueryBuilder();
        $query->select('ets', 'c')
            ->join('ets.lesCours', 'c')
            ->where('c.estValide = 1')
            ->orderBy('ets.date');

        return $query->getQuery()->getResult();
    }


}
