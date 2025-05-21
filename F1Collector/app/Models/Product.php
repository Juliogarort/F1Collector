<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Team;
use App\Models\Scale;

class Product extends Model
{
    // Definir la tabla si no sigue la convención de Laravel
    protected $table = 'f1collector_products';

    protected $fillable = [
        'name',
        'price',
        'team_id', // Cambiado de 'team' a 'team_id'
        'year',
        'category_id',
        'image',
        'description',
        'scale_id', // Cambiado de 'type' a 'scale_id'
    ];

    // Definir la relación con la categoría
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Relación con Team
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id')->withDefault([
            'name' => 'Sin escudería',
        ]);
    }

    // Relación con Scale
    public function scale()
    {
        return $this->belongsTo(Scale::class, 'scale_id')->withDefault([
            'value' => 'Sin escala',
        ]);
    }

    public function valoraciones()
    {
        return $this->hasMany(Valoracion::class);
    }

    public function getValoracionMediaAttribute()
    {
        return $this->valoraciones()->where('aprobada', true)->avg('puntuacion') ?: 0;
    }

    public function getNumeroValoracionesAttribute()
    {
        return $this->valoraciones()->where('aprobada', true)->count();
    }
        public function getDistribucionValoracionesAttribute()
    {
        $distribucion = [];
        for ($i = 5; $i >= 1; $i--) {
            $distribucion[$i] = $this->valoraciones()
                ->where('aprobada', true)
                ->where('puntuacion', $i)
                ->count();
        }
        return $distribucion;
    }
}
