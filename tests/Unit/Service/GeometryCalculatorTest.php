<?php

namespace App\Tests\Unit\Service;

use App\Service\GeometryCalculator;
use App\Entity\Circle;
use App\Entity\Triangle;
use PHPUnit\Framework\TestCase;

class GeometryCalculatorTest extends TestCase
{
    public function testSumAreas()
    {
        $circle = new Circle(2);
        $triangle = new Triangle(3, 4, 5);
        $geometryCalculator = new GeometryCalculator();

        $sumAreas = $geometryCalculator->sumAreas($circle, $triangle);

        $this->assertEquals(18.57, $sumAreas);
    }

    public function testSumDiameters()
    {
        $circle = new Circle(2);
        $triangle = new Triangle(3, 4, 5);
        $geometryCalculator = new GeometryCalculator();

        $sumDiameters = $geometryCalculator->sumDiameters($circle, $triangle);

        $this->assertEquals(16, $sumDiameters);
    }
}