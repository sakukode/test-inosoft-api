<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->state([
            'email' => 'admin@example.com',
            'password' => Hash::make('12345678')
        ])->create();

        $this->call(VehicleSeeder::class);
    }
}
