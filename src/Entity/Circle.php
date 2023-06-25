<?php

namespace App\Entity;

use App\Entity\Shape;

class Circle extends Shape
{
    private $radius;

    public function __construct(float $radius)
    {
        $this->radius = $radius;
    }

    public function calculateSurface(): float
    {
        return round(pi() * ($this->radius ** 2), 2);
    }

    public function calculateDiameter(): float
    {
        return $this->radius * 2;
    }

    public function serialize(): array
    {
        $result = $this->calculateSurfaceAndDiameter();
        $result['type'] = 'circle';
        $result['radius'] = number_format($this->radius, 1, ".", "");
        $result['circumference'] = number_format($result['surface'], 2, ".", "");
        $result['surface'] = number_format($result['surface'], 2, ".", "");

        return $result;
    }
}