<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface OrderRepositoryInterface
{
    public function create(array $attributes): void;
}
