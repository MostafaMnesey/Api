<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Districts;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\City>
 */
class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */


    public function definition(): array
    {
        return [
            "name" => $this->faker->city,
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function (City $city) {
            Districts::factory()->count(5)->create(['city_id' => $city->id]);
        });
    }
}
