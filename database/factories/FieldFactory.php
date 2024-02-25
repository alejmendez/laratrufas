<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Owner;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\fields>
 */
class FieldFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $owner = Owner::factory(1)->create();
        return [
            'name' => 'field ' . fake()->name(),
            'location' => fake()->numerify('##.######, -##.######'), // 41.191374, -95.394946
            'size' => fake()->numerify('###'), // 	123 m²
            'owner_id' => $owner->first()->id,
        ];
    }
}
