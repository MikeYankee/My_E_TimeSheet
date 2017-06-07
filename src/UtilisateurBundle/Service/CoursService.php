<?php

namespace UtilisateurBundle\Service;

use ConnexionBundle\Entity\ETimeSheet;
use ConnexionBundle\Entity\Cours;
use ConnexionBundle\Entity\Promotion;
use ConnexionBundle\Repository\promotionRepository;
use Symfony\Component\Validator\Constraints\Null;

class CoursService
{
    private $em;

    /**
     * CoursService constructor.
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }


    public function getNbHeuresCours($promotion_cible)
    {
        $recap_heures_matiere = array();

        foreach ($promotion_cible as $promotion)
        {

            $lesCours = $this->em->getRepository('ConnexionBundle:Cours')->findBy(array('estValide' => true));
            $recap_heures_matiere[$promotion->getId()]["promotion"]= $promotion;

            foreach ($lesCours as $leCours)
            {
                if($leCours->getMatiere()->getPromotion() == $promotion)
                {
                    $lecompteur = 0;
                    $recap_heures_matiere[$promotion->getId()][$leCours->getMatiere()->getId()]["matiere"] = $leCours->getMatiere();
                    $recap_heures_matiere[$leCours->getMatiere()->getPromotion()->getId()][$leCours->getMatiere()->getId()]["compteurs"][$leCours->getType()->getLibelle()] = $lecompteur + 1.5;
                    $recap_heures_matiere[$promotion->getId()][$leCours->getMatiere()->getId()]["nbHeuresMaquettesCours"]= $leCours->getMatiere()->getNbHeuresMaquetteCours();
                    $recap_heures_matiere[$promotion->getId()][$leCours->getMatiere()->getId()]["nbHeuresMaquettesTD"]= $leCours->getMatiere()->getNbHeuresMaquetteTD();
                    $recap_heures_matiere[$promotion->getId()][$leCours->getMatiere()->getId()]["nbHeuresMaquettesExam"]= $leCours->getMatiere()->getNbHeuresMaquetteExam();
                    $recap_heures_matiere[$promotion->getId()][$leCours->getMatiere()->getId()]["nbHeuresMaquettesSoutenance"]= $leCours->getMatiere()->getNbHeuresMaquetteSoutenance();
                }
             }
        }
        return $recap_heures_matiere;
    }

}