<?php

namespace Database\Factories;

use App\Models\MotorCycle;
use Illuminate\Database\Eloquent\Factories\Factory;
class MotorCycleFactory extends VehicleFactory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MotorCycle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'year' => $this->faker->year(),
            'color' => $this->faker->colorName(),
            'price' => $this->faker->randomFloat(1000, 10000),
            'engine' => $this->faker->randomAscii(),
            'suspension_type' => $this->faker->word(),
            'transmision_type' => $this->faker->randomElement(['manual', 'automatic']),
        ];
    }
}
