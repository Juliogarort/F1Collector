@extends('layouts.app')

@section('title', 'Gestión de Productos | F1 Collector')

@section('content')
<div class="products-management">
    <div class="container py-5">
        <!-- Header con breadcrumb -->
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.menu') }}" class="text-decoration-none"><i class="bi bi-speedometer2"></i> Panel</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Productos</li>
                    </ol>
                </nav>
            </div>
        </div>
        
        <!-- Header principal -->
        <div class="row align-items-center mb-4">
            <div class="col-lg-6">
                <h1 class="h2 fw-bold mb-0 text-danger">
                    <i class="bi bi-box-seam-fill me-2"></i>Gestión de Productos
                </h1>
                <p class="text-muted mt-2 mb-0">Administración del catálogo completo de modelos de colección</p>
            </div>
            <div class="col-lg-6 mt-3 mt-lg-0 text-lg-end">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Añadir Producto
                </a>
                <a href="{{ route('admin.menu') }}" class="btn btn-outline-secondary ms-2">
                    <i class="bi bi-arrow-left me-1"></i> Volver al Panel
                </a>
            </div>
        </div>
        
        <!-- Alertas -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm border-start border-success border-4" role="alert">
                <div class="d-flex">
                    <div class="me-3">
                        <i class="bi bi-check-circle-fill fs-4"></i>
                    </div>
                    <div>
                        <h5 class="alert-heading mb-1">¡Operación exitosa!</h5>
                        <p class="mb-0">{{ session('success') }}</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm border-start border-danger border-4" role="alert">
                <div class="d-flex">
                    <div class="me-3">
                        <i class="bi bi-exclamation-triangle-fill fs-4"></i>
                    </div>
                    <div>
                        <h5 class="alert-heading mb-1">¡Ha ocurrido un error!</h5>
                        <p class="mb-0">{{ session('error') }}</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        <!-- Cards resumen -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3 mb-md-0">
                <div class="card border-0 bg-light h-100 shadow-sm rounded-3">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle bg-danger bg-opacity-10 p-3 me-3">
                            <i class="bi bi-box-seam-fill text-danger fs-4"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-0">{{ $products->count() }}</h5>
                            <p class="card-text text-muted mb-0">Productos en catálogo</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($products->isEmpty())
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-5 text-center">
                    <img src="{{ asset('images/empty-state.svg') }}" alt="No hay productos" class="img-fluid mb-3" style="max-width: 200px; opacity: 0.6;">
                    <h4 class="text-muted">No hay productos disponibles</h4>
                    <p class="text-muted mb-4">Comienza añadiendo tu primer producto al catálogo</p>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle me-1"></i> Añadir producto
                    </a>
                </div>
            </div>
        @else
            <div class="row g-4">
                @foreach($products as $product)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm product-card rounded-3 overflow-hidden">
                        <div class="position-relative">
                            <!-- Imagen del producto con overlay -->
                            <div class="product-img-container">
                                <img src="{{ asset($product->image) }}" class="card-img-top product-img" alt="{{ $product->name }}">
                                <!-- Etiqueta del año -->
                                <div class="position-absolute top-0 end-0 m-2">
                                    <span class="badge bg-primary rounded-pill">{{ $product->year }}</span>
                                </div>
                                <!-- Overlay con acciones (solo visible en móvil) -->
                                <div class="product-overlay d-md-none">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-light">
                                            <i class="bi bi-pencil"></i> Editar
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $product->id }}">
                                            <i class="bi bi-trash"></i> Eliminar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Contenido de la tarjeta -->
                        <div class="card-body d-flex flex-column p-4">
                            <!-- Badges de información -->
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-secondary mb-0">{{ $product->team->name ?? 'Sin escudería' }}</span>
                                <span class="badge bg-light text-dark">Escala: {{ $product->scale->value ?? '—' }}</span>
                            </div>
                            
                            <!-- Título y descripción -->
                            <h3 class="card-title h5 mb-2 product-title">{{ $product->name }}</h3>
                            <p class="card-text text-muted small mb-3 flex-grow-1 product-description">{{ $product->description }}</p>
                            
                            <!-- Precio y acciones (botones solo visibles en desktop) -->
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <span class="h5 fw-bold text-danger mb-0">€{{ number_format($product->price, 2) }}</span>
                                <div class="d-none d-md-flex">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Acciones
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.products.edit', $product) }}">
                                                    <i class="bi bi-pencil-fill text-primary me-2"></i>Editar
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $product->id }}">
                                                    <i class="bi bi-trash-fill me-2"></i>Eliminar
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal de confirmación de eliminación -->
                    <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $product->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $product->id }}">
                                        <i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmar Eliminación
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body">
                                    <p>¿Estás seguro de que deseas eliminar el producto <strong>{{ $product->name }}</strong>?</p>
                                    <div class="alert alert-warning mb-0">
                                        <div class="d-flex">
                                            <div class="me-3">
                                                <i class="bi bi-exclamation-triangle-fill fs-4"></i>
                                            </div>
                                            <div>
                                                <strong>¡Atención!</strong> Esta acción no se puede deshacer.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="bi bi-trash-fill me-1"></i> Sí, eliminar
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
</div>
@endsection

@push('styles')
<style>
    .product-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 12px;
        overflow: hidden;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1.5rem rgba(0, 0, 0, .15) !important;
    }
    
    .product-img-container {
        position: relative;
        width: 100%;
        aspect-ratio: 4/3; 
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
        overflow: hidden;
    }
    
    .product-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .product-overlay {
        position: absolute;
        bottom: -60px;
        left: 0;
        right: 0;
        background-color: rgba(0, 0, 0, 0.7);
        padding: 15px;
        transition: bottom 0.3s ease;
        display: flex;
        justify-content: center;
    }
    
    .product-card:hover .product-overlay {
        bottom: 0;
    }
    
    .product-card:hover .product-img {
        transform: scale(1.1);
    }
    
    .product-title {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-weight: 600;
    }
    
    .product-description {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 60px;
    }
    
    .icon-circle {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }
    
    /* Mejorar estilo del dropdown */
    .dropdown-toggle::after {
        display: none;
    }
    
    .dropdown-toggle {
        padding: 0.375rem 0.75rem;
    }
    
    .dropdown-menu {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        border: none;
        border-radius: 0.5rem;
    }
    
    .dropdown-item {
        padding: 0.5rem 1rem;
    }
    
    .dropdown-item:hover {
        background-color: rgba(220, 53, 69, 0.1);
    }
    
    .dropdown-item.text-danger:hover {
        background-color: rgba(220, 53, 69, 0.15);
    }
</style>
@endpush