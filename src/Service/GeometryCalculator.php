<?php

namespace App\Service;

use App\Entity\Shape;

class GeometryCalculator
{
    public function sumAreas(Shape $shape1, Shape $shape2): float
    {
        $area1 = $shape1->calculateSurface();
        $area2 = $shape2->calculateSurface();

        return $area1 + $area2;
    }

    public function sumDiameters(Shape $shape1, Shape $shape2): float
    {
        $diameter1 = $shape1->calculateDiameter();
        $diameter2 = $shape2->calculateDiameter();

        return $diameter1 + $diameter2;
    }
}