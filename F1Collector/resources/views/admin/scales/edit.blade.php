@extends('layouts.app')

@section('title', 'Editar Escala')

@section('content')
<div class="container py-5">
    <h1 class="h3 text-danger mb-4">Editar Escala</h1>

    <form method="POST" action="{{ route('admin.scales.update', $scale) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="value" class="form-label">Valor de escala</label>
            <input type="text" class="form-control" id="value" name="value" required value="{{ old('value', $scale->value) }}">
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-circle me-1"></i> Guardar Cambios
        </button>
        <a href="{{ route('admin.scales.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
