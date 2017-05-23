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

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    public function absences(User $user)
    {

        $lesUserCours = $this->em->getRepository('ConnexionBundle:User_cours')->findBy(array('lEtudiant' => $user->getId()),
            array('id' => 'desc'));

        $lesAbsences = array();
        foreach ($lesUserCours as $lUserCours )
        {
            if(!$lUserCours->getEtudiantPresent())
            {
                $lesAbsences[] = $lUserCours;
            }
        }

        return $lesAbsences;

    }

}