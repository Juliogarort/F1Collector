<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crea el usuario solo si no existe
        User::firstOrCreate(
            ['email' => 'test@example.com'], // condición de búsqueda
            [
                'name' => 'Test User',
                'password' => bcrypt('password123'), // puedes personalizarlo
            ]
        );

        // Llamada al seeder de productos si lo estás usando
        $this->call([
            ProductSeeder::class,
        ]);

        $this->call([
            UserSeeder::class,
        ]);
    }
}
