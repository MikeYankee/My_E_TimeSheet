<?php

namespace UtilisateurBundle\Service;

use ConnexionBundle\Entity\ETimeSheet;
use ConnexionBundle\Entity\Cours;
use ConnexionBundle\Entity\Promotion;
use ConnexionBundle\Repository\promotionRepository;

class ETSService
{
    private $em;

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    public function validees(Promotion $promotion)
    {

        $lesEts = $this->em->getRepository('ConnexionBundle:ETimeSheet')->findBy(array('promotion' => $promotion->getId()),
            array('date' => 'desc'));

        $lesEtsValidees = array();
        foreach ($lesEts as $lEts )
        {
            if(count($lEts->getLesCours()) >=1)
            {
                $estValidee = true;
                foreach ($lEts->getLesCours() as $leCoursEts)
                {
                    if(!$leCoursEts->getEstValide())
                    {
                        $estValidee = false;
                    }
                }
                if ($estValidee)
                {
                    $lesEtsValidees[] = $lEts;
                }
            }
        }

        return $lesEtsValidees;

    }

}