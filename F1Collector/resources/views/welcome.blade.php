@extends('layouts.app')

@section('title', 'F1 Collector - Colección de Modelos a Escala')

@section('content')
<div class="container-fluid p-0">
    {{-- Hero Section --}}
    <header class="position-relative bg-dark text-white overflow-hidden">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-7 text-center text-lg-start">
                    <h1 class="display-4 fw-bold text-danger mb-4">F1 Collector</h1>
                    <p class="lead text-light mb-5">
                        Descubre la pasión de la Fórmula 1 con nuestra exclusiva colección de modelos a escala, capturando la esencia de los monoplazas más emblemáticos de la historia.
                    </p>
                    <div class="d-flex justify-content-center justify-content-lg-start gap-3">
                        <a href="./catalogo.blade.php" class="btn btn-danger btn-lg px-4 rounded-pill">Explorar Catálogo</a>
                        <a href="./catalogo.blade.php" class="btn btn-outline-light btn-lg px-4 rounded-pill">Nuestra Colección</a>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-block">
                    <div class="position-relative">
                        {{-- <img src="{{ Vite::asset('images/f1-model-hero.png') }}" class="img-fluid shadow-lg rounded-4" alt="Modelo F1"> --}}                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-danger opacity-25 rounded-4"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="position-absolute bottom-0 start-0 w-100 bg-gradient-dark" style="height: 100px;"></div>
    </header>

    {{-- Sección de Características --}}
    <section class="bg-white py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 text-center p-4 shadow-sm">
                        <div class="card-body">
                            <div class="mb-4">
                                <i class="fas fa-trophy fs-2 text-danger"></i>
                            </div>
                            <h3 class="h4 mb-3">Modelos Auténticos</h3>
                            <p class="text-muted">Réplicas precisas certificadas por los equipos oficiales de Fórmula 1</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 text-center p-4 shadow-sm">
                        <div class="card-body">
                            <div class="mb-4">
                                <i class="fas fa-medal fs-2 text-danger"></i>
                            </div>
                            <h3 class="h4 mb-3">Ediciones Limitadas</h3>
                            <p class="text-muted">Coleccionables exclusivos numerados y con certificado de autenticidad</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 text-center p-4 shadow-sm">
                        <div class="card-body">
                            <div class="mb-4">
                                <i class="fas fa-car fs-2 text-danger"></i>
                            </div>
                            <h3 class="h4 mb-3">Calidad Premium</h3>
                            <p class="text-muted">Fabricados con materiales de alta precisión y detalles meticulosos</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Sección de Modelos Destacados --}}
    <section class="bg-light py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-6 fw-bold">Modelos Destacados</h2>
                <p class="lead text-muted">Nuestra selección de los modelos más exclusivos</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-lg overflow-hidden h-100">
                       <img src="{{ Vite::asset('resources/images/ferrari.webp') }}" class="card-img-top" alt="Ferrari SF-75">
                        <div class="card-body">
                            <h3 class="card-title h4 mb-3">Ferrari SF-75</h3>
                            <p class="card-text text-muted mb-3">Edición conmemorativa del monoplaza de Charles Leclerc</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 text-danger mb-0">$249.99</span>
                                <a href="#" class="btn btn-dark rounded-pill px-3">Detalles</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-lg overflow-hidden h-100">
                        <img src="{{ Vite::asset('resources/images/redbull.webp') }}" class="card-img-top" alt="Red Bull RB18">
                        <div class="card-body">
                            <h3 class="card-title h4 mb-3">Red Bull RB18</h3>
                            <p class="card-text text-muted mb-3">Modelo del campeonato de Max Verstappen</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 text-danger mb-0">$279.99</span>
                                <a href="#" class="btn btn-dark rounded-pill px-3">Detalles</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-lg overflow-hidden h-100">
                    <img src="{{ Vite::asset('resources/images/mercedes.webp') }}" class="card-img-top" alt="Mercedes">
                    <div class="card-body">
                            <h3 class="card-title h4 mb-3">Mercedes W13</h3>
                            <p class="card-text text-muted mb-3">Réplica del monoplaza de George Russel</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 text-danger mb-0">$259.99</span>
                                <a href="#" class="btn btn-dark rounded-pill px-3">Detalles</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Sección de Newsletter --}}
    <section class="bg-dark text-white py-5">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h2 class="display-6 fw-bold mb-4">Mantente al Día</h2>
                    <p class="lead text-muted mb-5">Suscríbete a nuestro newsletter y recibe información exclusiva sobre nuevos modelos y ofertas especiales</p>
                    
                    <form class="row g-3 justify-content-center">
                        <div class="col-md-7">
                            <div class="input-group">
                                <input type="email" class="form-control form-control-lg" placeholder="Tu correo electrónico" required>
                                <button class="btn btn-danger" type="submit">Suscribirse</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
@endpush