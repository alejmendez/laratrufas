<?php

namespace Modules\Fields\Database\Seeders;

use Modules\Fields\Models\Tool;
use Illuminate\Database\Seeder;

class ToolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tool::factory()->count(10)->create();
    }
}
