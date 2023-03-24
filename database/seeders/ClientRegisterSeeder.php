<?php

namespace Database\Seeders;

use App\Models\Type;
use App\Models\User;
use App\Models\Center;
use App\Models\Volume;
use App\Models\savingNominee;
use App\Models\ClientRegister;
use App\Models\SavingsProfile;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClientRegisterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 500; $i++) {
            $vol = Volume::inRandomOrder()->first()->id;
            $center = Center::inRandomOrder()->where('volume_id', $vol)->first()->id;
            $user = User::inRandomOrder()->first()->id;
            $accNO = fake()->unique()->numberBetween('223344', '556677');

            $client = new ClientRegister();
            $client->volume_id = $vol;
            $client->center_id = $center;
            $client->registration_officer_id = $user;
            $client->acc_no = $accNO;
            $client->name = fake()->name;
            $client->husband_or_father_name = fake()->name('male');
            $client->mother_name = fake()->name('female');
            $client->nid = fake()->numberBetween('22338477384', '7488577488394');
            $client->dob = fake()->date('Y-m-d', 'now');
            $client->religion = fake()->randomElement(['Islam', 'Hindu', 'Cristian', 'Buddha']);
            $client->occupation = fake()->word;
            $client->gender = fake()->randomElement(['Male', 'Female', 'Others']);
            $client->mobile = fake()->phoneNumber(11);
            $client->client_image = fake()->imageUrl('640', '480');
            $client->Present_address = fake()->address();
            $client->permanent_address = fake()->address();
            $client->save();
            $client_id = $client->id;

            $savings = new SavingsProfile();
            $savings->volume_id = $vol;
            $savings->center_id = $center;
            $savings->type_id = Type::where('savings', '1')->inRandomOrder()->first()->id;
            $savings->registration_officer_id = $user;
            $savings->client_id = $client_id;
            $savings->acc_no = $accNO;
            $savings->start_date = fake()->date('Y-m-d');
            $savings->duration_date = fake()->date('Y-m-d');
            $savings->deposit = fake()->numberBetween('20', '1000');
            $savings->installment = fake()->numberBetween('12', '56');
            $savings->total_except_interest = fake()->numberBetween('10000', '100000');
            $savings->interest = fake()->numberBetween('5', '50');
            $savings->total_include_interest = fake()->numberBetween('10000', '200000');
            $savings->save();
            $saving_id = $savings->id;

            savingNominee::create(
                [
                    'saving_profile_id' => $saving_id,
                    'name' => fake()->name,
                    'dob' => fake()->date('Y-m-d'),
                    'relation' => fake()->name,
                    'nominee_image' => fake()->imageUrl('640', '480'),
                ]
            );
        }
    }
}
