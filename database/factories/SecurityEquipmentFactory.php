<?php

namespace Database\Factories;

use Modules\Fields\Models\SecurityEquipment;
use Illuminate\Database\Eloquent\Factories\Factory;

class SecurityEquipmentFactory extends Factory
{
    protected $model = SecurityEquipment::class;

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
