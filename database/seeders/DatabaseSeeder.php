<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Center;
use App\Models\Type;
use App\Models\Volume;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Seeder
        $this->call(
            [
                UserSeeder::class,
                PermissionsSeeder::class,
                SettingsSeeder::class,
                VolumeSeeder::class,
                CenterSeeder::class,
                TypeSeeder::class,
                ClientRegisterSeeder::class,
                LoanProfileSeeder::class,
                SavingsCollectionSeeder::class,
                LoansCollectionSeeder::class
            ]
        );
    }
}
