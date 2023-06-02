<?php

namespace App\DTO;

class Car extends Vehicle
{
    public function __construct(
        string $year,
        string $color,
        float $price,
        public string $engine,
        public string $seat,
        public string $type
    ) {
        parent::__construct($year, $color, $price);
    }
}
