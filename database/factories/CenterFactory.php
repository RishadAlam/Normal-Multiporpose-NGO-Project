<?php

namespace Database\Factories;

use App\Models\Center;
use App\Models\Volume;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Center>
 */
class CenterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Center::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'volume_id' => Volume::inRandomOrder()->first()->id,
            'name' => fake()->unique()->name,
            'description' => fake()->paragraph,
        ];
    }
}
