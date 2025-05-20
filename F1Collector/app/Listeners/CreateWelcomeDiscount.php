<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use App\Models\Discount;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class CreateWelcomeDiscount
{
    public function handle(Registered $event)
    {
        $code = strtoupper(Str::random(10));

        Discount::create([
            'code' => $code,
            'type' => 'simple',
            'discount_percentage' => 20,
            'usage_limit' => 1,
            'used' => 0,
            'expires_at' => now()->addDays(30),
        ]);

        // Guardar el código en la sesión para mostrarlo después
        Session::put('welcome_discount_code', $code);
    }
}
