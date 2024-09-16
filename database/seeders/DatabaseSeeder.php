<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

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
            CategoryProductSeeder::class,
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
                SecurityEquipmentsSeeder::class,
                // OwnersSeeder::class,
                // HarvestsSeeder::class,
            ];
        }
        $this->call($seeders);
    }
}
