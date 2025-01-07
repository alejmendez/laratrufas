<?php

namespace Database\Factories;

use Modules\Fields\Models\Owner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Fields\Models\Field>
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
            'name' => 'field '.fake()->name(),
            'location' => fake()->numerify('##.######, -##.######'), // 41.191374, -95.394946
            'size' => fake()->numerify('###'), // 	123 m²
            'owner_id' => $owner->first()->id,
        ];
    }
}
