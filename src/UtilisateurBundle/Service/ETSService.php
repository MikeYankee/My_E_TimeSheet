<?php

namespace UtilisateurBundle\Service;

use ConnexionBundle\Entity\ETimeSheet;
use ConnexionBundle\Entity\Cours;
use ConnexionBundle\Entity\Promotion;
use ConnexionBundle\Repository\promotionRepository;
use Symfony\Component\Validator\Constraints\Null;

class ETSService
{
    private $em;

    /**
     * ETSService constructor.
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param Promotion $promotion
     * @return array
     */
    public function validees(Promotion $promotion)
    {

        $lesEts = $this->em->getRepository('ConnexionBundle:ETimeSheet')->findBy(array('promotion' => $promotion->getId()),
            array('date' => 'desc'));

        $lesEtsValidees = array();
        $lesEtsValidees2 = array();
        foreach ($lesEts as $lEts )
        {
            if(count($lEts->getLesCours()) >=1)
            {
                $estValidee = true;
                $estValidee2 = 0;
                foreach ($lEts->getLesCours() as $leCoursEts)
                {
                    if(!$leCoursEts->getEstValide()/* == 0 or $leCoursEts->getEstValide() == NULL*/)
                    {
                        $estValidee2 ++;
                        $estValidee = false;
                    }
                }
                if ($estValidee)
                {
                    $lesEtsValidees[] = $lEts;
                }
               /* if($estValidee2 == 0)
                {
                    $lesEtsValidees2[] = $lEts;
                }*/
            }
        }

        return $lesEtsValidees;

    }

}