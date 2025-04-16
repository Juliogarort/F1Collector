@extends('layouts.app')

@section('title', 'Crear Producto')

@section('content')
<div class="container py-5">
    <h1 class="h3 fw-bold text-danger mb-4">Nuevo Producto</h1>

    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Precio (€)</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" required value="{{ old('price') }}">
        </div>

        <div class="mb-3">
            <label for="team" class="form-label">Escudería</label>
            <input type="text" class="form-control" id="team" name="team" required value="{{ old('team') }}">
        </div>

        <div class="mb-3">
            <label for="year" class="form-label">Año</label>
            <input type="number" class="form-control" id="year" name="year" required value="{{ old('year') }}">
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Categoría</label>
            <select class="form-select" id="category_id" name="category_id" required>
                <option value="">Selecciona una categoría</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Tipo</label>
            <input type="text" class="form-control" id="type" name="type" required value="{{ old('type') }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Imagen</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-circle"></i> Guardar
        </button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
