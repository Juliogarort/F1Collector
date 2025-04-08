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
        // Llamada al seeder de productos si lo estás usando
        $this->call([
            ProductSeeder::class,
        ]);

        $this->call([
            UserSeeder::class,
        ]);
    }
}
