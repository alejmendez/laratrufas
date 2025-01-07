<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Fields\Models\Dog>
 */
class DogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $genders = ['M', 'F'];

        return [
            'name' => 'dog '.fake()->name(),
            'breed' => fake()->name(),
            'gender' => $genders[rand(0, 1)],
            'birthdate' => fake()->date(),
            'veterinary' => fake()->name(),
        ];
    }
}
