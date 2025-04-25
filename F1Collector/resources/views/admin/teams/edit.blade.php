@extends('layouts.app')

@section('title', 'Editar Escudería')

@section('content')
<div class="container py-5">
    <h1 class="h3 text-danger mb-4">Editar Escudería</h1>

    <form method="POST" action="{{ route('admin.teams.update', $team) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name', $team->name) }}">
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-circle me-1"></i> Guardar Cambios
        </button>
        <a href="{{ route('admin.teams.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
