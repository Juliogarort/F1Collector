@extends('layouts.app')

@section('title', 'Productos para valorar')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12 mb-4">
            <h1 class="h3 fw-bold text-danger">Productos pendientes de valorar</h1>
            <p class="text-muted">Tu opinión es importante para nosotros y ayuda a otros compradores.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if($productosParaValorar->count() > 0)
    <div class="row g-4">
        @foreach($productosParaValorar as $product)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm product-card transition-hover">
                <div class="position-relative overflow-hidden" style="height: 200px;">
                    <img src="{{ asset($product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 100%; object-fit: cover;">
                </div>
                <div class="card-body d-flex flex-column p-4">
                    <p class="text-uppercase text-muted small mb-1">{{ $product->team ? $product->team->name : 'Sin escudería' }}</p>
                    <h3 class="card-title h5 mb-2">{{ $product->name }}</h3>
                    <div class="mb-2">
                        <span class="text-muted small">Escala: {{ $product->scale ? $product->scale->value : 'Sin escala' }}</span>
                    </div>
                    <div class="mt-auto text-center">
                        <a href="{{ route('valoraciones.create', $product) }}" class="btn btn-warning btn-sm rounded-pill py-2 px-4">
                            <i class="fas fa-star me-1"></i> Valorar este producto
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-5">
        <div class="mb-4">
            <i class="fas fa-check-circle text-success fa-5x"></i>
        </div>
        <h3 class="h4 mb-3">¡No tienes productos pendientes de valorar!</h3>
        <p class="text-muted mb-4">Ya has valorado todos tus productos o todavía no has realizado ninguna compra.</p>
        <a href="{{ route('catalogo') }}" class="btn btn-danger">Explorar catálogo</a>
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
</style>
@endpush