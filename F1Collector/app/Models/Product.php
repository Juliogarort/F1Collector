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
        return $this->belongsTo(Team::class, 'team_id');
    }

    // Relación con Scale
    public function scale()
    {
        return $this->belongsTo(Scale::class, 'scale_id');
    }
}