<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@fittrack.test'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'demo@fittrack.test'],
            [
                'name' => 'Demo User',
                'password' => Hash::make('password'),
                'role' => 'user',
                'age' => 28,
                'gender' => 'other',
                'height_cm' => 175,
                'weight_kg' => 72,
                'activity_level' => 'moderate',
            ]
        );
    }
}
