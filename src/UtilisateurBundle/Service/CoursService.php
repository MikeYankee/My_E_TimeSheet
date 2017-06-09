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

        $lesCours = $this->em->getRepository('ConnexionBundle:Cours')->findBy(array('estValide' => true));

        foreach ($promotion_cible as $promotion)
        {
            $recap_heures_matiere[$promotion->getId()]["promotion"]= $promotion;

            foreach ($lesCours as $leCours) {
                if ($leCours->getMatiere()->getPromotion() == $promotion) {
                    $recap_heures_matiere[$promotion->getId()]["matieres"][$leCours->getMatiere()->getId()]["matiere"] = $leCours->getMatiere();
                    $recap_heures_matiere[$promotion->getId()]["matieres"][$leCours->getMatiere()->getId()]["CM"] = $leCours->getMatiere()->getNbHeuresMaquetteCours();
                    $recap_heures_matiere[$promotion->getId()]["matieres"][$leCours->getMatiere()->getId()]["TD"] = $leCours->getMatiere()->getNbHeuresMaquetteTD();
                    $recap_heures_matiere[$promotion->getId()]["matieres"][$leCours->getMatiere()->getId()]["Examen"] = $leCours->getMatiere()->getNbHeuresMaquetteExam();
                    $recap_heures_matiere[$promotion->getId()]["matieres"][$leCours->getMatiere()->getId()]["Soutenance"] = $leCours->getMatiere()->getNbHeuresMaquetteSoutenance();

                    $recap_heures_matiere[$promotion->getId()]["matieres"][$leCours->getMatiere()->getId()]["nbHeuresPrevuesTotal"] = $leCours->getMatiere()->getNbHeuresMaquetteCours() + $leCours->getMatiere()->getNbHeuresMaquetteTD() + $leCours->getMatiere()->getNbHeuresMaquetteExam()+ $leCours->getMatiere()->getNbHeuresMaquetteSoutenance();


                    //test pour incrémenter ou initialiser nbHeures par type et par mois
                    if (isset($recap_heures_matiere[$promotion->getId()]["matieres"][$leCours->getMatiere()->getId()]["nbHeuresEffectuees"]["types"][$leCours->getType()->getLibelle()][$leCours->getEts()->getDate()->format("m")])) {
                        $recap_heures_matiere[$promotion->getId()]["matieres"][$leCours->getMatiere()->getId()]["nbHeuresEffectuees"]["types"][$leCours->getType()->getLibelle()][$leCours->getEts()->getDate()->format("m")] += 1.5;
                    }
                    else
                    {
                        $recap_heures_matiere[$promotion->getId()]["matieres"][$leCours->getMatiere()->getId()]["nbHeuresEffectuees"]["types"][$leCours->getType()->getLibelle()][$leCours->getEts()->getDate()->format("m")] = 1.5;
                    }

                    //test pour incrémenter ou initialiser nbHeures pour total type
                    if (isset($recap_heures_matiere[$promotion->getId()]["matieres"][$leCours->getMatiere()->getId()]["nbHeuresEffectuees"]["totalTypes"][$leCours->getType()->getLibelle()])) {
                        $recap_heures_matiere[$promotion->getId()]["matieres"][$leCours->getMatiere()->getId()]["nbHeuresEffectuees"]["totalTypes"][$leCours->getType()->getLibelle()] += 1.5;
                    }
                    else
                    {
                        $recap_heures_matiere[$promotion->getId()]["matieres"][$leCours->getMatiere()->getId()]["nbHeuresEffectuees"]["totalTypes"][$leCours->getType()->getLibelle()] = 1.5;
                    }

                    //test pour incrémenter ou initialiser nbHeures par matiere
                    if (isset($recap_heures_matiere[$promotion->getId()]["matieres"][$leCours->getMatiere()->getId()]["nbHeuresEffectuees"]["matiere"][$leCours->getEts()->getDate()->format("m")])) {
                        $recap_heures_matiere[$promotion->getId()]["matieres"][$leCours->getMatiere()->getId()]["nbHeuresEffectuees"]["matiere"][$leCours->getEts()->getDate()->format("m")] += 1.5;
                    }
                    else
                    {
                        $recap_heures_matiere[$promotion->getId()]["matieres"][$leCours->getMatiere()->getId()]["nbHeuresEffectuees"]["matiere"][$leCours->getEts()->getDate()->format("m")] = 1.5;
                    }

                    //test pour incrémenter ou initialiser nbHeures pour total matiere effectuée
                    if (isset($recap_heures_matiere[$promotion->getId()]["matieres"][$leCours->getMatiere()->getId()]["nbHeuresEffectuees"]["TotalMatiere"])) {
                        $recap_heures_matiere[$promotion->getId()]["matieres"][$leCours->getMatiere()->getId()]["nbHeuresEffectuees"]["TotalMatiere"] += 1.5;
                    }
                    else
                    {
                        $recap_heures_matiere[$promotion->getId()]["matieres"][$leCours->getMatiere()->getId()]["nbHeuresEffectuees"]["TotalMatiere"] = 1.5;
                    }


                    //test pour incrémenter ou initialiser nbHeures pour total mois effectués
                    if (isset($recap_heures_matiere[$promotion->getId()]["totalMois"][$leCours->getEts()->getDate()->format("m")])) {
                        $recap_heures_matiere[$promotion->getId()]["totalMois"][$leCours->getEts()->getDate()->format("m")] += 1.5;
                    }
                    else
                    {
                        $recap_heures_matiere[$promotion->getId()]["totalMois"][$leCours->getEts()->getDate()->format("m")] = 1.5;
                    }

                    //test pour incrémenter ou initialiser nbHeures pour total effectué
                    if (isset($recap_heures_matiere[$promotion->getId()]["totalEffectue"])) {
                        $recap_heures_matiere[$promotion->getId()]["totalEffectue"] += 1.5;
                    }
                    else
                    {
                        $recap_heures_matiere[$promotion->getId()]["totalEffectue"] = 1.5;
                    }
                }
            }
        }

        //boucle sur promos et matieres
        foreach ($recap_heures_matiere as $promo)
        {
           foreach (array_slice($promo, 1, 1)["matieres"] as $matiere)
            {

                //test pour incrémenter ou initialiser nbHeures pour total prévu
                if (isset($recap_heures_matiere[$promotion->getId()]["totalPrevu"])) {
                    $recap_heures_matiere[$promotion->getId()]["totalPrevu"] += $matiere["nbHeuresPrevuesTotal"];
                }
                else
                {
                    $recap_heures_matiere[$promotion->getId()]["totalPrevu"] = $matiere["nbHeuresPrevuesTotal"];
                }

            }
            //dump($promo[2]); die;
        }
        return $recap_heures_matiere;
    }

}