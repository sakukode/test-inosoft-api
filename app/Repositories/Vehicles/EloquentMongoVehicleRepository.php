<?php

namespace App\Repositories\Vehicles;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Repositories\Interfaces\VehicleRepositoryInterface;
use MongoDB\BSON\UTCDateTime;
use Carbon\Carbon;

class EloquentMongoVehicleRepository implements VehicleRepositoryInterface
{
    /**
     * The Vehicle model instance.
     *
     * @var Vehicle
     */
    protected $model;

    /**
     * Create a new EloquentMongoVehicleRepository instance.
     *
     * @param  Vehicle  $model
     * @return void
     */
    public function __construct(Vehicle $model)
    {
        $this->model = $model;
    }

    /**
     * Find a vehicle by its ID.
     *
     * @param  string|int  $id
     * @return Vehicle|null
     *
     * @throws NotFoundHttpException
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
     * @param  string|int  $id
     * @param  int  $quantity
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
     * Deduct stock to a vehicle.
     *
     * @param  string|int  $id
     * @param  int  $quantity
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
}
