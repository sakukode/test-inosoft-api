<?php

namespace Tests\Feature\API;

use App\Models\Car;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class OrderAPITest extends TestCase
{
    use WithFaker, DatabaseMigrations;

    /**
     * Test creating a new order.
     * 
     * @return void
     */
    public function test_can_create_order(): void
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();
        $car = Car::factory()->withStock(5)->create();
        $id = $car->getKey();

        $payload = [
            'quantity' => 1,
            'product' => [
                'id' => $id
            ],
            'customer' => [
                'name' => $this->faker->name(),
                'phone' => $this->faker->phoneNumber(),
                'address' => $this->faker->address()
            ]
        ];

        $response = $this->actingAs($user, 'api')
            ->postJson('/api/orders', $payload);

        $car->refresh();

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'status',
                'message'
            ]);

        $this->assertEquals(4, $car->stock);
    }

    /**
     * Test creating a new order with an invalid payload.
     *
     * @return void
     */
    public function test_cannot_create_order_with_invalid_payload(): void
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();
        $car = Car::factory()->withStock(1)->create();
        $id = $car->getKey();

        $payload = [
            'quantity' => 1,
            'product' => [
                'id' => $id
            ],
            // Missing customer name
            'customer' => [
                'phone' => $this->faker->phoneNumber(),
                'address' => $this->faker->address()
            ]
        ];

        $response = $this->actingAs($user, 'api')
            ->postJson('/api/orders', $payload);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure([
                'message',
                'errors',
                'status'
            ]);
    }

    /**
     * Test creating a new order with a non-existent vehicle.
     *
     * @return void
     */
    public function test_cannot_create_order_with_non_existent_vehicle(): void
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();

        $payload = [
            'quantity' => 1,
            'product' => [
                'id' => 'non-existent-id'
            ],
            'customer' => [
                'name' => $this->faker->name(),
                'phone' => $this->faker->phoneNumber(),
                'address' => $this->faker->address()
            ]
        ];

        $response = $this->actingAs($user, 'api')
            ->postJson('/api/orders', $payload);

        $response->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure([
                'status',
                'message'
            ]);
    }

    /**
     * Test creating a new order with an out-of-stock vehicle.
     *
     * @return void
     */
    public function test_cannot_create_order_with_out_of_stock_vehicle(): void
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();
        $car = Car::factory()->withStock(0)->create();
        $id = $car->getKey();

        $payload = [
            'quantity' => 1,
            'product' => [
                'id' => $id
            ],
            'customer' => [
                'name' => $this->faker->name(),
                'phone' => $this->faker->phoneNumber(),
                'address' => $this->faker->address()
            ]
        ];

        $response = $this->actingAs($user, 'api')
            ->postJson('/api/orders', $payload);

        $response->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure([
                'status',
                'message'
            ]);
    }
}
