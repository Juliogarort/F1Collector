<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wishlist extends Model
{
    use HasFactory;

    protected $table = 'f1collector_wishlists';

    protected $fillable = ['user_id'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'f1collector_wishlist_products');
    }
}
