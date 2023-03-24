<?php

namespace Database\Factories;

use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Type>
 */
class TypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Type::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->unique()->name,
            'description' => fake()->paragraph,
            'savings' => fake()->randomElement([0, 1]),
            'loans' => fake()->randomElement([0, 1]),
            'time_period' => fake()->randomElement([1, 7, 15, 30, 365]),
        ];
    }
}
