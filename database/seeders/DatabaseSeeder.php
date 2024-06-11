<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (User::count() > 0) {
            return;
        }

        $seeders = [
            RolesSeeder::class,
            UserSeeder::class,
        ];

        if (app()->isLocal()) {
            $seeders = [
                RolesSeeder::class,
                UserSeeder::class,
                FieldsSeeder::class,
                QuartersSeeder::class,
                PlantsSeeder::class,
                DogSeeder::class,
                ToolsSeeder::class,
                MachineriesSeeder::class,
                // OwnersSeeder::class,
                // HarvestsSeeder::class,
            ];
        }
        $this->call($seeders);
    }
}
