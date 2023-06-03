<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarFactory extends Factory
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
            'year' => $this->faker->year(),
            'color' => $this->faker->colorName(),
            'price' => $this->faker->randomFloat(1000, 10000),
            'engine' => $this->faker->randomAscii(),
            'seat' => $this->faker->randomElement([4, 6, 8]),
            'type' => $this->faker->randomElement(['suv', 'mpv', 'cvt']),
        ];
    }
}
