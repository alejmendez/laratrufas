<?php

namespace Database\Seeders;

use App\Models\Owner;
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
