<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Circle;
use PHPUnit\Framework\TestCase;

class CircleTest extends TestCase
{
    public function testCalculateSurface()
    {
        $circle = new Circle(2);
        $surface = $circle->calculateSurface();

        $this->assertEquals(12.57, $surface);
    }

    public function testCalculateDiameter()
    {
        $circle = new Circle(2);
        $diameter = $circle->calculateDiameter();

        $this->assertEquals(4, $diameter);
    }

    public function testSerialize()
    {
        $circle = new Circle(2);
        $serializedData = $circle->serialize();

        $expectedData = [
            'type' => 'circle',
            'radius' => '2.0',
            'surface' => '12.57',
            'circumference' => '12.57',
        ];

        $this->assertEquals($expectedData, $serializedData);
    }
}