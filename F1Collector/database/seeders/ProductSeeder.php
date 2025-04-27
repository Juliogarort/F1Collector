<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Team;
use App\Models\Scale;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Crear primero las escuderías (teams)
        $teams = [
            'Red Bull Racing',
            'Ferrari',
            'Mercedes',
            'Alpine',
            'McLaren',
            'Alfa Romeo',
            'Aston Martin',
            'Haas',
            'AlphaTauri',
            'Williams',
            'Uralkali Haas F1 Team',
            'Lotus',
            'McLaren Mercedes',
            'Renaul. F1 Team'
        ];

        foreach ($teams as $teamName) {
            Team::firstOrCreate(['name' => $teamName]);
        }

        // Crear las escalas
        $scales = ['1:18', '1:24', '1:43'];

        foreach ($scales as $scaleValue) {
            Scale::firstOrCreate(['value' => $scaleValue]);
        }

        // Crear una categoría si no existe
        $categoryId = DB::table('f1collector_categories')->insertGetId([
            'name' => 'Fórmula 1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear productos con relaciones a teams y scales
        $products = [
            [
                'name' => 'Red Bull RB19 - Verstappen',
                'price' => 69.99,
                'team_name' => 'Red Bull Racing',
                'year' => 2023,
                'category_id' => $categoryId,
                'image' => 'images/redbull.webp',
                'description' => 'Modelo a escala 1:18 del Red Bull RB19, campeón del mundo con Max Verstappen en 2023.',
                'scale_value' => '1:18',
            ],
            [
                'name' => 'Ferrari SF-23 - Leclerc',
                'price' => 59.99,
                'team_name' => 'Ferrari',
                'year' => 2023,
                'category_id' => $categoryId,
                'image' => 'images/ferrari.webp',
                'description' => 'Modelo a escala 1:18 del Ferrari SF-23 conducido por Charles Leclerc en 2023.',
                'scale_value' => '1:18',
            ],
            [
                'name' => 'Mercedes W14 - Hamilton',
                'price' => 64.99,
                'team_name' => 'Mercedes',
                'year' => 2023,
                'category_id' => $categoryId,
                'image' => 'images/mercedes.webp',
                'description' => 'Modelo a escala 1:18 del Mercedes W14 pilotado por Lewis Hamilton en 2023.',
                'scale_value' => '1:18',
            ],
            [
                'name' => 'Alpine A523 - Gasly',
                'price' => 55.99,
                'team_name' => 'Alpine',
                'year' => 2023,
                'category_id' => $categoryId,
                'image' => 'images/alpine.webp',
                'description' => 'Modelo a escala 1:18 del Alpine A523 conducido por Pierre Gasly en 2023.',
                'scale_value' => '1:18',
            ],
            [
                'name' => 'McLaren MCL60 - Norris',
                'price' => 62.99,
                'team_name' => 'McLaren',
                'year' => 2023,
                'category_id' => $categoryId,
                'image' => 'images/mclaren.webp',
                'description' => 'Modelo a escala 1:18 del McLaren MCL60 pilotado por Lando Norris en 2023.',
                'scale_value' => '1:18',
            ],
            [
                'name' => 'Alfa Romeo C43 - Bottas',
                'price' => 57.99,
                'team_name' => 'Alfa Romeo',
                'year' => 2023,
                'category_id' => $categoryId,
                'image' => 'images/alfaromeo.webp',
                'description' => 'Modelo a escala 1:18 del Alfa Romeo C43 conducido por Valtteri Bottas en 2023.',
                'scale_value' => '1:18',
            ],
            [
                'name' => 'Aston Martin AMR23 - Alonso',
                'price' => 60.99,
                'team_name' => 'Aston Martin',
                'year' => 2023,
                'category_id' => $categoryId,
                'image' => 'images/aston.webp',
                'description' => 'Modelo a escala 1:18 del Aston Martin AMR23 pilotado por Fernando Alonso en 2023.',
                'scale_value' => '1:18',
            ],
            [
                'name' => 'Haas VF-23 - Magnussen',
                'price' => 54.99,
                'team_name' => 'Haas',
                'year' => 2023,
                'category_id' => $categoryId,
                'image' => 'images/haas.webp',
                'description' => 'Modelo a escala 1:18 del Haas VF-23 conducido por Kevin Magnussen en 2023.',
                'scale_value' => '1:18',
            ],
            [
                'name' => 'AlphaTauri AT04 - Tsunoda',
                'price' => 56.99,
                'team_name' => 'AlphaTauri',
                'year' => 2023,
                'category_id' => $categoryId,
                'image' => 'images/vicarb.webp',
                'description' => 'Modelo a escala 1:18 del AlphaTauri AT04 pilotado por Yuki Tsunoda en 2023.',
                'scale_value' => '1:18',
            ],
            [
                'name' => 'Williams FW45 - Albon',
                'price' => 53.99,
                'team_name' => 'Williams',
                'year' => 2023,
                'category_id' => $categoryId,
                'image' => 'images/williams.webp',
                'description' => 'Modelo a escala 1:18 del Williams FW45 conducido por Alex Albon en 2023.',
                'scale_value' => '1:18',
            ],
            [
                'name' => 'Scuderia Ferrari F1-2000 - Schumacher',
                'price' => 69.90,
                'team_name' => 'Ferrari',
                'year' => 2000,
                'category_id' => $categoryId,
                'image' => 'images/ferrai-Schumi.jpg',
                'description' => 'Réplica oficial del Ferrari F1-2000, utilizado por Michael Schumacher en el Gran Premio de Europa de Fórmula 1 de 2000.',
                'scale_value' => '1:43',
            ],
            [
                'name' => 'McLAREN MP 4/4 - Senna',
                'price' => 69.90,
                'team_name' => 'McLaren',
                'year' => 1988,
                'category_id' => $categoryId,
                'image' => 'images/mcl-senna.jpg',
                'description' => 'Réplica oficial del McLaren MP4/4, utilizado por Ayrton Senna en el Gran Premio de Mónaco de Fórmula 1 de 1988.',
                'scale_value' => '1:24',
            ],
            [
                'name' => 'HAAS VF 21 - Mazepin',
                'price' => 69.90,
                'team_name' => 'Uralkali Haas F1 Team',
                'year' => 2021,
                'category_id' => $categoryId,
                'image' => 'images/mazepin.jpg',
                'description' => 'Réplica oficial del Haas VF-21, utilizado por Nikita Mazepin en 2021.',
                'scale_value' => '1:43',
            ],
            [
                'name' => 'Lotus 72D - Fittipaldi',
                'price' => 69.90,
                'team_name' => 'Lotus',
                'year' => 1972,
                'category_id' => $categoryId,
                'image' => 'images/lotus.jpg',
                'description' => 'Réplica oficial del Lotus 72D, utilizado por Emerson Fittipaldi.',
                'scale_value' => '1:24',
            ],
            [
                'name' => 'McLAREN M23 - James Hunt',
                'price' => 39.90,
                'team_name' => 'McLaren',
                'year' => '1976',
                'category_id' => $categoryId,
                'image' => 'images/hunt.jpg',
                'description' => 'Réplica oficial del McLaren M23, utilizado por James Hunt en 1976.',
                'scale_value' => '1:24',
            ],
            [
                'name' => 'Renault R25 - Fernando Alonso',
                'price' => 9999.99,
                'team_name' => 'Renaul. F1 Team',
                'year' => '2005',
                'category_id' => $categoryId,
                'image' => 'images/r25.jpg',
                'description' => 'Réplica oficial del Renault R25, monoplaza campeón del mundo en 2005, pilotado por Fernando Alonso.',
                'scale_value' => '1:18',
            ],
            [
                'name' => 'McLAREN MP 4/23 Lewis Hamilton',
                'price' => 23.97,
                'team_name' => 'McLaren Mercedes',
                'year' => '2008',
                'category_id' => $categoryId,
                'image' => 'images/vodafone.jpg',
                'description' => 'Réplica oficial del McLaren MP4/23, monoplaza campeón del mundo en 2008, pilotado por Lewis Hamilton.',
                'scale_value' => '1:43',
            ],
        ];

        // Insertar los productos con relaciones a teams y scales
        foreach ($products as $productData) {
            // Obtener IDs de team y scale
            $team = Team::where('name', $productData['team_name'])->first();
            $scale = Scale::where('value', $productData['scale_value'])->first();

            if ($team && $scale) {
                DB::table('f1collector_products')->insert([
                    'name' => $productData['name'],
                    'price' => $productData['price'],
                    'team_id' => $team->id, // Usar team_id en lugar de team
                    'year' => $productData['year'],
                    'category_id' => $productData['category_id'],
                    'image' => $productData['image'],
                    'description' => $productData['description'],
                    'scale_id' => $scale->id, // Usar scale_id en lugar de type
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}