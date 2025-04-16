@extends('layouts.app')

@section('title', 'Editar Producto')

@section('content')
<div class="container py-5">
    <h1 class="h3 fw-bold text-danger mb-4">Editar Producto</h1>

    <form method="POST" action="{{ route('admin.products.update', $product) }}">
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

        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-circle"></i> Guardar cambios
        </button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
