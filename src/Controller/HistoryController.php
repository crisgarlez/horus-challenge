<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Service\HistoryService;

class HistoryController extends AbstractController
{
    private $historyService;

    public function __construct(HistoryService $historyService)
    {
        $this->historyService = $historyService;
    }

    #[Route('/history', methods: ["GET"], name: 'app_history')]
    public function index(): JsonResponse
    {
        $history = $this->historyService->getAllHistory();

        $response = [];
        foreach ($history as $record) {
            $response[] = [
                'id' => $record->getId(),
                'request' => $record->getRequest(),
                'response' => $record->getResponse(),
                'createdAt' => $record->getCreatedAt()->format('Y-m-d H:i:s')
            ];
        }

        return $this->json($response);
    }
}