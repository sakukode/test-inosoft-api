<?php

namespace Tests\Unit;

use Mockery;
use Carbon\Carbon;
use App\Models\Vehicle;
use MongoDB\BSON\UTCDateTime;
use PHPUnit\Framework\TestCase;
use App\Repositories\Vehicles\EloquentMongoVehicleRepository;

class EloquentMongoVehicleRepositoryTest extends TestCase
{
    /**
     * Test the "findById" method of EloquentMongoVehicleRepository.
     */
    public function test_find_by_id()
    {
        // Create a mock Vehicle model instance
        /** @var Vehicle $vehicle */
        $vehicle = Mockery::mock(Vehicle::class);
        $vehicle->shouldReceive('find')->with(1)->andReturn($vehicle);

        $repository = new EloquentMongoVehicleRepository($vehicle);

        $result = $repository->findById(1);

        $this->assertSame($vehicle, $result);
    }

    /**
     * Test the "addStock" method of EloquentMongoVehicleRepository.
     */
    public function test_add_stock()
    {
        /** @var Vehicle $vehicle */
        $vehicle = Mockery::mock(Vehicle::class);
        $vehicle->shouldReceive('find')->with(1)->andReturn($vehicle);
        $vehicle->shouldReceive('push')->once();

        $repository = new EloquentMongoVehicleRepository($vehicle);

        $result = $repository->addStock(1, 10);

        $this->assertNull($result);
    }

    /**
     * Test the "deductStock" method of EloquentMongoVehicleRepository.
     */
    public function test_deduct_stock()
    {
        /** @var Vehicle $vehicle */
        $vehicle = Mockery::mock(Vehicle::class);
        $vehicle->shouldReceive('find')->with(1)->andReturn($vehicle);
        $vehicle->shouldReceive('push')->once();

        $repository = new EloquentMongoVehicleRepository($vehicle);

        $result = $repository->deductStock(1, 5);

        $this->assertNull($result);
    }

    /**
     * Test the "getOrderReportsById" method of EloquentMongoVehicleRepository.
     */
    public function test_get_order_reports_by_id()
    {
        $orders = collect([
            [
                "date" => new UTCDateTime(Carbon::now()),
                "quantity" => 1,
                "price" => 2000
            ],
            [
                "date" => new UTCDateTime(Carbon::now()),
                "quantity" => 2,
                "price" => 2000
            ]
        ]);

        /** @var Vehicle $vehicle */
        $vehicle = Mockery::mock(Vehicle::class);
        $vehicle->shouldReceive('find')->with(1)->andReturn($vehicle);
        $vehicle->shouldReceive('getAttribute')->with('orders')->andReturn($orders);
        
        $repository = new EloquentMongoVehicleRepository($vehicle);

        $result = $repository->getOrderReportsById(1);
        $this->assertCount(2, $result);

        $result = $repository->getOrderReportsById(1, Carbon::now()->format('Y-m-d'), Carbon::now()->addDay()->format('Y-m-d'));
        $this->assertCount(2, $result);
    }
}
