<?php

namespace Tests\Feature\API;

use App\Models\Car;
use App\Models\Order;
use Tests\TestCase;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class OrderReportAPITest extends TestCase
{
    use WithFaker, DatabaseMigrations;

    /**
     * Test if the order reports can be retrieved successfully.
     *
     * @return void
     */
    public function test_can_get_order_reports(): void
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();
        $car = Car::factory()->withOrders(3)->create();
        $id = $car->getKey();

        $response = $this->actingAs($user, 'api')
            ->getJson("/api/vehicles/{$id}/order-reports");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    '*' => [
                        'date',
                        'quantity',
                        'price',
                        'total',
                        'customer' => [
                            'name',
                            'phone',
                            'address'
                        ]
                    ]
                ]
            ])
            ->assertJsonCount($car->orders->count(), 'data');
    }

    /**
     * Test if empty order reports are returned successfully.
     *
     * @return void
     */
    public function test_can_get_empty_order_reports(): void
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();
        $car = Car::factory()->create();
        $id = $car->getKey();

        $response = $this->actingAs($user, 'api')
            ->getJson("/api/vehicles/{$id}/order-reports");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data'
            ])
            ->assertJsonCount(0, 'data');
    }

    /**
     * Test if the order reports with filter can be retrieved successfully.
     *
     * @return void
     */
    public function test_can_get_order_reports_with_filter(): void
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();
        $car = Car::factory()->withOrders(3)->create();
        $id = $car->getKey();

        // add some orders
        $orders = Order::factory()->state([
            'date' => Carbon::createFromDate('2023-01-01'),
            'quantity' => 1
        ])->count(2)->make();

        $car->push('orders', $orders->toArray());

        $startDate = '2023-01-01';
        $endDate = '2023-01-02';

        $response = $this->actingAs($user, 'api')
            ->getJson("/api/vehicles/{$id}/order-reports?start_date={$startDate}&end_date={$endDate}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data'
            ])
            ->assertJsonCount($orders->count(), 'data');
    }
}
