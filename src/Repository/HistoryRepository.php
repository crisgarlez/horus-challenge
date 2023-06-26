<?php

namespace App\Repository;

use App\Entity\History;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class HistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, History::class);
    }

    public function save(History $history): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($history);
        $entityManager->flush();
    }

    public function findAll(): array
    {
        return $this->createQueryBuilder('h')
            ->getQuery()
            ->getResult();
    }
}