<?php

namespace Modules\Fields\Database\Seeders;

use Modules\Fields\Models\SecurityEquipment;
use Illuminate\Database\Seeder;

class SecurityEquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SecurityEquipment::factory()->count(10)->create();
    }
}
