<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Scale;

class ScaleController extends Controller
{
    public function index()
    {
        $scales = Scale::all();
        return view('admin.scales.index', compact('scales'));
    }

    public function create()
    {
        return view('admin.scales.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'value' => 'required|string|max:255|unique:f1collector_scales,value',
        ]);

        Scale::create([
            'value' => $request->value,
        ]);

        return redirect()->route('admin.scales.index')->with('success', 'Escala creada correctamente.');
    }

    public function edit(Scale $scale)
    {
        return view('admin.scales.edit', compact('scale'));
    }

    public function update(Request $request, Scale $scale)
    {
        $request->validate([
            'value' => 'required|string|max:255|unique:f1collector_scales,value,' . $scale->id,
        ]);

        $scale->update([
            'value' => $request->value,
        ]);

        return redirect()->route('admin.scales.index')->with('success', 'Escala actualizada correctamente.');
    }

    public function destroy(Scale $scale)
    {
        $scale->delete();
        return redirect()->route('admin.scales.index')->with('success', 'Escala eliminada correctamente.');
    }
}
