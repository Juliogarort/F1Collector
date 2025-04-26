<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scale extends Model
{
    protected $table = 'f1collector_scales';

    protected $fillable = ['value'];

    public function products()
    {
        return $this->hasMany(Product::class, 'scale_id');
    }
}
