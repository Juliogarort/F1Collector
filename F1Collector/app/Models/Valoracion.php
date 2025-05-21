<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Valoracion extends Model
{
    use HasFactory;

    protected $table = 'f1collector_valoraciones';

    protected $fillable = [
        'user_id',
        'product_id',
        'order_id',
        'puntuacion',
        'comentario',
        'compra_verificada',
        'aprobada'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    
    public function getUsuarioAttribute()
    {
        return $this->user ? $this->user->name : 'Usuario anónimo';
    }
    
    public function getFechaAttribute()
    {
        return Carbon::parse($this->created_at)->format('d/m/Y');
    }
}