<?php

namespace App\Repository;

use App\DTO\ScoreAverageRangeDTO;
use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }

    public function dateAverageScore(int $hotelId, ScoreAverageRangeDTO $range)
    {
        return $this->createQueryBuilder('r')
            ->select(
                'COUNT(r.score) as count,
                    AVG(r.score) as score, 
                    DAY(r.created_date) as day, 
                    WEEK(r.created_date) as week, 
                    MONTH(r.created_date) as month, 
                    YEAR(r.created_date) as year
            ')
            ->andWhere('r.hotel = :hotelId')
            ->andWhere('r.created_date BETWEEN :from AND :to')
            ->orderBy('r.created_date')
            ->groupBy($range->groupBy())
            ->setParameter('hotelId', $hotelId)
            ->setParameter('from', $range->getFrom())
            ->setParameter('to', $range->getTo())
            ->getQuery()
            ->getResult();
    }

}
