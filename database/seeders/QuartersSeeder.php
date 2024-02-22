<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Quarter;
use App\Models\Field;

class QuartersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fields = Field::all();
        foreach ($fields as $field) {
            Quarter::factory(rand(0, 6))->create([
                'field_id' => $field->id,
            ]);
        }
    }
}
