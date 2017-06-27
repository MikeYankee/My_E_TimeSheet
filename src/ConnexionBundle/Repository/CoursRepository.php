<?php

namespace ConnexionBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CoursRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CoursRepository extends EntityRepository
{
    public function getCountByType($promo, $type)
    {
        $query = $this->createQueryBuilder('c')
            ->join('c.ets', 'e')
            ->join('e.promotion', 'p')
            ->where('e.promotion = :promo')
            ->setParameter('promo', $promo)
            ->andWhere('c.type = :type')
            ->setParameter('type', $type)
            ->andWhere('c.estValide = 1');
        return $query->getQuery()->getResult();
    }

}
