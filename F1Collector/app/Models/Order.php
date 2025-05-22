<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'f1collector_orders';

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'total',
        'subtotal',
        'discount_amount',
        'discount_code',
        'shipping_address',
        'shipping_city',
        'shipping_province',
        'shipping_zip',
        'shipping_phone',
        'full_name',
        'payment_method',
        'status',
        'payment_id',
        'payment_date'
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        'total' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'payment_date' => 'datetime',
    ];

    /**
     * Obtener el usuario asociado con este pedido.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Obtener los items asociados con este pedido.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    /**
     * Verificar si el pedido tiene descuento aplicado
     */
    public function hasDiscount(): bool
    {
        return $this->discount_amount > 0;
    }

    /**
     * Obtener el porcentaje de descuento aplicado
     */
    public function getDiscountPercentageAttribute(): float
    {
        if (!$this->hasDiscount() || !$this->subtotal) {
            return 0;
        }
        
        return round(($this->discount_amount / $this->subtotal) * 100, 2);
    }

    /**
     * Scope para pedidos con descuento
     */
    public function scopeWithDiscount($query)
    {
        return $query->where('discount_amount', '>', 0);
    }
}