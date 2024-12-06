<?php

namespace Database\Seeders;

use App\Models\Domin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DominSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Domin::Factory()->count(10)->create();

    }
}
