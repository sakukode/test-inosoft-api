<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;
use MongoDB\BSON\UTCDateTime;

class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        ];
    }
    /**
     * Add stock to the vehicle.
     *
     * @param  int  $quantity
     * @return $this
     */
    public function withStock($quantity)
    {
        return $this->afterMaking(function (Vehicle $vehicle) use ($quantity) {
            $vehicle->push('stocks', [
                [
                    'date' => new UTCDateTime(Carbon::now()->format('Uv')),
                    'quantity' => $quantity
                ]
            ]);
        });
    }

    /**
     * Add orders to the vehicle.
     *
     * @param  int  $count
     * @return $this
     */
    public function withOrders($count)
    {
        return $this->afterMaking(function (Vehicle $vehicle) use ($count) {
            $orders = Order::factory()->count($count)->make();
            $vehicle->push('orders', $orders->toArray());
        });
    }
}
