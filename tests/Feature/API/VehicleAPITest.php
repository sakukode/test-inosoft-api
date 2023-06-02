<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VehicleAPITest extends TestCase
{
    use WithFaker, DatabaseMigrations;

    /**
     *
     * @return void
     */
    public function test_can_get_stock(): void
    {
        $id = $this->faker->randomDigit();
        $stock = 0;

        $response = $this->get("/api/vehicles/{$id}/stock");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'year',
                    'color',
                    'price',
                    'vehicle_type',
                    'specification',
                    'stock'
                ]
            ]);

        $responseJson = $response->decodeResponseJson();

        $this->assertEquals($stock, $responseJson['data']['stock']);
    }

    /**
     *
     * @return void
     */
    public function test_cannot_get_stock_product_not_found(): void
    {
        $id = $this->faker->randomAscii();

        $response = $this->get("/api/vehicles/{$id}/stock");

        $response->assertStatus(404)
            ->assertJsonStructure([
                'status',
                'message'
            ]);
    }
}
