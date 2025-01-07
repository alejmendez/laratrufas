<?php

namespace Database\Seeders;

use Modules\Fields\Models\Field;
use Illuminate\Database\Seeder;

class FieldsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Field::factory(8)->create();
    }
}
