<?php

namespace Database\Seeders;

use Modules\Fields\Models\Dog;
use Modules\Fields\Models\Quarter;
use Modules\Users\Models\User;
use Illuminate\Database\Seeder;

class DogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $quarters = Quarter::all();
        $users = User::all();
        $usersCount = count($users);
        foreach ($quarters as $quarter) {
            Dog::factory(rand(0, 2))->create([
                'quarter_id' => $quarter->id,
                'couple_id' => $users[rand(0, $usersCount - 1)]->id,
            ]);
        }
    }
}
