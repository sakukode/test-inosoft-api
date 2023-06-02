<?php

namespace App\DTO;

class MotorCycle extends Vehicle
{
    public function __construct(
        string $year,
        string $color,
        float $price,
        public string $engine,
        public string $suspensionType,
        public string $transmitionType
    ) {
        parent::__construct($year, $color, $price);
    }
}
