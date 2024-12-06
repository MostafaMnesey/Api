<?php

namespace Database\Seeders;

use App\Models\Domin;
use App\Models\Setting;
use App\Models\User;
use Database\Seeders\DominSeeder;
use Illuminate\Database\Seeder;
use Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $str = Str::random(10);
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@' . $str . '.com',
        ]);

        $this->call([
            SettingSeeder::class,
            CitySeeder::class,
            DominSeeder::class,

        ]);
    }
}