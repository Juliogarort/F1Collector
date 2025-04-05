<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Product extends Model
{
    // Definir la tabla si no sigue la convención de Laravel
    protected $table = 'f1collector_products';

    // Definir la relación con la categoría
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
