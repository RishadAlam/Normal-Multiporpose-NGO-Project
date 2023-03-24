<?php

namespace Database\Seeders;

use App\Models\Type;
use App\Models\User;
use App\Models\LoanProfile;
use App\Models\LoanGuarantor;
use App\Models\ClientRegister;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LoanProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 500; $i++) {

            $ClientRegister = ClientRegister::inRandomOrder()->first();
            $center = $ClientRegister->center_id;
            $vol = $ClientRegister->volume_id;
            $accNo = $ClientRegister->acc_no;
            $client_id = $ClientRegister->id;
            $user = User::inRandomOrder()->first()->id;

            $loan = new LoanProfile();
            $loan->volume_id = $vol;
            $loan->center_id = $center;
            $loan->type_id = Type::where('loans', true)->inRandomOrder()->first()->id;
            $loan->registration_officer_id = $user;
            $loan->client_id = $client_id;
            $loan->acc_no = $accNo;
            $loan->start_date = fake()->date('Y-m-d');
            $loan->duration_date = fake()->date('Y-m-d');
            $loan->deposit = fake()->numberBetween('20', '1000');
            $loan->loan_given = fake()->numberBetween('10000', '200000');
            $loan->total_installment = fake()->numberBetween('12', '58');
            $loan->interest = fake()->numberBetween('5', '50');
            $loan->total_interest = fake()->numberBetween('10000', '50000');
            $loan->total_loan_inc_int = fake()->numberBetween('10000', '200000');
            $loan->loan_installment = fake()->numberBetween('500', '5000');
            $loan->interest_installment = fake()->numberBetween('1', '1000');
            $loan->save();
            $loanID = $loan->id;

            LoanGuarantor::create(
                [
                    'loan_profile_id' => $loanID,
                    'name' => fake()->name,
                    'father_name' => fake()->name,
                    'mother_name' => fake()->name,
                    'nid' => fake()->numberBetween('22338477384', '7488577488394'),
                    'address' => fake()->address(),
                    'guarentor_image' => fake()->imageUrl('640', '480'),
                ]
            );
        }
    }
}
