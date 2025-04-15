<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShoppingCart extends Model
{
    use HasFactory;

    protected $table = 'f1collector_shopping_carts';
    
    protected $fillable = [
        'user_id',
        'status'
    ];

    /**
     * Obtiene el usuario al que pertenece este carrito.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtiene los items del carrito.
     */
    public function items(): HasMany
    {
        return $this->hasMany(ShoppingCartItem::class, 'shopping_cart_id');
    }

    /**
     * Calcula el subtotal del carrito.
     */
    public function getSubtotalAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
    }

    /**
     * Calcula el IVA del carrito (21%).
     */
    public function getTaxAttribute()
    {
        return $this->subtotal * 0.21;
    }

    /**
     * Calcula el total del carrito (subtotal + IVA).
     */
    public function getTotalAttribute()
    {
        return $this->subtotal + $this->tax;
    }

    /**
     * Obtiene el número total de items en el carrito.
     */
    public function getTotalItemsAttribute()
    {
        return $this->items->sum('quantity');
    }
}