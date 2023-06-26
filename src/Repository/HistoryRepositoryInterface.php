<?php

namespace App\Repository;

use App\Entity\History;

interface HistoryRepositoryInterface
{
    public function save(History $history): void;
    public function findAll(): array;
}