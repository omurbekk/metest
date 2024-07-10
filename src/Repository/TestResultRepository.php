<?php

namespace App\Repository;

use App\Entity\TestResult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TestResultRepository>
 */
class TestResultRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TestResult::class);
    }

        /**
         * @return TestResult[] Returns an array of QuestionOne objects
         */
        public function getResults(): array
        {
            return $this->createQueryBuilder('q')
                ->orderBy('q.createdAt', 'DESC')
                ->getQuery()
                ->getResult();
        }
}
