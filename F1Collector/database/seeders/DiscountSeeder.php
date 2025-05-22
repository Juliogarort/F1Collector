<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Discount;
use Carbon\Carbon;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear algunos descuentos de ejemplo
        $discounts = [
            [
                'code' => 'WELCOME10',
                'type' => 'simple',
                'discount_percentage' => 10.00,
                'usage_limit' => 100,
                'expires_at' => Carbon::now()->addMonths(3),
            ],
            [
                'code' => 'FERRARI20',
                'type' => 'category',
                'discount_percentage' => 20.00,
                'category_id' => 1, // Asegúrate de que existe una categoría con ID 1
                'usage_limit' => 50,
                'expires_at' => Carbon::now()->addMonths(2),
            ],
            [
                'code' => 'SAVE50',
                'type' => 'simple',
                'discount_amount' => 50.00,
                'usage_limit' => 25,
                'expires_at' => Carbon::now()->addMonth(),
            ],
            [
                'code' => 'NEWYEAR2025',
                'type' => 'simple',
                'discount_percentage' => 15.00,
                'usage_limit' => 200,
                'expires_at' => Carbon::create(2025, 12, 31),
            ],
            [
                'code' => 'FREESHIP',
                'type' => 'simple',
                'discount_amount' => 10.00, // Descuento fijo
                'usage_limit' => null, // Sin límite
                'expires_at' => null, // Sin expiración
            ],
            [
                'code' => 'STUDENT5',
                'type' => 'simple',
                'discount_percentage' => 5.00,
                'usage_limit' => null,
                'expires_at' => Carbon::now()->addYear(),
            ]
        ];

        foreach ($discounts as $discountData) {
            Discount::firstOrCreate(
                ['code' => $discountData['code']],
                $discountData
            );
        }

        $this->command->info('Descuentos de ejemplo creados exitosamente.');
    }
}