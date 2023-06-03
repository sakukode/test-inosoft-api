<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface VehicleRepositoryInterface 
{
    public function findById(string|int $id): ?Model;

    public function addStock(string|int $id, int $quantity): void;

    public function deductStock(string|int $id, int $quantity): void;
}