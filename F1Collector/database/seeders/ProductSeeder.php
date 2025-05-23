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
        // Lista reducida de escuderías (solo las que tendrán productos)
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
            'Renault F1 Team',
            // Equipos históricos que tendrán productos
            'Brabham',
            'Tyrrell',
            'BRM',
            'Cooper',
            'Matra',
            'Benetton',
            'Jordan',
            'Minardi',
            'Arrows',
            'Ligier',
            'Brawn GP',  // Corregido para que coincida
            'Toyota',
            'Honda',
            'Jaguar',
            'Marussia',
            'HRT',
            'Caterham',
            'Eagle'
        ];

        foreach ($teams as $teamName) {
            Team::firstOrCreate(['name' => $teamName]);
        }

        // Expandir las escalas
        $scales = ['1:18', '1:24', '1:43', '1:64', '1:8', '1:12', '1:32'];

        foreach ($scales as $scaleValue) {
            Scale::firstOrCreate(['value' => $scaleValue]);
        }

        // Crear una categoría si no existe
        $categoryId = DB::table('f1collector_categories')->insertGetId([
            'name' => 'Fórmula 1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Productos existentes (los 17 primeros que ya tenías, sin cambios)
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
                'image' => 'images/vicarb2.webp',
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
                'image' => 'images/ferrai-Schumi.webp',
                'description' => 'Réplica oficial del Ferrari F1-2000, utilizado por Michael Schumacher en el Gran Premio de Europa de Fórmula 1 de 2000.',
                'scale_value' => '1:43',
            ],
            [
                'name' => 'McLAREN MP 4/4 - Senna',
                'price' => 69.90,
                'team_name' => 'McLaren',
                'year' => 1988,
                'category_id' => $categoryId,
                'image' => 'images/mcl-senna.webp',
                'description' => 'Réplica oficial del McLaren MP4/4, utilizado por Ayrton Senna en el Gran Premio de Mónaco de Fórmula 1 de 1988.',
                'scale_value' => '1:24',
            ],
            [
                'name' => 'HAAS VF 21 - Mazepin',
                'price' => 69.90,
                'team_name' => 'Uralkali Haas F1 Team',
                'year' => 2021,
                'category_id' => $categoryId,
                'image' => 'images/mazepin.webp',
                'description' => 'Réplica oficial del Haas VF-21, utilizado por Nikita Mazepin en 2021.',
                'scale_value' => '1:43',
            ],
            [
                'name' => 'Lotus 72D - Fittipaldi',
                'price' => 69.90,
                'team_name' => 'Lotus',
                'year' => 1972,
                'category_id' => $categoryId,
                'image' => 'images/lotus.webp',
                'description' => 'Réplica oficial del Lotus 72D, utilizado por Emerson Fittipaldi.',
                'scale_value' => '1:24',
            ],
            [
                'name' => 'McLAREN M23 - James Hunt',
                'price' => 39.90,
                'team_name' => 'McLaren',
                'year' => 1976,
                'category_id' => $categoryId,
                'image' => 'images/hunt.webp',
                'description' => 'Réplica oficial del McLaren M23, utilizado por James Hunt en 1976.',
                'scale_value' => '1:24',
            ],
            [
                'name' => 'Renault R25 - Fernando Alonso',
                'price' => 9999.99,
                'team_name' => 'Renault F1 Team',
                'year' => 2005,
                'category_id' => $categoryId,
                'image' => 'images/r25.webp',
                'description' => 'Réplica oficial del Renault R25, monoplaza campeón del mundo en 2005, pilotado por Fernando Alonso.',
                'scale_value' => '1:18',
            ],
            [
                'name' => 'McLAREN MP 4/23 Lewis Hamilton',
                'price' => 23.97,
                'team_name' => 'McLaren Mercedes',
                'year' => 2008,
                'category_id' => $categoryId,
                'image' => 'images/vodafone.webp',
                'description' => 'Réplica oficial del McLaren MP4/23, monoplaza campeón del mundo en 2008, pilotado por Lewis Hamilton.',
                'scale_value' => '1:43',
            ],
            
            // Añadimos 16 productos más SIN IMAGEN para llegar a un total de 33
            // Ahora incluimos los equipos que nos faltaban: Brawn GP, Sauber, Honda, Toyota, Jaguar, Caterham
            [
                'name' => 'Brabham BT52 - Nelson Piquet',
                'price' => 149.99,
                'team_name' => 'Brabham',
                'year' => 1983,
                'category_id' => $categoryId,
                'image' => 'images/Brabham-BT52.webp', 
                'description' => 'Réplica del innovador Brabham BT52 diseñado por Gordon Murray con el que Nelson Piquet ganó el campeonato de 1983. Primer coche campeón con motor turbo.',
                'scale_value' => '1:18',
            ],
            [
                'name' => 'Tyrrell P34 - Six Wheeler',
                'price' => 179.99,
                'team_name' => 'Tyrrell',
                'year' => 1976,
                'category_id' => $categoryId,
                'image' => 'images/Tyrrell-P34.webp',
                'description' => 'El revolucionario Tyrrell P34 de seis ruedas, pilotado por Jody Scheckter. Un diseño único en la historia de la F1 con cuatro ruedas delanteras.',
                'scale_value' => '1:18',
            ],
            [
                'name' => 'Brawn GP BGP 001 - Jenson Button',
                'price' => 129.90,
                'team_name' => 'Brawn GP', // Corregido para que coincida con el equipo
                'year' => 2009,
                'category_id' => $categoryId,
                'image' => 'images/Brawn-GP-BGP001.webp', 
                'description' => 'El histórico Brawn GP BGP 001 con el que Jenson Button ganó el mundial en la primera y única temporada del equipo Brawn GP.',
                'scale_value' => '1:43',
            ],
            [
                'name' => 'Jordan 191 - Michael Schumacher',
                'price' => 159.99,
                'team_name' => 'Jordan',
                'year' => 1991,
                'category_id' => $categoryId,
                'image' => 'images/Jordan-191.webp', 
                'description' => 'El Jordan 191 con el que Michael Schumacher debutó en Fórmula 1 en el GP de Bélgica. Considerado uno de los monoplazas más bellos de la historia.',
                'scale_value' => '1:18',
            ],
            [
                'name' => 'Benetton B194 - Schumacher',
                'price' => 139.99,
                'team_name' => 'Benetton',
                'year' => 1994,
                'category_id' => $categoryId,
                'image' => 'images/Benetton-B194.webp', 
                'description' => 'El Benetton B194 con el que Michael Schumacher ganó su primer campeonato mundial en 1994, en una temporada marcada por la tragedia.',
                'scale_value' => '1:18',
            ],
            [
                'name' => 'BRM P160 - Jo Siffert',
                'price' => 189.99,
                'team_name' => 'BRM',
                'year' => 1971,
                'category_id' => $categoryId,
                'image' => 'images/BRM-P160.webp', 
                'description' => 'El BRM P160 pilotado por Jo Siffert. Representante de la era de los motores V12 atmosféricos de principios de los 70.',
                'scale_value' => '1:18',
            ],
            [
                'name' => 'Cooper T51 - Jack Brabham',
                'price' => 199.99,
                'team_name' => 'Cooper',
                'year' => 1959,
                'category_id' => $categoryId,
                'image' => 'images/Cooper-T51.webp', 
                'description' => 'El revolucionario Cooper T51 con motor trasero que cambió la F1 para siempre. Jack Brabham ganó el mundial con este coche en 1959.',
                'scale_value' => '1:18',
            ],
            [
                'name' => 'Matra MS80 - Jackie Stewart',
                'price' => 169.99,
                'team_name' => 'Matra',
                'year' => 1969,
                'category_id' => $categoryId,
                'image' => 'images/Matra-MS80.webp', 
                'description' => 'El Matra MS80 con motor Ford Cosworth DFV con el que Jackie Stewart ganó su primer campeonato mundial en 1969.',
                'scale_value' => '1:18',
            ],
            [
                'name' => 'Arrows A22 - Jos Verstappen',
                'price' => 89.99,
                'team_name' => 'Arrows',
                'year' => 2001,
                'category_id' => $categoryId,
                'image' => 'images/Arrows-A22.webp', 
                'description' => 'El Arrows A22 pilotado por Jos Verstappen, padre de Max Verstappen, en la temporada 2001. Un coche de un equipo modesto de la era moderna.',
                'scale_value' => '1:43',
            ],
            [
                'name' => 'Toyota TF109 - Jarno Trulli',
                'price' => 79.99,
                'team_name' => 'Toyota', // Ahora usando Toyota
                'year' => 2009,
                'category_id' => $categoryId,
                'image' => 'images/Toyota-TF109.webp', 
                'description' => 'El Toyota TF109 de la última temporada del equipo Toyota en F1. Pilotado por Jarno Trulli, especialista en clasificación.',
                'scale_value' => '1:43',
            ],
            [
                'name' => 'Honda RA300 - John Surtees',
                'price' => 259.99,
                'team_name' => 'Honda', // Ahora usando Honda
                'year' => 1967,
                'category_id' => $categoryId,
                'image' => 'images/Honda-RA300.webp', 
                'description' => 'El Honda RA300 con el que John Surtees ganó el GP de Italia en 1967. Una obra maestra de ingeniería japonesa de la época.',
                'scale_value' => '1:12',
            ],
            [
                'name' => 'Ligier JS11 - Jacques Laffite',
                'price' => 149.99,
                'team_name' => 'Ligier',
                'year' => 1979,
                'category_id' => $categoryId,
                'image' => 'images/Ligier-JS11.webp', 
                'description' => 'El Ligier JS11 con su característica pintura azul "Gitanes", uno de los coches más competitivos del equipo francés que llegó a liderar el campeonato.',
                'scale_value' => '1:18',
            ],
            [
                'name' => 'Minardi M198 - Esteban Tuero',
                'price' => 69.99,
                'team_name' => 'Minardi',
                'year' => 1998,
                'category_id' => $categoryId,
                'image' => 'images/Minardi-M198.webp', 
                'description' => 'El Minardi M198 pilotado por el argentino Esteban Tuero. Un clásico de las escuderías modestas que tanto carácter daban a la F1.',
                'scale_value' => '1:43',
            ],
            [
                'name' => 'Marussia MR03 - Jules Bianchi',
                'price' => 89.99,
                'team_name' => 'Marussia',
                'year' => 2014,
                'category_id' => $categoryId,
                'image' => 'images/Marussia-MR03.webp', 
                'description' => 'El Marussia MR03 con el que Jules Bianchi consiguió los primeros puntos para el equipo en el GP de Mónaco. Un coche de un equipo modesto que logró un resultado histórico.',
                'scale_value' => '1:43',
            ],
            [
                'name' => 'HRT F112 - Pedro de la Rosa',
                'price' => 59.99,
                'team_name' => 'HRT',
                'year' => 2012,
                'category_id' => $categoryId,
                'image' => 'images/HRT-F112.webp', 
                'description' => 'El HRT F112 del último año del equipo español en la F1, pilotado por Pedro de la Rosa. Una pieza de colección de un equipo que ya forma parte de la historia.',
                'scale_value' => '1:43',
            ],
            [
                'name' => 'Eagle T1G - Dan Gurney',
                'price' => 399.99,
                'team_name' => 'Eagle',
                'year' => 1967,
                'category_id' => $categoryId,
                'image' => 'images/Eagle-T1G.webp', 
                'description' => 'El exclusivo Eagle T1G con el que Dan Gurney ganó el GP de Bélgica 1967. Uno de los coches más hermosos jamás creados y el único equipo estadounidense en ganar con su propio coche.',
                'scale_value' => '1:12',
            ],
            // Nuevos modelos para los equipos faltantes
            [
                'name' => 'Sauber C12 - Karl Wendlinger',
                'price' => 129.99,
                'team_name' => 'Sauber', // Añadiendo Sauber
                'year' => 1993,
                'category_id' => $categoryId,
                'image' => 'images/Sauber-C12.webp',
                'description' => 'El primer Fórmula 1 de Sauber: el C12 de 1993, pilotado por Karl Wendlinger. Un monoplaza elegante propulsado por motor Ilmor con el que el equipo suizo debutó en la máxima categoría.',
                'scale_value' => '1:43',
            ],
            [
                'name' => 'Jaguar R5 - Mark Webber',
                'price' => 119.99,
                'team_name' => 'Jaguar', // Añadiendo Jaguar
                'year' => 2004,
                'category_id' => $categoryId,
                'image' => 'images/Jaguar-R5.webp',
                'description' => 'El Jaguar R5 de la temporada 2004, conducido por Mark Webber. El último coche de la histórica marca británica antes de su transformación en Red Bull Racing.',
                'scale_value' => '1:43',
            ],
            [
                'name' => 'Caterham CT05 - Kamui Kobayashi',
                'price' => 99.99,
                'team_name' => 'Caterham', // Añadiendo Caterham
                'year' => 2014,
                'category_id' => $categoryId,
                'image' => 'images/CaterhamCT05.webp',
                'description' => 'El Caterham CT05 de la temporada 2014, pilotado por Kamui Kobayashi. Uno de los últimos diseños del equipo malasio antes de su desaparición de la Fórmula 1.',
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