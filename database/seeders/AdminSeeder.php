<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Super Admin
        if (!Admin::where('email', 'admin@parkhaus.de')->exists()) {
            Admin::create([
                'name' => 'Super Admin',
                'email' => 'admin@parkhaus.de',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'is_active' => true,
            ]);
        }

        // Parkhaus Manager
        if (!Admin::where('email', 'manager@parkhaus.de')->exists()) {
            Admin::create([
                'name' => 'Parkhaus Manager',
                'email' => 'manager@parkhaus.de',
                'password' => Hash::make('password'),
                'role' => 'parkhaus_admin',
                'parkhaus_id' => 1, // Erste Parkhaus-ID
                'is_active' => true,
            ]);
        }

        // Mitarbeiter
        if (!Admin::where('email', 'mitarbeiter@parkhaus.de')->exists()) {
            Admin::create([
                'name' => 'Mitarbeiter',
                'email' => 'mitarbeiter@parkhaus.de',
                'password' => Hash::make('password'),
                'role' => 'mitarbeiter',
                'parkhaus_id' => 1, // Erste Parkhaus-ID
                'is_active' => true,
            ]);
        }
    }
}
