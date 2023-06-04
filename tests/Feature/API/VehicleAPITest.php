<?php

namespace Tests\Feature\API;

use App\Models\Car;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class VehicleAPITest extends TestCase
{
    use WithFaker, DatabaseMigrations;

    /**
     * Test if the vehicle stock can be retrieved.
     *
     * @return void
     */
    public function test_can_get_vehicle_stock(): void
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();

        $quantity = 10;
        $car = Car::factory()->withStock($quantity)->create();
        $id = $car->getKey();

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
     * Test if the stock of a non-existent vehicle cannot be retrieved.
     *
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
