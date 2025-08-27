<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Füge Seeder hinzu
        $this->call([
            ParkhausSeeder::class,
            UserSeeder::class,
            AdminSeeder::class,
        ]);
    }
}
