<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarFactory extends VehicleFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Car::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'year' => (int) $this->faker->numberBetween(1990, 2023),
            'color' => (string) $this->faker->colorName,
            'price' => (float) $this->faker->randomFloat(1000, 10000),
            'engine' => (string) $this->faker->randomAscii(),
            'seat' => (int) $this->faker->randomElement([4, 6, 8]),
            'type' => (string) $this->faker->randomElement(['suv', 'mpv', 'cvt']),
        ];
    }
}
