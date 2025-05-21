<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'f1collector_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'avatar',
        'phone',
        'user_type',
        'address_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    use HasRoles;

    public function wishlist()
    {
        return $this->hasOne(Wishlist::class);
    }

    public function shoppingCart()
    {
        return $this->hasOne(ShoppingCart::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }


    public function valoraciones()
    {
        return $this->hasMany(Valoracion::class);
    }

    public function haValorado(Product $product)
    {
        return $this->valoraciones()->where('product_id', $product->id)->exists();
    }
}
