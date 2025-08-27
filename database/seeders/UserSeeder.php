<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Prüfe, ob der Benutzer bereits existiert
        if (!User::where('email', 'user@parkhaus.de')->exists()) {
            User::create([
                'name' => 'Test User',
                'email' => 'user@parkhaus.de',
                'password' => Hash::make('password'),
            ]);
        }
    }
}
