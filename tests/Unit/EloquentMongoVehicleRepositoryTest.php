<?php

namespace Tests\Unit;

use Mockery;
use App\Models\Vehicle;
use App\Repositories\Vehicles\EloquentMongoVehicleRepository;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\TestCase;

class EloquentMongoVehicleRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    private $vehicleMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->vehicleMock = Mockery::mock(Vehicle::class);
    }
    /**
     *
     * @return void
     */
    public function test_can_find_vehicle_by_id()
    {
        $this->vehicleMock->shouldReceive('find')->andReturn($this->vehicleMock);

        $repository = new EloquentMongoVehicleRepository($this->vehicleMock);

        $result = $repository->findById(1);

        $this->assertSame($this->vehicleMock, $result);
    }

    public function test_can_add_stock_to_vehicle()
    {
        $this->vehicleMock->shouldReceive('find')
            ->andReturn($this->vehicleMock)
            ->shouldReceive('push')->once()
            ->andReturn($this->vehicleMock);

        $repository = new EloquentMongoVehicleRepository($this->vehicleMock);

        $result = $repository->addStock(1, 10);

        $this->assertNull($result);
    }

    public function test_can_deduct_stock_to_vehicle()
    {
        $this->vehicleMock->shouldReceive('find')
            ->andReturn($this->vehicleMock)
            ->shouldReceive('push')->once()
            ->andReturn($this->vehicleMock);

        $repository = new EloquentMongoVehicleRepository($this->vehicleMock);

        $result = $repository->deductStock(1, 10);

        $this->assertNull($result);
    }

    public function test_cannot_find_non_existent_vehicle()
    {
        $this->vehicleMock->shouldReceive('find')->andReturn(null);

        $repository = new EloquentMongoVehicleRepository($this->vehicleMock);

        $this->expectException(RecordsNotFoundException::class);
        $repository->findById('non-existent-id');
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
