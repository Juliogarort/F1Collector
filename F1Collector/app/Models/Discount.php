<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Discount extends Model
{
    protected $table = 'f1collector_discounts';

    protected $fillable = [
        'code',
        'type',
        'discount_amount',
        'discount_percentage',
        'category_id',
        'product_id',
        'usage_limit',
        'used',
        'expires_at'
    ];

    // ✅ ESTO ES LO IMPORTANTE: Añadir los casts para fechas
    protected $casts = [
        'expires_at' => 'datetime',
        'discount_amount' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
    ];

    /**
     * Relación con categoría
     */
    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }

    /**
     * Relación con producto
     */
    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class);
    }

    /**
     * Verificar si el descuento está activo
     */
    public function isValid()
    {
        // Verificar límite de uso
        $usageValid = ($this->usage_limit === null || $this->used < $this->usage_limit);

        // Verificar fecha de expiración (ahora funciona correctamente)
        $dateValid = ($this->expires_at === null || $this->expires_at->isFuture());

        return $usageValid && $dateValid;
    }

    /**
     * Aplicar descuento al total (tu método existente)
     */
    public function apply($total)
    {
        if (!$this->isValid()) return $total;

        if ($this->discount_amount) {
            return max(0, $total - $this->discount_amount);
        }

        if ($this->discount_percentage) {
            return $total - ($total * ($this->discount_percentage / 100));
        }

        return $total;
    }

    /**
     * Verificar si el descuento está activo (scope)
     */
    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')
                ->orWhere('expires_at', '>', now());
        })->where(function ($q) {
            $q->whereNull('usage_limit')
                ->orWhereRaw('used < usage_limit');
        });
    }

    /**
     * Calcular el descuento aplicable a un carrito
     */
    public function calculateDiscount($cartItems)
    {
        if (!$this->isValid()) {
            return 0;
        }

        $eligibleTotal = 0;

        switch ($this->type) {
            case 'simple':
                // Descuento simple: se aplica al total del carrito
                $eligibleTotal = $cartItems->sum(function ($item) {
                    return $item->quantity * $item->product->price;
                });
                break;

            case 'category':
                // Descuento por categoría: solo productos de esa categoría
                $eligibleTotal = $cartItems->where('product.category_id', $this->category_id)
                    ->sum(function ($item) {
                        return $item->quantity * $item->product->price;
                    });
                break;

            case 'product':
                // Descuento por producto específico
                $eligibleTotal = $cartItems->where('product_id', $this->product_id)
                    ->sum(function ($item) {
                        return $item->quantity * $item->product->price;
                    });
                break;
        }

        // Calcular el descuento
        if ($this->discount_percentage) {
            return $eligibleTotal * ($this->discount_percentage / 100);
        }

        if ($this->discount_amount) {
            return min($this->discount_amount, $eligibleTotal);
        }

        return 0;
    }

    /**
     * Marcar el descuento como usado
     */
    public function markAsUsed()
    {
        $this->increment('used');
    }

    public static function getAvailableCoupons($limit = 3)
    {
        return self::where('expires_at', '>', now())
            ->orWhereNull('expires_at')
            ->where(function ($query) {
                $query->whereNull('usage_limit')
                    ->orWhereRaw('used < usage_limit');
            })
            ->orderBy('discount_percentage', 'desc')
            ->orderBy('discount_amount', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Obtener cupones especiales (para usuarios nuevos, etc.)
     */
    public static function getWelcomeCoupons()
    {
        return self::whereIn('code', ['WELCOME10', 'STUDENT5', 'FREESHIP'])
            ->where(function ($query) {
                $query->where('expires_at', '>', now())
                    ->orWhereNull('expires_at');
            })
            ->get();
    }

    /**
     * Obtener el mejor cupón disponible
     */
    public static function getBestAvailableCoupon()
    {
        return self::where('expires_at', '>', now())
            ->orWhereNull('expires_at')
            ->where(function ($query) {
                $query->whereNull('usage_limit')
                    ->orWhereRaw('used < usage_limit');
            })
            ->orderByRaw('CASE 
            WHEN discount_percentage IS NOT NULL THEN discount_percentage 
            WHEN discount_amount IS NOT NULL THEN discount_amount * 10 
            ELSE 0 
        END DESC')
            ->first();
    }
}
