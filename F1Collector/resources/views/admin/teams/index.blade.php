@extends('layouts.app')

@section('title', 'Escuderías')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-primary">Gestión de Escuderías</h1>
        <a href="{{ route('admin.teams.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i> Añadir Escudería
        </a>
    </div>

    @if ($teams->isEmpty())
        <div class="alert alert-info text-center">No hay escuderías registradas.</div>
    @else
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($teams as $team)
                    <tr>
                        <td>{{ $team->id }}</td>
                        <td>{{ $team->name }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.teams.edit', $team) }}" class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                            <form action="{{ route('admin.teams.destroy', $team) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta escudería?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
