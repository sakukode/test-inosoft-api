<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use MongoDB\BSON\UTCDateTime;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Car::factory()->withStock(0)->create();
        $car = Car::factory()->withStock(10)->withOrders(3)->create();
        $orders = Order::factory()->state([
            'date' => '2023-01-01'
        ])->count(2)->make();
        $car->push('orders', $orders->toArray());
    }
}
