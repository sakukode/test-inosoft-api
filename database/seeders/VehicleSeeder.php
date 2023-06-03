<?php

namespace Database\Seeders;

use App\Models\Car;
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
        $car = Car::factory()->create();
        $car->push('stocks', [
            'date' => new UTCDateTime(Carbon::now()->format('Uv')),
            'quantity' => 10
        ]);
    }
}
