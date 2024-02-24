<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Quarter;
use App\Models\Field;
use App\Models\User;

class QuartersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fields = Field::all();
        // $users = User::role('Agricultor')->get();
        $users = User::all();
        $usersCount = count($users);
        foreach ($fields as $field) {
            Quarter::factory(rand(0, 6))->create([
                'field_id' => $field->id,
                'responsible_id' => $users[rand(0, $usersCount - 1)]->id,
            ]);
        }
    }
}
