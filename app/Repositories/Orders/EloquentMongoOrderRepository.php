<?php

namespace App\Repositories\Orders;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use MongoDB\BSON\UTCDateTime;
use App\Exceptions\OutOfStockException;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\VehicleRepositoryInterface;

class EloquentMongoOrderRepository implements OrderRepositoryInterface
{
    protected $vehicleRepository;

    public function __construct(VehicleRepositoryInterface $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    public function create(array $attributes): void
    {
        $product = Arr::get($attributes, 'product', null);

        if (!$product) {
            throw new Exception('Vehicle is invalid');
        }

        $vehicle = $this->vehicleRepository->findById($product['id']);

        if($vehicle->stock <= 0) {
            throw new OutOfStockException('Vehicle is out of stock');
        }

        $quantity = Arr::get($attributes, 'quantity');

        $vehicle->push('orders', [
            'quantity' => $quantity,
            'price' => $vehicle->price,
            'customer' => Arr::get($attributes, 'customer'),
            'date' => new UTCDateTime(Carbon::now()->format('Uv'))
        ]);

        $this->vehicleRepository->deductStock($product['id'], $quantity);
    }
}
