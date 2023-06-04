<?php

namespace Tests\Unit;

use Mockery;
use App\Models\Vehicle;
use PHPUnit\Framework\TestCase;
use App\Repositories\Orders\EloquentMongoOrderRepository;
use App\Repositories\Interfaces\VehicleRepositoryInterface;
use App\Repositories\Vehicles\EloquentMongoVehicleRepository;

class EloquentMongoOrderRepositoryTest extends TestCase
{
    /**
     * Create the Laravel application for testing.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../../bootstrap/app.php';
        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        return $app;
    }

    /**
     * Test the "create" method of EloquentMongoOrderRepository.
     *
     * @return void
     */
    public function test_create_order()
    {
        $vehicleRepositoryMock = Mockery::mock(EloquentMongoVehicleRepository::class);
        $this->createApplication(VehicleRepositoryInterface::class, $vehicleRepositoryMock);

        $vehicleId = 1;
        $vehicleStock = 10;
        $vehiclePrice = 2000;
        $product = ['id' => $vehicleId];
        $attributes = [
            'product' => $product,
            'quantity' => 2,
            'customer' => 'John Doe'
        ];

        $vehicle = Mockery::mock(Vehicle::class);
        $vehicle->shouldReceive('getAttribute')->with('stock')->andReturn($vehicleStock);
        $vehicle->shouldReceive('getAttribute')->with('price')->andReturn($vehiclePrice);
        $vehicleRepositoryMock->shouldReceive('findById')->with($vehicleId)->andReturn($vehicle);
        $vehicleRepositoryMock->shouldReceive('deductStock')->with($vehicleId, $attributes['quantity'])->once();

        $orderRepository = new EloquentMongoOrderRepository($vehicleRepositoryMock);

        $order = Mockery::mock(Order::class);
        $order->shouldReceive('setAttribute')->with('quantity', $attributes['quantity']);
        $order->shouldReceive('setAttribute')->with('price', $vehiclePrice);
        $order->shouldReceive('setAttribute')->with('customer', $attributes['customer']);
        $order->shouldReceive('setAttribute')->with('date', Mockery::type(Carbon::class));
        $order->shouldReceive('save')->once();

        $vehicle->shouldReceive('orders')->andReturn($order);

        $this->assertNull($orderRepository->create($attributes));
    }
}
