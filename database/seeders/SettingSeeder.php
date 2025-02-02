<?php

namespace Database\Seeders;

use App\Models\Setting;
use Database\Factories\SettingFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $setting = Setting::factory()->count(50)->create();
    }
}
