@extends('layouts.app')

@section('title', 'Mi Lista de Deseos')

@section('content')
<div class="container py-5">
    <h1 class="h3 fw-bold text-danger mb-4">
        <i class="bi bi-heart-fill me-2"></i>Mi Lista de Deseos
    </h1>

    @if($wishlist && $wishlist->products->count())
        <div class="row g-4">
            @foreach($wishlist->products as $product)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm product-card transition-hover">
                        <div class="product-img-container">
                            <img src="{{ asset($product->image) }}" class="card-img-top product-img" alt="{{ $product->name }}">
                        </div>
                        <div class="card-body d-flex flex-column p-4">
                            <p class="text-uppercase text-muted small mb-1">{{ $product->team->name ?? 'Sin escudería' }}</p>
                            <h3 class="card-title h5 mb-2 product-title">{{ $product->name }}</h3>
                            <div class="mb-2">
                                <span class="text-muted small">Escala: {{ $product->scale->value ?? 'Sin escala' }}</span>
                            </div>
                            <p class="card-text text-muted small mb-3 flex-grow-1">{{ $product->description }}</p>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <span class="h5 fw-bold text-danger mb-0">€{{ number_format($product->price, 2) }}</span>
                                <form method="POST" action="{{ route('wishlist.toggle', $product) }}">
                                    @csrf
                                    <button class="btn btn-outline-danger rounded-circle" title="Eliminar de favoritos">
                                        <i class="bi bi-heart-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info text-center">No tienes productos en tu lista de deseos.</div>
    @endif
</div>
@endsection
