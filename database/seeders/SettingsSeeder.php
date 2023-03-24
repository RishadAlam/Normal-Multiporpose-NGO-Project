<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'full_name' => 'Normal Multiporpose Co-Operative Society Limited',
            'short_name' => 'Normal Multipurpose',
            'tagline' => '(A Govt. Approved Savings & Financing Organization)',
            'address' => 'Oxygen, Baizid, Chattragram',
        ]);
    }
}
