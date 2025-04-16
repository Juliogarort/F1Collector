@extends('layouts.app')

@section('title', 'Listado de Productos')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-danger">Listado de Productos</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle me-2"></i> Añadir producto
        </a>
    </div>

    @if($products->isEmpty())
        <div class="alert alert-warning text-center">No hay productos disponibles.</div>
    @else
        <div class="row g-4">
            @foreach($products as $product)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm product-card transition-hover">
                    <div class="position-relative overflow-hidden product-img-container">
                        <img src="{{ asset($product->image) }}" class="card-img-top product-img" alt="{{ $product->name }}">
                    </div>
                    <div class="card-body d-flex flex-column p-4">
                        <p class="text-uppercase text-muted small mb-1">{{ $product->team }}</p>
                        <h3 class="card-title h5 mb-2 product-title">{{ $product->name }}</h3>
                        <div class="mb-2">
                            <span class="text-muted small">Escala: 1:18</span>
                        </div>
                        <p class="card-text text-muted small mb-3 flex-grow-1">{{ $product->description }}</p>
                        <div class="mt-auto d-flex justify-content-between">
                            <span class="h5 fw-bold text-danger mb-0">€{{ number_format($product->price, 2) }}</span>
                            <div>
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary me-1">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este producto?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .product-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
    }
    .product-img-container {
        height: 200px;
        overflow: hidden;
    }
    .product-img {
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .product-card:hover .product-img {
        transform: scale(1.05);
    }
    .product-title {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
@endpush
