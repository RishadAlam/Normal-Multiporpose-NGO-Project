<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\SavingsCollection;
use App\Models\SavingsProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SavingsCollection>
 */
class SavingsCollectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SavingsCollection::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $SavingsCollection = SavingsProfile::inRandomOrder()->first();
        $id = $SavingsCollection->id;
        $volume = $SavingsCollection->volume_id;
        $center = $SavingsCollection->center_id;
        $savingType = $SavingsCollection->type_id;
        $savingType = $SavingsCollection->type_id;
        $client_id = $SavingsCollection->client_id;
        $acc_no = $SavingsCollection->acc_no;
        return [
            'saving_profile_id' => $id,
            'volume_id' => $volume,
            'center_id' => $center,
            'type_id' => $savingType,
            'officer_id' => User::inRandomOrder()->first()->id,
            'client_id' => $client_id,
            'acc_no' => $acc_no,
            'deposit' => fake()->numberBetween('50', '1000'),
            'expression' => fake()->sentence,
            'created_at' => fake()->date(),
            'updated_at' => fake()->date()
        ];
    }
}
