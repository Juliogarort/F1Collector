@extends('layouts.app')

@section('title', 'Añadir Escudería')

@section('content')
<div class="container py-5">
    <h1 class="h3 text-danger mb-4">Añadir Escudería</h1>

    <form method="POST" action="{{ route('admin.teams.store') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}">
        </div>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i> Guardar
        </button>
        <a href="{{ route('admin.teams.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
