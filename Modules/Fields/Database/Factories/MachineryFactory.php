<?php

namespace Modules\Fields\Database\Factories;

use Modules\Fields\Models\Machinery;
use Illuminate\Database\Eloquent\Factories\Factory;

class MachineryFactory extends Factory
{
    protected $model = Machinery::class;

    public function definition()
    {
        return [
            'name' => fake()->word,
            'purchase_date' => fake()->date,
            'last_maintenance' => fake()->date,
            'purchase_location' => fake()->city,
            'type' => fake()->word,
            'contact' => fake()->phoneNumber,
        ];
    }
}
