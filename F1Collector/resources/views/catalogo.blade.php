@extends('layouts.app')

@section('title', 'F1 Collector - Catálogo de Modelos')

@section('content')
<div class="container-fluid p-0">
    {{-- Cabecera del Catálogo --}}
    <header class="bg-dark text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 text-center">
                    <h1 class="display-4 fw-bold text-danger mb-3">Catálogo de Modelos</h1>
                    <p class="lead text-light mb-0">Explora nuestra exclusiva colección de modelos a escala de F1</p>
                </div>
            </div>
        </div>
    </header>

    {{-- Sección de Filtros y Productos --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                {{-- Barra lateral de filtros --}}
                <div class="col-lg-3 mb-4 mb-lg-0">
                    <div class="card border-0 shadow-sm sticky-top" style="top: 20px; z-index: 1020;">
                        <div class="card-header bg-danger text-white py-3">
                            <h5 class="mb-0 fw-bold">Filtros</h5>
                        </div>
                        <div class="card-body p-4">
                            {{-- Filtro por Escudería --}}
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3 text-uppercase small">Escudería</h6>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" value="" id="ferrari">
                                    <label class="form-check-label" for="ferrari">Ferrari</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" value="" id="redbull">
                                    <label class="form-check-label" for="redbull">Red Bull</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" value="" id="mercedes">
                                    <label class="form-check-label" for="mercedes">Mercedes</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" value="" id="mclaren">
                                    <label class="form-check-label" for="mclaren">McLaren</label>
                                </div>
                            </div>

                            {{-- Filtro por Escala --}}
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3 text-uppercase small">Escala</h6>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" value="" id="escala118">
                                    <label class="form-check-label" for="escala118">1:18</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" value="" id="escala143">
                                    <label class="form-check-label" for="escala143">1:43</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" value="" id="escala112">
                                    <label class="form-check-label" for="escala112">1:12</label>
                                </div>
                            </div>

                            {{-- Filtro por Rango de Precio --}}
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3 text-uppercase small">Precio</h6>
                                <div class="d-flex align-items-center">
                                    <span class="me-2">€</span>
                                    <input type="range" class="form-range" min="50" max="500" id="rangoPrecio">
                                    <span class="ms-2 fw-bold" id="valorPrecio">275€</span>
                                </div>
                            </div>

                            {{-- Botón para aplicar filtros --}}
                            <button class="btn btn-danger w-100 fw-bold py-2 mt-2">Aplicar Filtros</button>
                        </div>
                    </div>
                </div>

                {{-- Cuadrícula de productos --}}
                <div class="col-lg-9">
                    {{-- Opciones de ordenamiento --}}
                    <div class="d-flex justify-content-between align-items-center bg-white p-3 mb-4 shadow-sm rounded">
                        <div>
                            <span class="text-muted">Mostrando {{ $products->count() }} productos</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <label for="ordenar" class="me-2 text-nowrap">Ordenar por:</label>
                            <select class="form-select form-select-sm" id="ordenar">
                                <option>Relevancia</option>
                                <option>Precio: Menor a Mayor</option>
                                <option>Precio: Mayor a Menor</option>
                                <option>Más Recientes</option>
                                <option>Más Populares</option>
                            </select>
                        </div>
                    </div>

                    {{-- Productos --}}
                    <div class="row g-4">
                        @foreach($products as $product)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border-0 shadow-sm product-card transition-hover">
                                <div class="position-relative overflow-hidden product-img-container">
                                <img src="{{ asset($product->image) }}" class="card-img-top product-img" alt="{{ $product->name }}">                                
                                <div class="product-overlay">
                                        <button class="btn btn-sm btn-danger rounded-pill mx-1">Detalles</button>
                                    </div>
                                    <span class="position-absolute top-0 end-0 bg-danger text-white m-3 px-2 py-1 rounded-pill small fw-bold">Nuevo</span>
                                </div>
                                <div class="card-body d-flex flex-column p-4">
                                    <p class="text-uppercase text-muted small mb-1">{{ $product->team }}</p>
                                    <h3 class="card-title h5 mb-2 product-title">{{ $product->name }}</h3>
                                    <div class="mb-2">
                                        <span class="text-muted small">Escala: 1:18</span>
                                    </div>
                                    <p class="card-text text-muted small mb-3 flex-grow-1">{{ $product->description }}</p>
                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="h5 fw-bold text-danger mb-0">€{{ number_format($product->price, 2) }}</span>
                                            <button class="btn btn-dark rounded-pill px-3 add-to-cart">
                                                <i class="fas fa-shopping-cart me-1"></i> Añadir
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Paginación --}}
                    <div class="d-flex justify-content-center mt-5">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Banner de suscripción --}}
    <section class="bg-gradient-danger text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mb-3 mb-lg-0">
                    <h3 class="fw-bold mb-2">¿Buscas un modelo específico?</h3>
                    <p class="mb-0 lead">Contáctanos y te ayudaremos a encontrar ese modelo único que estás buscando.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="#" class="btn btn-outline-light btn-lg rounded-pill px-4 fw-bold">Contactar</a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<style>
    /* Estilos personalizados para el catálogo */
    .product-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    
    .product-img-container {
        position: relative;
        overflow: hidden;
        height: 200px;
    }
    
    .product-img {
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .product-card:hover .product-img {
        transform: scale(1.05);
    }
    
    .product-overlay {
        position: absolute;
        bottom: -50px;
        left: 0;
        right: 0;
        background-color: rgba(0, 0, 0, 0.7);
        padding: 10px;
        transition: bottom 0.3s ease;
        text-align: center;
    }
    
    .product-card:hover .product-overlay {
        bottom: 0;
    }
    
    .product-title {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .add-to-cart {
        transition: all 0.3s ease;
    }
    
    .add-to-cart:hover {
        background-color: #dc3545;
        border-color: #dc3545;
    }
    
    .bg-gradient-danger {
        background: linear-gradient(45deg, #dc3545, #a71d2a);
    }
    
    /* Estilo para sticky filter en móvil */
    @media (max-width: 991.98px) {
        .sticky-top {
            position: relative;
            top: 0;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Script para actualizar el valor del precio en el filtro
    document.addEventListener('DOMContentLoaded', function() {
        const rangoPrecio = document.getElementById('rangoPrecio');
        const valorPrecio = document.getElementById('valorPrecio');
        
        if(rangoPrecio && valorPrecio) {
            rangoPrecio.addEventListener('input', function() {
                valorPrecio.textContent = this.value + '€';
            });
        }
        
        // Inicializar tooltips y popovers si estás usando Bootstrap 5
        if(typeof bootstrap !== 'undefined') {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    });
</script>
@endpush