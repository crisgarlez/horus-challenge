<?php

namespace App\Entity;

abstract class Shape
{
    abstract public function calculateSurface(): float;
    abstract public function calculateDiameter(): float;

    public function calculateSurfaceAndDiameter(): array
    {
        $surface = $this->calculateSurface();
        $diameter = $this->calculateDiameter();

        return [
            'surface' => $surface,
            'circumference' => $diameter,
        ];
    }
}