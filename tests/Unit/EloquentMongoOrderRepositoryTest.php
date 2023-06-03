<?php

namespace Tests\Unit;

use App\Exceptions\OutOfStockException;
use Mockery;
use App\Models\Vehicle;
use App\Repositories\Orders\EloquentMongoOrderRepository;
use App\Repositories\Vehicles\EloquentMongoVehicleRepository;
use Exception;
use Illuminate\Database\RecordsNotFoundException;
use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EloquentMongoOrderRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    private $vehicleMock;
    private $orderRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->vehicleMock = Mockery::mock(Vehicle::class); 
        
        $vehicleRepository = new EloquentMongoVehicleRepository($this->vehicleMock);
        $this->orderRepository = new EloquentMongoOrderRepository($vehicleRepository);
    }
    
    /**
     *
     * @return void
     */
    public function test_can_create_order(): void
    {
        $this->vehicleMock->shouldReceive('find')->andReturn($this->vehicleMock)
            ->shouldReceive('push')->andReturn($this->vehicleMock)
            ->shouldReceive('getAttribute')->with('stock')->andReturn(10)
            ->shouldReceive('getAttribute')->with('price')->andReturn(1000);

        $attributes = [
            'product' => [
                'id' => 1
            ],
            'quantity' => 1,
            'customer' => [
                'name' => 'john doe',
                'phone' => '+628888888',
                'address' => 'Semarang'
            ]
        ];

        $result = $this->orderRepository->create($attributes);

        $this->assertNull($result);
    }

    /**
     *
     * @return void
     */
    public function test_cannot_create_order_with_out_of_stock_vehicle(): void
    {
        $this->vehicleMock->shouldReceive('find')->andReturn($this->vehicleMock)
            ->shouldReceive('push')->andReturn($this->vehicleMock)
            ->shouldReceive('getAttribute')->with('stock')->andReturn(0)
            ->shouldReceive('getAttribute')->with('price')->andReturn(1000);

        $attributes = [
            'product' => [
                'id' => 'non-existent-id'
            ],
            'quantity' => 1,
            'customer' => [
                'name' => 'john doe',
                'phone' => '+628888888',
                'address' => 'Semarang'
            ]
        ];

        $this->expectException(OutOfStockException::class);
        $this->orderRepository->create($attributes);
    }

    /**
     *
     * @return void
     */
    public function test_cannot_create_order_with_invalid_payload(): void
    {
        $this->vehicleMock->shouldReceive('find')->andReturn($this->vehicleMock)
            ->shouldReceive('push')->andReturn($this->vehicleMock)
            ->shouldReceive('getAttribute')->with('stock')->andReturn(0)
            ->shouldReceive('getAttribute')->with('price')->andReturn(1000);

        $attributes = [
            'quantity' => 1,
            'customer' => [
                'name' => 'john doe',
                'phone' => '+628888888',
                'address' => 'Semarang'
            ]
        ];

        $this->expectException(Exception::class);
        $this->orderRepository->create($attributes);
    }

    /**
     *
     * @return void
     */
    public function test_cannot_create_order_with_non_existent_vehicle(): void
    {
        $this->vehicleMock->shouldReceive('find')->andReturn(null)
            ->shouldReceive('push')->andReturn($this->vehicleMock)
            ->shouldReceive('getAttribute')->with('stock')->andReturn(0)
            ->shouldReceive('getAttribute')->with('price')->andReturn(1000);

        $attributes = [
            'product' => [
                'id' => 'non-existent-id'
            ],
            'quantity' => 1,
            'customer' => [
                'name' => 'john doe',
                'phone' => '+628888888',
                'address' => 'Semarang'
            ]
        ];

        $this->expectException(RecordsNotFoundException::class);
        $this->orderRepository->create($attributes);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
