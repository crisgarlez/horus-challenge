<?php

namespace App\Adapter;

use App\Entity\History;
use App\Repository\HistoryRepositoryInterface;
use App\Repository\HistoryRepository;
use Doctrine\Persistence\ManagerRegistry;

class MySqlAdapter implements HistoryRepositoryInterface
{
    private HistoryRepository $historyRepository;

    public function __construct(ManagerRegistry $registry)
    {
        $this->historyRepository = $registry->getRepository(History::class);
    }

    public function save(History $history): void
    {
        $this->historyRepository->save($history);
    }

    public function findAll(): array
    {
        return $this->historyRepository->findAll();
    }
}