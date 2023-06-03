<?php

namespace Tests\Feature\API;

use App\Models\Car;
use Tests\TestCase;
use App\Models\User;
use App\Models\Vehicle;
use App\Repositories\Vehicles\EloquentMongoVehicleRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class VehicleAPITest extends TestCase
{
    use WithFaker, DatabaseMigrations;

    protected $repo;

    public function setUp(): void
    {
        parent::setUp();

        $model = new Vehicle();
        $this->repo = new EloquentMongoVehicleRepository($model);
    }

    /**
     * Test getting stock of a vehicle.
     *
     * @return void
     */
    public function test_can_get_vehicle_stock(): void
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();
        $car = Car::factory()->create();
        $id = $car->getKey();
        $quantity = 10;

        $this->repo->addStock($id, $quantity);
        $car->refresh();

        $response = $this->actingAs($user, 'api')->getJson("/api/vehicles/{$id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'year',
                    'color',
                    'price',
                    'type',
                    'specification',
                    'stock'
                ]
            ])
            ->assertJsonPath('data.stock', $quantity);
    }

    /**
     * Test getting stock of a non-existent vehicle.
     * @return void
     */
    public function test_cannot_get_stock_non_existent_vehicle(): void
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();
        $id = 'non-existent-id';

        $response = $this->actingAs($user, 'api')->getJson("/api/vehicles/{$id}");

        $response->assertStatus(404)
            ->assertJsonStructure([
                'status',
                'message'
            ]);
    }
}
