<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuarios principales (administradores y unos pocos clientes fijos) con avatares
        // Adaptado para la tabla f1collector_users
        $mainUsers = [
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin1234'),
                'user_type' => 'Admin',
                'avatar' => 'avatars/admin.webp', // Avatar específico para admin
                'created_at' => Carbon::now()->subMonths(12),
                'updated_at' => Carbon::now()->subMonths(12),
            ],
            [
                'name' => 'Cliente Normal',
                'email' => 'cliente@example.com',
                'password' => Hash::make('cliente1234'),
                'user_type' => 'Customer',
                'avatar' => 'avatars/nano.jpeg', // Avatar específico para este cliente
                'created_at' => Carbon::now()->subMonths(11),
                'updated_at' => Carbon::now()->subMonths(11),
            ],
            [
                'name' => 'Julio',
                'email' => 'julio@example.com',
                'password' => Hash::make('julio1234'),
                'user_type' => 'Admin',
                'avatar' => 'avatars/julio.jpg', // Avatar específico para Julio
                'created_at' => Carbon::now()->subMonths(9),
                'updated_at' => Carbon::now()->subMonths(9),
            ],
            [
                'name' => 'Alberto',
                'email' => 'alberto@example.com',
                'password' => Hash::make('alberto1234'),
                'user_type' => 'Admin',
                'avatar' => 'avatars/alberto.png', // Avatar específico para Alberto
                'created_at' => Carbon::now()->subMonths(8),
                'updated_at' => Carbon::now()->subMonths(8),
            ],
            [
                'name' => 'Paco',
                'email' => 'paco@example.com',
                'password' => Hash::make('paco1234'),
                'user_type' => 'Customer',
                'avatar' => 'avatars/paco.jpeg', // Avatar específico para Paco
                'created_at' => Carbon::now()->subMonths(10),
                'updated_at' => Carbon::now()->subMonths(10),
            ]
        ];

        User::insert($mainUsers);

        // Generar usuarios adicionales con distribución temporal para mostrar crecimiento en gráficos
        // (sin avatares personalizados)
        $firstNames = [
            'Carlos',
            'Ana',
            'Juan',
            'María',
            'José',
            'Laura',
            'Manuel',
            'Carmen',
            'David',
            'Lucía',
            'Javier',
            'Isabel',
            'Miguel',
            'Sara',
            'Fernando',
            'Elena',
            'Pedro',
            'Sofia',
            'Antonio',
            'Paula',
            'Francisco',
            'Marta',
            'Luis',
            'Claudia',
            'Alejandro',
            'Raquel',
            'Alberto'
        ];

        $lastNames = [
            'García',
            'Rodríguez',
            'López',
            'Martínez',
            'González',
            'Pérez',
            'Sánchez',
            'Fernández',
            'Gómez',
            'Martín',
            'Jiménez',
            'Ruiz',
            'Hernández',
            'Díaz',
            'Moreno',
            'Álvarez',
            'Romero',
            'Alonso',
            'Gutiérrez',
            'Navarro',
            'Torres',
            'Domínguez',
            'Vázquez',
            'Ramos',
            'Gil',
            'Ramírez'
        ];

        // Distribuir 30 usuarios más en los últimos 6 meses
        $additionalUsers = [];
        $startDate = Carbon::now()->subMonths(6);
        $endDate = Carbon::now();

        // Crear más usuarios en meses recientes que en los antiguos (tendencia creciente)
        $monthlyDistribution = [
            5 => 2,  // 2 usuarios hace 6 meses
            4 => 3,  // 3 usuarios hace 5 meses
            3 => 5,  // 5 usuarios hace 4 meses
            2 => 6,  // 6 usuarios hace 3 meses
            1 => 7,  // 7 usuarios hace 2 meses
            0 => 7   // 7 usuarios en el último mes
        ];

        $userCounter = 0;

        foreach ($monthlyDistribution as $monthsAgo => $count) {
            $monthStart = Carbon::now()->subMonths($monthsAgo)->startOfMonth();
            $monthEnd = Carbon::now()->subMonths($monthsAgo)->endOfMonth();

            for ($i = 0; $i < $count; $i++) {
                $userCounter++;
                $randomDate = Carbon::createFromTimestamp(
                    rand($monthStart->timestamp, $monthEnd->timestamp)
                );

                $firstName = $firstNames[array_rand($firstNames)];
                $lastName = $lastNames[array_rand($lastNames)];

                $additionalUsers[] = [
                    'name' => $firstName . ' ' . $lastName,
                    'email' => strtolower($firstName) . $userCounter . '@example.com',
                    'password' => Hash::make('password123'),
                    'user_type' => 'Customer',
                    'avatar' => null, // Sin avatar personalizado para usuarios adicionales
                    'created_at' => $randomDate,
                    'updated_at' => $randomDate,
                ];
            }
        }

        // Insertar usuarios adicionales
        foreach (array_chunk($additionalUsers, 10) as $chunk) {
            User::insert($chunk);
        }
    }
}
