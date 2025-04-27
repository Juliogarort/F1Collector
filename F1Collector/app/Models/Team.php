<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product; // Importar explícitamente la clase Product

class Team extends Model
{
    protected $table = 'f1collector_teams';

    protected $fillable = ['name'];

    public function products()
    {
        return $this->hasMany(Product::class, 'team_id');
    }

    public function deleteTeam(Team $team)
    {
        // Verificar si el equipo está siendo utilizado por algún producto
        $productsUsingTeam = Product::where('team_id', $team->id)->count();
        
        if ($productsUsingTeam > 0) {
            return redirect()->route('admin.teams.index')
                ->with('error', 'No se puede eliminar el equipo "' . $team->name . '" porque está siendo utilizado por ' . $productsUsingTeam . ' producto(s).');
        }

        // Si no hay productos asociados, eliminar el equipo
        $team->delete();
        
        return redirect()->route('admin.teams.index')
            ->with('success', 'Equipo eliminado correctamente.');
    }
}