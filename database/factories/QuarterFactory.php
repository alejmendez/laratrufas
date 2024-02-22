<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\quarters>
 */
class QuarterFactory extends Factory
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
            'location' => fake()->numerify('##.######, -##.######'), // 41.191374, -95.394946
            'area' => fake()->numerify('##.###'),
            'planned_at' => fake()->date(),
        ];
    }
}
