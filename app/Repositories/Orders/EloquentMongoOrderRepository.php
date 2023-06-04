<?php

namespace App\Repositories\Orders;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use App\Exceptions\OutOfStockException;
use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\VehicleRepositoryInterface;
use Illuminate\Support\Collection;

class EloquentMongoOrderRepository implements OrderRepositoryInterface
{
    /**
     * @var VehicleRepositoryInterface
     */
    protected $vehicleRepository;

    /**
     * EloquentMongoOrderRepository constructor.
     *
     * @param VehicleRepositoryInterface $vehicleRepository
     */
    public function __construct(VehicleRepositoryInterface $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    /**
     * Create a new order.
     *
     * @param array $attributes The order attributes.
     *
     * @throws Exception if the vehicle is invalid.
     * @throws OutOfStockException if the vehicle is out of stock.
     */
    public function create(array $attributes): void
    {
        $product = Arr::get($attributes, 'product', null);

        if (!$product) {
            throw new Exception('Vehicle is invalid');
        }

        $vehicle = $this->vehicleRepository->findById($product['id']);

        if ($vehicle->stock <= 0) {
            throw new OutOfStockException('Vehicle is out of stock');
        }

        $quantity = Arr::get($attributes, 'quantity');

        // Create order instance
        $order = new Order([
            'quantity' => $quantity,
            'price' => $vehicle->price,
            'customer' => Arr::get($attributes, 'customer'),
            'date' => Carbon::now()
        ]);

        $vehicle->orders()->save($order);

        $this->vehicleRepository->deductStock($product['id'], $quantity);
    }
}
