<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Address;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Datos para generar direcciones aleatorias de Sevilla, España
        $sevillaStreets = [
            'Calle Sierpes',
            'Avenida de la Constitución',
            'Calle Tetuán',
            'Plaza de Armas',
            'Calle Cuna',
            'Avenida de Andalucía',
            'Calle Amor de Dios',
            'Plaza Nueva',
            'Calle San Fernando',
            'Avenida de la Palmera',
            'Calle Asunción',
            'Plaza del Duque',
            'Calle O\'Donnell',
            'Avenida de Eduardo Dato',
            'Calle Regina',
            'Plaza de la Encarnación',
            'Calle Francos',
            'Avenida de la República Argentina',
            'Calle Velázquez',
            'Plaza de San Lorenzo'
        ];

        // Códigos postales reales de Sevilla (41001-41020)
        $sevillaPostalCodes = [
            '41001', '41002', '41003', '41004', '41005',
            '41006', '41007', '41008', '41009', '41010',
            '41011', '41012', '41013', '41014', '41015',
            '41016', '41017', '41018', '41019', '41020'
        ];

        // Función para crear una dirección aleatoria de Sevilla
        $createSevillaAddress = function() use ($sevillaStreets, $sevillaPostalCodes) {
            $address = Address::create([
                'street' => $sevillaStreets[array_rand($sevillaStreets)] . ' ' . rand(1, 150),
                'city' => 'Sevilla',
                'state' => 'Andalucía',
                'postal_code' => $sevillaPostalCodes[array_rand($sevillaPostalCodes)],
                'country' => 'España'
            ]);
            return $address->id;
        };

        // Usuarios principales SIN direcciones
        $mainUsers = [
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin1234'),
                'user_type' => 'Admin',
                'avatar' => 'avatars/admin.webp',
                'address_id' => null, // Sin dirección
                'phone' => '600' . str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT),
                'created_at' => Carbon::now()->subMonths(12),
                'updated_at' => Carbon::now()->subMonths(12),
            ],
            [
                'name' => 'Cliente Normal',
                'email' => 'cliente@example.com',
                'password' => Hash::make('cliente1234'),
                'user_type' => 'Customer',
                'avatar' => 'avatars/nano.jpeg',
                'address_id' => null, // Sin dirección
                'phone' => '600' . str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT),
                'created_at' => Carbon::now()->subMonths(11),
                'updated_at' => Carbon::now()->subMonths(11),
            ],
            [
                'name' => 'Julio',
                'email' => 'julio@example.com',
                'password' => Hash::make('julio1234'),
                'user_type' => 'Admin',
                'avatar' => 'avatars/julio.jpg',
                'address_id' => null, // Sin dirección
                'phone' => '600' . str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT),
                'created_at' => Carbon::now()->subMonths(9),
                'updated_at' => Carbon::now()->subMonths(9),
            ],
            [
                'name' => 'Alberto',
                'email' => 'alberto@example.com',
                'password' => Hash::make('alberto1234'),
                'user_type' => 'Admin',
                'avatar' => 'avatars/alberto.png',
                'address_id' => null, // Sin dirección
                'phone' => '600' . str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT),
                'created_at' => Carbon::now()->subMonths(8),
                'updated_at' => Carbon::now()->subMonths(8),
            ],
            [
                'name' => 'Paco',
                'email' => 'paco@example.com',
                'password' => Hash::make('paco1234'),
                'user_type' => 'Customer',
                'avatar' => 'avatars/paco.jpeg',
                'address_id' => null, // Sin dirección
                'phone' => '600' . str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT),
                'created_at' => Carbon::now()->subMonths(10),
                'updated_at' => Carbon::now()->subMonths(10),
            ]
        ];

        User::insert($mainUsers);

        // Generar usuarios adicionales con distribución temporal
        $firstNames = [
            'Carlos', 'Ana', 'Juan', 'María', 'José', 'Laura', 'Manuel', 'Carmen',
            'David', 'Lucía', 'Javier', 'Isabel', 'Miguel', 'Sara', 'Fernando',
            'Elena', 'Pedro', 'Sofia', 'Antonio', 'Paula', 'Francisco', 'Marta',
            'Luis', 'Claudia', 'Alejandro', 'Raquel', 'Alberto'
        ];

        $lastNames = [
            'García', 'Rodríguez', 'López', 'Martínez', 'González', 'Pérez',
            'Sánchez', 'Fernández', 'Gómez', 'Martín', 'Jiménez', 'Ruiz',
            'Hernández', 'Díaz', 'Moreno', 'Álvarez', 'Romero', 'Alonso',
            'Gutiérrez', 'Navarro', 'Torres', 'Domínguez', 'Vázquez', 'Ramos',
            'Gil', 'Ramírez'
        ];

        // Distribuir 30 usuarios más en los últimos 6 meses
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

                // Crear usuario con dirección de Sevilla
                User::create([
                    'name' => $firstName . ' ' . $lastName,
                    'email' => strtolower($firstName) . $userCounter . '@example.com',
                    'password' => Hash::make('password123'),
                    'user_type' => 'Customer',
                    'avatar' => 'avatars/user.webp',
                    'address_id' => $createSevillaAddress(),
                    'phone' => '6' . str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT),
                    'created_at' => $randomDate,
                    'updated_at' => $randomDate,
                ]);
            }
        }
    }
}