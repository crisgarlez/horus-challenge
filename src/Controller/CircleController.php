<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Circle;
use App\Service\GeometryCalculator;
use App\Service\HistoryService;


class CircleController extends AbstractController
{
    #[Route('/circle/{radius}', methods: ["GET"], name: 'app_circle')]
    public function index(float $radius): JsonResponse
    {
        $circle = new Circle($radius);
        return $this->json($circle->serialize());
    }

    #[Route('/circle/sum-objects', methods: ["POST"], name: 'app_circle_sum_object')]
    public function sumObjects(
        Request $request,
        GeometryCalculator $geometryCalculator,
        HistoryService $historyService
    ): JsonResponse
    {
        $payload = json_decode($request->getContent(), TRUE);
        $circle1 = new Circle($payload['circle1']['radius']);
        $circle2 = new Circle($payload['circle2']['radius']);

        $responseBody = [
            'totalAreas' => $geometryCalculator->sumAreas($circle1, $circle2),
            'totalDiameters' => $geometryCalculator->sumDiameters($circle1, $circle2)
        ];

        $jsonResponse = json_encode($responseBody);
        $jsonRequest = json_encode([$payload['circle1'], $payload['circle2']]);
        $historyService->saveHistory($request->getContent(), $jsonResponse);


        return $this->json($responseBody);
    }
}
