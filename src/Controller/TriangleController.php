<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Service\GeometryCalculator;
use App\Entity\Triangle;

class TriangleController extends AbstractController
{
    #[Route('/triangle/{a}/{b}/{c}', methods: ["GET"], name: 'app_triangle')]
    public function index(float $a, float $b, float $c): JsonResponse
    {
        $triangle = new Triangle($a, $b, $c);
        return $this->json($triangle->serialize());
    }

    #[Route('/triangle/sum-objects', methods: ["POST"], name: 'app_triangle_sum_object')]
    public function sumObjects(Request $request, GeometryCalculator $geometryCalculator): JsonResponse
    {
        $payload = json_decode($request->getContent(), TRUE);

        $triangle1 = $payload['triangle1'];
        $triangle1 = new Triangle($triangle1['a'], $triangle1['b'], $triangle1['c']);
        
        $triangle2 = $payload['triangle2'];
        $triangle2 = new Triangle($triangle2['a'], $triangle2['b'], $triangle2['c']);

        return $this->json([
            'totalAreas' => $geometryCalculator->sumAreas($triangle1, $triangle2),
            'totalDiameters' => $geometryCalculator->sumDiameters($triangle1, $triangle2)
        ]);
    }
}

