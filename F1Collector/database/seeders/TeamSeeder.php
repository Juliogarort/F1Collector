<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lista de equipos de F1 para el catálogo
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

        // Crear cada equipo si no existe
        foreach ($teams as $teamName) {
            Team::firstOrCreate(['name' => $teamName]);
        }
    }
}