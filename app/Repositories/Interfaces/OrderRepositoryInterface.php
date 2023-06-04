<?php

namespace App\Repositories\Interfaces;

interface OrderRepositoryInterface
{
    /**
     * Create a new order.
     *
     * @param array $attributes The order attributes.
     * @return void
     */
    public function create(array $attributes): void;
}
