<?php

namespace App\Service;

use App\Entity\History;
use App\Repository\HistoryRepositoryInterface;

class HistoryService
{
    private HistoryRepositoryInterface $historyRepository;

    public function __construct(HistoryRepositoryInterface $historyRepository)
    {
        $this->historyRepository = $historyRepository;
    }

    public function saveHistory(string $request, string $response): void
    {
        $history = new History($request, $response);
        $this->historyRepository->save($history);
    }

    public function getAllHistory(): array
    {
        return $this->historyRepository->findAll();
    }
}