<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\odel=Setting>
 */
class SettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'key' => fake()->word()
            ,
            'value' => fake()->word()
            ,
            'description' => fake()->sentence()
            ,
            'type' => fake()->word()
            ,
            'created_at' => now()
            ,
            'updated_at' => now()
        ];
    }
}
