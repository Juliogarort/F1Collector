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
}