<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Scale;

class ScaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lista de escalas comunes para modelos de F1
        $scales = [
            '1:18',
            '1:24',
            '1:43',
            '1:64',
            '1:8'
        ];

        // Crear cada escala si no existe
        foreach ($scales as $scaleValue) {
            Scale::firstOrCreate(['value' => $scaleValue]);
        }
    }
}