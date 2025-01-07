<?php

namespace Database\Seeders;

use Modules\Fields\Models\Plant;
use Modules\Fields\Models\PlantType;
use Modules\Fields\Models\Quarter;
use Illuminate\Database\Seeder;

class PlantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PlantType::create(['name' => 'Encina', 'slug' => 'encina']);

        $plant_types_ids = PlantType::all()->pluck('id')->all();
        $plant_types_ids_count = count($plant_types_ids) - 1;

        $quarters = Quarter::all();
        foreach ($quarters as $quarter) {
            Plant::factory(rand(0, 10))->create([
                'quarter_id' => $quarter->id,
                'plant_type_id' => $plant_types_ids[rand(0, $plant_types_ids_count)],
            ]);
        }

    }
}
