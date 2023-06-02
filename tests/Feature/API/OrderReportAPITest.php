<?php

namespace Tests\Feature\API;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderReportAPITest extends TestCase
{
    use WithFaker, DatabaseMigrations;
    
    /**
     *
     * @return void
     */
    public function test_can_get_order_reports(): void
    {
        $id = "";

        $response = $this->get("/api/vehicles/{$id}/order-reports");

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
                    'detail',
                    'order_reports' => [
                        'month',
                        'year',
                        'total'
                    ]
                ]
            ]);
    }

    /**
     * @return void
     */
    public function test_can_get_empty_order_reports(): void
    {
        $id = "";

        $response = $this->get("/api/vehicles/{$id}/order-reports");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data'
            ]);
        
        $responseJson = $response->decodeResponseJson();

        $this->assertEmpty($responseJson['data']);
    }
}
