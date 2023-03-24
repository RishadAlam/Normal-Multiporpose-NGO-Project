<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SavingsCollection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SavingsCollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SavingsCollection::factory(5000)->create();
    }
}
