<?php

namespace Tests\Feature\API;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;

class OrderAPITest extends TestCase
{
    use WithFaker, DatabaseMigrations;

    /**
     *
     * @return void
     */
    public function test_can_create_order(): void
    {
        $car = null;

        $payload = [
            'quantity' => $this->faker->randomDigit(),
            'product' => $car,
            'customer' => [
                'name' => $this->faker->name(),
                'phone' => $this->faker->phoneNumber(),
                'address' => $this->faker->address()
            ]
        ];

        $response = $this->post('/api/orders', $payload);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'product' => [
                        'id',
                        'year',
                        'color',
                        'price',
                        'vehicle_type',
                        'specification'
                    ],
                    'customer' => [
                        'name',
                        'phone',
                        'address'
                    ],
                    'quantity',
                    'price',
                    'total',
                ]
            ]);
    }

    /**
     *
     * @return void
     */
    public function test_cannot_create_order_invalid_data(): void
    {
        $car = null;

        $payload = [
            'quantity' => -1,
            'product' => $car,
            'customer' => [
                'phone' => $this->faker->phoneNumber(),
                'address' => $this->faker->address()
            ]
        ];

        $response = $this->post('/api/orders', $payload);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure([
                'status',
                'message',
                'errors'
            ]);
    }

    /**
     *
     * @return void
     */
    public function test_cannot_create_order_invalid_product(): void
    {
        $dummyCar = [
            'id' => $this->faker->randomAscii(),
            'year' => $this->faker->year(),
            'color' => $this->faker->colorName(),
            'price' => $this->faker->randomFloat(),
            'vehicle_type' => $this->faker->randomElement(['car', 'motorcycle']),
            'specification' => []
        ];

        $payload = [
            'quantity' => 1,
            'product' => $dummyCar,
            'customer' => [
                'name' => $this->faker->name(),
                'phone' => $this->faker->phoneNumber(),
                'address' => $this->faker->address()
            ]
        ];

        $response = $this->post('/api/orders', $payload);

        $response->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure([
                'status',
                'message',
            ]);
    }
}
