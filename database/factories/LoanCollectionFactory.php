<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\LoanProfile;
use App\Models\LoanCollection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LoanCollection>
 */
class LoanCollectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LoanCollection::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $LoanProfile = LoanProfile::inRandomOrder()->first();
        $id = $LoanProfile->id;
        $volume = $LoanProfile->volume_id;
        $center = $LoanProfile->center_id;
        $loanType = $LoanProfile->type_id;
        $client_id = $LoanProfile->client_id;
        $acc_no = $LoanProfile->acc_no;
        return [
            'loan_profile_id' => $id,
            'volume_id' => $volume,
            'center_id' => $center,
            'type_id' => $loanType,
            'officer_id' => User::inRandomOrder()->first()->id,
            'client_id' => $client_id,
            'acc_no' => $acc_no,
            'installment' => 1,
            'deposit' => fake()->numberBetween('50', '1000'),
            'loan' => fake()->numberBetween('50', '5000'),
            'interest' => fake()->numberBetween('50', '1000'),
            'total' => fake()->numberBetween('50', '10000'),
            'expression' => fake()->sentence,
            'created_at' => fake()->date(),
            'updated_at' => fake()->date()
        ];
    }
}
