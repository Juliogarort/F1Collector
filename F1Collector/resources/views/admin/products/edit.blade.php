@extends('layouts.app')

@section('title', 'Editar Producto')

@section('content')
<div class="container py-5">
    <h1 class="h3 fw-bold text-danger mb-4">Editar Producto</h1>

    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name', $product->name) }}">
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Precio (€)</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" required value="{{ old('price', $product->price) }}">
        </div>

        <div class="mb-3">
            <label for="team_id" class="form-label">Escudería</label>
            <select class="form-select" id="team_id" name="team_id" required>
                <option value="">Selecciona una escudería</option>
                @foreach($teams as $team)
                    <option value="{{ $team->id }}" {{ old('team_id', $product->team_id) == $team->id ? 'selected' : '' }}>
                        {{ $team->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="year" class="form-label">Año</label>
            <input type="number" class="form-control" id="year" name="year" required value="{{ old('year', $product->year) }}">
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Categoría</label>
            <select class="form-select" id="category_id" name="category_id" required>
                <option value="">Selecciona una categoría</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="scale_id" class="form-label">Escala</label>
            <select class="form-select" id="scale_id" name="scale_id" required>
                <option value="">Selecciona una escala</option>
                @foreach($scales as $scale)
                    <option value="{{ $scale->id }}" {{ old('scale_id', $product->scale_id) == $scale->id ? 'selected' : '' }}>
                        {{ $scale->value }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Imagen</label>
            <!-- Mostrar vista previa si ya hay imagen -->
            @if($product->image)
                <div class="mb-2">
                    <img src="{{ asset($product->image) }}" alt="Imagen actual" style="max-height: 120px;">
                </div>
            @endif
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
            <!-- Campo oculto para mantener la imagen anterior si no subes nada -->
            <input type="hidden" name="old_image" value="{{ $product->image }}">
            <div class="form-text">Deja vacío para mantener la imagen actual.</div>
        </div>
        
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-circle"></i> Guardar Cambios
        </button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
