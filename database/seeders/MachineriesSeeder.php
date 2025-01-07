<?php

namespace Database\Seeders;

use Modules\Fields\Models\Machinery;
use Illuminate\Database\Seeder;

class MachineriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Machinery::factory()->count(10)->create();
    }
}
