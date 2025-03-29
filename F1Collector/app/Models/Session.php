<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    // Especifica el nombre de la tabla en la base de datos
    protected $table = 'f1collector_sessions';

    // Si no usas los timestamps en esta tabla, puedes desactivarlos así:
    public $timestamps = false;
}
