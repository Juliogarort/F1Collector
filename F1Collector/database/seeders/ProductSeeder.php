<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Crear una categoría si no existe
        $categoryId = DB::table('f1collector_categories')->updateOrInsert([
            'name' => 'Fórmula 1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('f1collector_products')->insert([
            [
                'name' => 'Red Bull RB19 - Verstappen',
                'price' => 69.99,
                'team' => 'Red Bull Racing',
                'year' => 2023,
                'category_id' => $categoryId,
                'image' => 'images/redbull.webp',
                'description' => 'Modelo a escala 1:18 del Red Bull RB19, campeón del mundo con Max Verstappen en 2023.',
                'type' => 'Escala 1:18',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ferrari SF-23 - Leclerc',
                'price' => 59.99,
                'team' => 'Ferrari',
                'year' => 2023,
                'category_id' => $categoryId,
                'image' => 'images/ferrari.webp',
                'description' => 'Modelo a escala 1:18 del Ferrari SF-23 conducido por Charles Leclerc en 2023.',
                'type' => 'Escala 1:18',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mercedes W14 - Hamilton',
                'price' => 64.99,
                'team' => 'Mercedes',
                'year' => 2023,
                'category_id' => $categoryId,
                'image' => 'images/mercedes.webp',
                'description' => 'Modelo a escala 1:18 del Mercedes W14 pilotado por Lewis Hamilton en 2023.',
                'type' => 'Escala 1:18',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Alpine A523 - Gasly',
                'price' => 55.99,
                'team' => 'Alpine',
                'year' => 2023,
                'category_id' => $categoryId,
                'image' => 'images/alpine.webp',
                'description' => 'Modelo a escala 1:18 del Alpine A523 conducido por Pierre Gasly en 2023.',
                'type' => 'Escala 1:18',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'McLaren MCL60 - Norris',
                'price' => 62.99,
                'team' => 'McLaren',
                'year' => 2023,
                'category_id' => $categoryId,
                'image' => 'images/mclaren.webp',
                'description' => 'Modelo a escala 1:18 del McLaren MCL60 pilotado por Lando Norris en 2023.',
                'type' => 'Escala 1:18',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Alfa Romeo C43 - Bottas',
                'price' => 57.99,
                'team' => 'Alfa Romeo',
                'year' => 2023,
                'category_id' => $categoryId,
                'image' => 'images/alfaromeo.webp',
                'description' => 'Modelo a escala 1:18 del Alfa Romeo C43 conducido por Valtteri Bottas en 2023.',
                'type' => 'Escala 1:18',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Aston Martin AMR23 - Alonso',
                'price' => 60.99,
                'team' => 'Aston Martin',
                'year' => 2023,
                'category_id' => $categoryId,
                'image' => 'images/aston.webp',
                'description' => 'Modelo a escala 1:18 del Aston Martin AMR23 pilotado por Fernando Alonso en 2023.',
                'type' => 'Escala 1:18',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Haas VF-23 - Magnussen',
                'price' => 54.99,
                'team' => 'Haas',
                'year' => 2023,
                'category_id' => $categoryId,
                'image' => 'images/haas.webp',
                'description' => 'Modelo a escala 1:18 del Haas VF-23 conducido por Kevin Magnussen en 2023.',
                'type' => 'Escala 1:18',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'AlphaTauri AT04 - Tsunoda',
                'price' => 56.99,
                'team' => 'AlphaTauri',
                'year' => 2023,
                'category_id' => $categoryId,
                'image' => 'images/vicarb.webp',
                'description' => 'Modelo a escala 1:18 del AlphaTauri AT04 pilotado por Yuki Tsunoda en 2023.',
                'type' => 'Escala 1:18',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Williams FW45 - Albon',
                'price' => 53.99,
                'team' => 'Williams',
                'year' => 2023,
                'category_id' => $categoryId,
                'image' => 'images/williams.webp',
                'description' => 'Modelo a escala 1:18 del Williams FW45 conducido por Alex Albon en 2023.',
                'type' => 'Escala 1:18',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}