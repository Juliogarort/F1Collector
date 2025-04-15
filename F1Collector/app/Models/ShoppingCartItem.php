<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShoppingCartItem extends Model
{
    use HasFactory;

    protected $table = 'f1collector_shopping_cart_items';
    
    protected $fillable = [
        'shopping_cart_id',
        'product_id',
        'quantity'
    ];

    /**
     * Obtiene el carrito al que pertenece este item.
     */
    public function shoppingCart(): BelongsTo
    {
        return $this->belongsTo(ShoppingCart::class, 'shopping_cart_id');
    }

    /**
     * Obtiene el producto asociado a este item del carrito.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Calcula el subtotal del item (precio * cantidad).
     */
    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->product->price;
    }
}