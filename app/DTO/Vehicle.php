<?php

namespace App\DTO;

abstract class Vehicle
{
    public function __construct(
        public string $year,
        public string $color,
        public float $price
    ) {
    }

    public function toArray()
    {
        
    }
}
