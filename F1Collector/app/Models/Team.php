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
        $productsUsingTeam = Product::where('team_id', $team->id)->count();

        // Eliminar escudería igualmente
        $team->delete();

        return redirect()->route('admin.teams.index')->with('success', 
            'Escudería eliminada correctamente. ' .
            ($productsUsingTeam > 0 
                ? "⚠️ Recuerda que $productsUsingTeam producto(s) tenían esta escudería. Ahora están sin asignar. Edita los productos para asignarles una nueva escudería." 
                : "")
        );
    }

}