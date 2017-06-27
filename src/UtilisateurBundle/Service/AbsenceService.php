<?php

namespace UtilisateurBundle\Service;

use ConnexionBundle\Entity\ETimeSheet;
use ConnexionBundle\Entity\Cours;
use ConnexionBundle\Entity\Promotion;
use ConnexionBundle\Entity\User;
use ConnexionBundle\Repository\promotionRepository;

class AbsenceService
{

    private $em;

    /**
     * AbsenceService constructor.
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param User $user
     * @return array
     */
    public function absences(User $user)
    {

        $lesUserCours = $this->em->getRepository('ConnexionBundle:User_cours')->findBy(array('lEtudiant' => $user->getId()),
            array('id' => 'desc'));

        $lesAbsences = array();
        $etsValide = false;
        $coursMax = 0;
        foreach ($lesUserCours as $lUserCours )
        {
            foreach($lUserCours->getLeCours()->getEts()->getLesCours() as $leCours)
            {
                if($leCours->getEstValide())
                {
                    $etsValide = true;
                    $coursMax += 1;
                }
            }

            if($coursMax == count($lUserCours->getLeCours()->getEts()->getLesCours()) and !$lUserCours->getEtudiantPresent())
            {
                $lesAbsences[] = $lUserCours;
            }
        }

        return $lesAbsences;

    }

}