<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\plants>
 */
class PlantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'age' => rand(1, 30),
            'planned_at' => fake()->date(),
            'nursery_origin' => fake()->name(),
            'code' => strtoupper(fake()->lexify('??-??-??')),
            'row' => strtoupper(fake()->randomLetter()),
        ];
    }
}
