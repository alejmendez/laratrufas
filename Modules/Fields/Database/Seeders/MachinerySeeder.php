<?php

namespace Modules\Fields\Database\Seeders;

use Modules\Fields\Models\Machinery;
use Illuminate\Database\Seeder;

class MachinerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Machinery::factory()->count(10)->create();
    }
}
