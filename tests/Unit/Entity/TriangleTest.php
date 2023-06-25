<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Triangle;
use PHPUnit\Framework\TestCase;

class TriangleTest extends TestCase
{
    public function testCalculateSurface()
    {
        $triangle = new Triangle(3, 4, 5);
        $surface = $triangle->calculateSurface();

        $this->assertEquals(6, $surface);
    }

    public function testCalculateDiameter()
    {
        $triangle = new Triangle(3, 4, 5);
        $diameter = $triangle->calculateDiameter();

        $this->assertEquals(12, $diameter);
    }

    public function testSerialize()
    {
        $triangle = new Triangle(3, 4, 5);
        $serializedData = $triangle->serialize();

        $expectedData = [
            'type' => 'triangle',
            'a' => '3.0',
            'b' => '4.0',
            'c' => '5.0',
            'surface' => '6.0',
            'circumference' => '12.0',
        ];

        $this->assertEquals($expectedData, $serializedData);
    }
}