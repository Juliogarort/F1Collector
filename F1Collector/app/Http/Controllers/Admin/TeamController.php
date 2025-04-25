<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team;

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
        $team->delete();
        return redirect()->route('admin.teams.index')->with('success', 'Escudería eliminada correctamente.');
    }
}
