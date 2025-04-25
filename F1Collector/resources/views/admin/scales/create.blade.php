@extends('layouts.app')

@section('title', 'Añadir Escala')

@section('content')
<div class="container py-5">
    <h1 class="h3 text-danger mb-4">Añadir Escala</h1>

    <form method="POST" action="{{ route('admin.scales.store') }}">
        @csrf

        <div class="mb-3">
            <label for="value" class="form-label">Valor de escala (ej: 1:18)</label>
            <input type="text" class="form-control" id="value" name="value" required value="{{ old('value') }}">
        </div>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i> Guardar
        </button>
        <a href="{{ route('admin.scales.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
