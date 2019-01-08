<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class EventRepository extends EntityRepository
{
    public function findEventsStartAfter(\DateTime $startAfterDate)
    {
        $qb = $this->createQueryBuilder('e')
            ->andWhere('e.startDate > :startDate')
            ->setParameter('startDate', $startAfterDate)
            ->getQuery();

        return $qb->execute();
    }

    public function findEventsStartBefore(\DateTime $startBeforeDate)
    {
        $qb = $this->createQueryBuilder('e')
            ->andWhere('e.startDate < :startDate')
            ->setParameter('startDate', $startBeforeDate)
            ->getQuery();

        return $qb->execute();
    }

}