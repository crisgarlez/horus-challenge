<?php

namespace App\Entity;

use App\Entity\Shape;

class Triangle extends Shape
{
    private $a;
    private $b;
    private $c;

    public function __construct(float $a, float $b, float $c)
    {
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
    }

    public function calculateSurface(): float
    {
        $s = ($this->a + $this->b + $this->c) / 2;
        return round(sqrt($s * ($s - $this->a) * ($s - $this->b) * ($s - $this->c)), 2);
    }

    public function calculateDiameter(): float
    {
        return $this->a + $this->b + $this->c;
    }

    public function serialize(): array
    {
        $result = $this->calculateSurfaceAndDiameter();
        $result['type'] = 'triangle';
        $result['a'] = number_format($this->a, 1, ".", "");
        $result['b'] = number_format($this->b, 1, ".", "");
        $result['c'] = number_format($this->c, 1, ".", "");
        $result['circumference'] = number_format($result['circumference'], 1, ".", "");
        $result['surface'] = number_format($result['surface'], 1, ".", "");

        return $result;
    }
}