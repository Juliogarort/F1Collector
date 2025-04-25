<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'f1collector_teams';

    protected $fillable = ['name'];

    public function products()
    {
        return $this->hasMany(Product::class, 'team_id');
    }
}
