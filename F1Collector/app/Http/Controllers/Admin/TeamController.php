<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team;
use Illuminate\Database\QueryException;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::all();
        return view('admin.teams.index', compact('teams'));
    }

    public function create()
    {
        return view('admin.teams.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:f1collector_teams,name',
        ]);

        Team::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.teams.index')->with('success', 'Escudería creada correctamente.');
    }

    public function edit(Team $team)
    {
        return view('admin.teams.edit', compact('team'));
    }

    public function update(Request $request, Team $team)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:f1collector_teams,name,' . $team->id,
        ]);

        $team->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.teams.index')->with('success', 'Escudería actualizada correctamente.');
    }

    public function destroy(Team $team)
    {
        try {
            $team->delete();
            return redirect()->route('admin.teams.index')
                ->with('success', 'Escudería eliminada correctamente.');
        } catch (QueryException $e) {
            // Si es por restricción de clave foránea
            if ($e->getCode() === '23000') {
                return redirect()->route('admin.teams.index')
                    ->with('error', '❌ No se puede eliminar la escudería porque está asociada a uno o más productos. Edita esos productos primero.');
            }

            // Otros errores
            return redirect()->route('admin.teams.index')
                ->with('error', '❌ Error inesperado al eliminar la escudería.');
        }
    }
}
