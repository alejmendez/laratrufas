<?php

namespace Database\Seeders;

use App\Models\SecurityEquipment;
use Illuminate\Database\Seeder;

class SecurityEquipmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SecurityEquipment::factory()->count(10)->create();
    }
}
