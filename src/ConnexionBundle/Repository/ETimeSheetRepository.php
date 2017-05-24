<?php

namespace ConnexionBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * ETimeSheetRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ETimeSheetRepository extends EntityRepository
{
    public function getEtsDuJour(){
        $date = new \DateTime();
        $date = $date->format("Y-m-d");
        return $this->createQueryBuilder('e')
            ->where('e.date LIKE :date')
            ->setParameter('date', '%'.$date.'%')
            ->getQuery()
            ->getResult();
    }
}
