<?php

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

interface VehicleRepositoryInterface
{
    /**
     * Find a vehicle by its ID.
     *
     * @param string|int $id The ID of the vehicle.
     * @return Model|null The found vehicle or null if not found.
     */
    public function findById(string|int $id): ?Model;

    /**
     * Add stock quantity to a vehicle.
     *
     * @param string|int $id The ID of the vehicle.
     * @param int $quantity The quantity to add.
     * @return void
     */
    public function addStock(string|int $id, int $quantity): void;

    /**
     * Deduct stock quantity from a vehicle.
     *
     * @param string|int $id The ID of the vehicle.
     * @param int $quantity The quantity to deduct.
     * @return void
     */
    public function deductStock(string|int $id, int $quantity): void;

    /**
     * Get order reports by its ID.
     *
     * @param int|string $id The ID of the vehicle.
     * @param string|null $startDate The start date of the reports (optional).
     * @param string|null $endDate The end date of the reports (optional).
     * @return Collection The collection of reports.
     */
    public function getOrderReportsById(string|int $id, string $startDate = null, string $endDate = null): Collection;
}
