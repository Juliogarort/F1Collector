@extends('layouts.app')

@section('title', 'F1 Collector - Catálogo de Modelos')

@section('content')
<div class="container-fluid p-0">
    {{-- Cabecera del Catálogo --}}
    <header class="bg-dark text-white py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 text-center">
                    <h1 class="display-5 fw-bold text-danger mb-2">Catálogo de Modelos</h1>
                    <p class="lead text-light">Explora nuestra exclusiva colección de modelos a escala de F1</p>
                </div>
            </div>
        </div>
    </header>

    {{-- Sección de Filtros y Productos --}}
    <section class="py-5">
        <div class="container">
            <div class="row">
                {{-- Barra lateral de filtros --}}
                <div class="col-lg-3 mb-4 mb-lg-0">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0">Filtros</h5>
                        </div>
                        <div class="card-body">
                            {{-- Filtro por Escudería --}}
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">Escudería</h6>
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
                                <h6 class="fw-bold mb-3">Escala</h6>
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
                                <h6 class="fw-bold mb-3">Precio</h6>
                                <div class="d-flex align-items-center">
                                    <span class="me-2">€</span>
                                    <input type="range" class="form-range" min="50" max="500" id="rangoPrecio">
                                    <span class="ms-2" id="valorPrecio">275€</span>
                                </div>
                            </div>

                            {{-- Botón para aplicar filtros --}}
                            <button class="btn btn-danger w-100">Aplicar Filtros</button>
                        </div>
                    </div>
                </div>

                {{-- Cuadrícula de productos --}}
                <div class="col-lg-9">
                    {{-- Opciones de ordenamiento --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <span class="text-muted">Mostrando 24 de 68 productos</span>
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
                        {{-- Producto 1 --}}
                        <div class="col-md-4">
                            <div class="card border-0 shadow-lg h-100">
                                <div class="position-relative">
                                    <img src="{{ asset('images/ferrari-sf75.jpg') }}" class="card-img-top" alt="Ferrari SF-75">
                                    <span class="position-absolute top-0 end-0 bg-danger text-white m-2 px-2 py-1 rounded-pill">Nuevo</span>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <p class="text-muted small mb-1">Ferrari</p>
                                    <h3 class="card-title h5 mb-3">Ferrari SF-75 - Charles Leclerc</h3>
                                    <p class="card-text text-muted mb-3">Edición conmemorativa 2022 a escala 1:18 con detalles meticulosos</p>
                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="h5 text-danger mb-0">€249.99</span>
                                            <a href="#" class="btn btn-outline-dark rounded-pill px-3">Añadir <i class="fas fa-shopping-cart ms-1"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Producto 2 --}}
                        <div class="col-md-4">
                            <div class="card border-0 shadow-lg h-100">
                                <img src="{{ asset('images/redbull-rb18.jpg') }}" class="card-img-top" alt="Red Bull RB18">
                                <div class="card-body d-flex flex-column">
                                    <p class="text-muted small mb-1">Red Bull Racing</p>
                                    <h3 class="card-title h5 mb-3">Red Bull RB18 - Max Verstappen</h3>
                                    <p class="card-text text-muted mb-3">Modelo campeón del mundo 2022 a escala 1:18 con certificado</p>
                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="h5 text-danger mb-0">€279.99</span>
                                            <a href="#" class="btn btn-outline-dark rounded-pill px-3">Añadir <i class="fas fa-shopping-cart ms-1"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Producto 3 --}}
                        <div class="col-md-4">
                            <div class="card border-0 shadow-lg h-100">
                                <div class="position-relative">
                                    <img src="{{ asset('images/mercedes-w13.jpg') }}" class="card-img-top" alt="Mercedes W13">
                                    <span class="position-absolute top-0 end-0 bg-success text-white m-2 px-2 py-1 rounded-pill">Oferta</span>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <p class="text-muted small mb-1">Mercedes-AMG F1</p>
                                    <h3 class="card-title h5 mb-3">Mercedes W13 - Lewis Hamilton</h3>
                                    <p class="card-text text-muted mb-3">Modelo temporada 2022 a escala 1:18 con detalles de ingeniería</p>
                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="text-decoration-line-through text-muted me-2">€289.99</span>
                                                <span class="h5 text-danger mb-0">€259.99</span>
                                            </div>
                                            <a href="#" class="btn btn-outline-dark rounded-pill px-3">Añadir <i class="fas fa-shopping-cart ms-1"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Producto 4 --}}
                        <div class="col-md-4">
                            <div class="card border-0 shadow-lg h-100">
                                <img src="{{ asset('images/ferrari-sf75.jpg') }}" class="card-img-top" alt="Ferrari SF-75">
                                <div class="card-body d-flex flex-column">
                                    <p class="text-muted small mb-1">Ferrari</p>
                                    <h3 class="card-title h5 mb-3">Ferrari SF-75 - Carlos Sainz</h3>
                                    <p class="card-text text-muted mb-3">Modelo de la temporada 2022 a escala 1:43 con estuche de exhibición</p>
                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="h5 text-danger mb-0">€159.99</span>
                                            <a href="#" class="btn btn-outline-dark rounded-pill px-3">Añadir <i class="fas fa-shopping-cart ms-1"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Producto 5 --}}
                        <div class="col-md-4">
                            <div class="card border-0 shadow-lg h-100">
                                <img src="{{ asset('images/mclaren-mcl36.jpg') }}" class="card-img-top" alt="McLaren MCL36">
                                <div class="card-body d-flex flex-column">
                                    <p class="text-muted small mb-1">McLaren</p>
                                    <h3 class="card-title h5 mb-3">McLaren MCL36 - Lando Norris</h3>
                                    <p class="card-text text-muted mb-3">Modelo de la temporada 2022 a escala 1:18 con detalles de fibra de carbono</p>
                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="h5 text-danger mb-0">€239.99</span>
                                            <a href="#" class="btn btn-outline-dark rounded-pill px-3">Añadir <i class="fas fa-shopping-cart ms-1"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Producto 6 --}}
                        <div class="col-md-4">
                            <div class="card border-0 shadow-lg h-100">
                                <div class="position-relative">
                                    <img src="{{ asset('images/alpine-a522.jpg') }}" class="card-img-top" alt="Alpine A522">
                                    <span class="position-absolute top-0 end-0 bg-primary text-white m-2 px-2 py-1 rounded-pill">Exclusivo</span>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <p class="text-muted small mb-1">Alpine</p>
                                    <h3 class="card-title h5 mb-3">Alpine A522 - Fernando Alonso</h3>
                                    <p class="card-text text-muted mb-3">Modelo de edición limitada a escala 1:18 firmado por Fernando Alonso</p>
                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="h5 text-danger mb-0">€329.99</span>
                                            <a href="#" class="btn btn-outline-dark rounded-pill px-3">Añadir <i class="fas fa-shopping-cart ms-1"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Continúa con más productos... --}}
                    </div>

                    {{-- Paginación --}}
                    <div class="d-flex justify-content-center mt-5">
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Banner de suscripción --}}
    <section class="bg-danger text-white py-4 my-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mb-3 mb-lg-0">
                    <h3 class="fw-bold mb-0">¿Buscas un modelo específico?</h3>
                    <p class="mb-0">Contáctanos y te ayudaremos a encontrar ese modelo único que estás buscando.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="#" class="btn btn-outline-light rounded-pill px-4">Contactar</a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
    });
</script>
@endpush