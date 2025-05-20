<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Importa el modelo

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::insert([  // Usa el modelo en lugar de DB::table
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin1234'),
                'user_type' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cliente Normal',
                'email' => 'cliente@example.com',
                'password' => Hash::make('cliente1234'),
                'user_type' => 'Customer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Paco',
                'email' => 'paco@example.com',
                'password' => Hash::make('paco1234'),
                'user_type' => 'Customer',
                'created_at' => now(),
                'updated_at' => now(), 
            ],
            [
                'name' => 'Julio',
                'email' => 'julio@example.com',
                'password' => Hash::make('julio1234'),
                'user_type' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(), 
            ],
            [
                'name' => 'Alberto',
                'email' => 'alberto@example.com',
                'password' => Hash::make('alberto1234'),
                'user_type' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(), 
            ]
        ]);
    }
}