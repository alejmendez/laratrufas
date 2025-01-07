<?php

namespace Database\Seeders;

use Modules\Fields\Models\Owner;
use Illuminate\Database\Seeder;

class OwnersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Owner::factory(10)->create();
    }
}
