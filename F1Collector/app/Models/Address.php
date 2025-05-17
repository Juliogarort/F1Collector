<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'f1collector_addresses';

    protected $fillable = [
        'street',  // Cambio de 'address' a 'street'
        'city',
        'state',   // Añadido campo 'state'
        'postal_code',
        'country'
    ];

    // Relación con Usuario
    public function user()
    {
        return $this->hasOne(User::class, 'address_id');
    }
}