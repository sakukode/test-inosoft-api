<?php

namespace App\Repositories\Vehicles;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Repositories\Interfaces\VehicleRepositoryInterface;
use MongoDB\BSON\UTCDateTime;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class EloquentMongoVehicleRepository implements VehicleRepositoryInterface
{
    /**
     * The Vehicle model instance.
     *
     * @var Vehicle
     */
    protected Vehicle $model;

    /**
     * Create a new EloquentMongoVehicleRepository instance.
     *
     * @param Vehicle $model The Vehicle model instance.
     * @return void
     */
    public function __construct(Vehicle $model)
    {
        $this->model = $model;
    }

    /**
     * Find a vehicle by its ID.
     *
     * @param string|int $id The ID of the vehicle.
     * @return Vehicle|null The found Vehicle instance or null if not found.
     *
     * @throws ModelNotFoundException
     */
    public function findById(string|int $id): ?Vehicle
    {
        $vehicle = $this->model->find($id);

        if (!$vehicle) {
            throw new ModelNotFoundException('Vehicle not found.');
        }

        return $vehicle;
    }

    /**
     * Add stock to a vehicle.
     *
     * @param string|int $id The ID of the vehicle.
     * @param int $quantity The quantity of stock to add.
     * @return void
     */
    public function addStock(string|int $id, int $quantity): void
    {
        $vehicle = $this->findById($id);

        $vehicle->push('stocks', [
            'date' => new UTCDateTime(Carbon::now()->format('Uv')),
            'quantity' => $quantity
        ]);
    }

    /**
     * Deduct stock from a vehicle.
     *
     * @param string|int $id The ID of the vehicle.
     * @param int $quantity The quantity of stock to deduct.
     * @return void
     */
    public function deductStock(string|int $id, int $quantity): void
    {
        $vehicle = $this->findById($id);

        $vehicle->push('stocks', [
            'date' => new UTCDateTime(Carbon::now()->format('Uv')),
            'quantity' => -$quantity
        ]);
    }

    /**
     * Get order reports for a specific vehicle by its ID.
     *
     * @param string|int $id The ID of the vehicle.
     * @param string|null $startDate The start date of the reports (optional).
     * @param string|null $endDate The end date of the reports (optional).
     *
     * @return array The reports for the vehicle.
     */
    public function getOrderReportsById(string|int $id, string $startDate = null, string $endDate = null): Collection
    {
        $vehicle = $this->findById($id);

        if(!$vehicle->orders) {
            return collect([]);
        }

        if(is_null($startDate) && is_null($endDate)) {
            return $vehicle->orders;
        }

        $orders = $vehicle->orders->filter(function ($item) use ($startDate, $endDate) {
            $date = Carbon::instance($item['date']->toDateTime());
            $startDate = Carbon::createFromDate($startDate)->startOfDay();
            $endDate = Carbon::createFromDate($endDate)->endOfDay();

            return ($date->isSameAs($startDate) || $date->isAfter($startDate)) && ($date->isBefore($endDate));
        });
        
        return $orders;
    }
}
