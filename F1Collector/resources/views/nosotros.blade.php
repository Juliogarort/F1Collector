@extends('layouts.app')

@section('title', 'F1 Collector - Sobre Nosotros')

@section('content')
<link rel="stylesheet" href="{{ asset('css/nosotros.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">

<div class="about-us-page">
    <!-- Banner principal -->
    <div class="about-us-banner">
        <div class="banner-content container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto text-center">
                    <h1 class="display-3 banner-title">Acelerando la Pasión por la F1</h1>
                    <p class="lead banner-subtitle">F1Collector: Donde la historia y la velocidad se convierten en coleccionables únicos.</p>
                    <a href="{{ route('catalogo') }}" class="btn btn-racing-primary mt-3">Descubre Nuestra Colección</a>
                </div>
            </div>
        </div>
        <div class="banner-overlay"></div>
    </div>

    <!-- Sección: Nuestra Historia -->
    <section class="about-section history-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="about-image-container">
                        <img src="{{ asset('images/f1alonso.jpg') }}" alt="Nuestra Historia" class="img-fluid rounded shadow">
                        <div class="carbon-fiber-overlay"></div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="section-title-container">
                        <h2 class="section-title">Nuestra Historia</h2>
                        <div class="speed-line"></div>
                    </div>
                    <p>Fundada en 2018, F1Collector surgió del rugido de los motores y la pasión por la Fórmula 1. Lo que comenzó como un sueño entre aficionados se ha convertido en el referente mundial de coleccionables exclusivos.</p>
                    <p>Cada pieza en nuestro catálogo es un homenaje a la velocidad, la ingeniería y las leyendas de la F1. Seleccionamos cuidadosamente cada artículo, asegurando autenticidad y calidad inigualables.</p>
                    <p>Con conexiones directas con equipos, pilotos y fabricantes, ofrecemos coleccionables que capturan momentos icónicos del automovilismo, diseñados para los verdaderos fanáticos.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección: Nuestros Valores -->
    <section class="about-section values-section">
        <div class="container">
            <div class="section-title-container text-center mb-5">
                <h2 class="section-title">Nuestros Pilares</h2>
                <div class="speed-line mx-auto"></div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="value-card">
                        <div class="value-content">
                            <div class="value-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <h3>Autenticidad</h3>
                            <p>Cada coleccionable es verificado por expertos y respaldado por certificados, garantizando su origen y calidad.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="value-card">
                        <div class="value-content">
                            <div class="value-icon">
                                <i class="bi bi-gauge"></i>
                            </div>
                            <h3>Precisión</h3>
                            <p>Buscamos la perfección en cada detalle, desde la curación de productos hasta la experiencia del cliente.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="value-card">
                        <div class="value-content">
                            <div class="value-icon">
                                <i class="bi bi-flag-checkered"></i>
                            </div>
                            <h3>Pasión</h3>
                            <p>Unimos a una comunidad global de fanáticos que viven y respiran la emoción de la Fórmula 1.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección: Nuestro Equipo -->
    <section class="about-section team-section">
        <div class="container">
            <div class="section-title-container text-center mb-5">
                <h2 class="section-title">Nuestra Escudería</h2>
                <div class="speed-line mx-auto"></div>
            </div>
            <div class="row">
                @php
                $teamMembers = [
                    ['name' => 'Carlos Martínez', 'position' => 'Fundador & CEO', 'desc' => 'Lidera con visión y pasión, guiando a F1Collector como un campeón en la pista.', 'img' => 'cs.png'],
                    ['name' => 'Laura Sánchez', 'position' => 'Directora de Adquisiciones', 'desc' => 'Navega el mundo de la F1 para traer piezas únicas a nuestra colección.', 'img' => 'susie.png'],
                    ['name' => 'Miguel Torres', 'position' => 'Especialista en Contenido', 'desc' => 'Cuenta las historias detrás de cada coleccionable con precisión y pasión.', 'img' => 'nano.png'],
                    ['name' => 'Ana López', 'position' => 'Atención al Cliente', 'desc' => 'Asegura que cada fanático cruce la meta con una sonrisa.', 'img' => 'marta.png']
                ];
                @endphp
                
                @foreach($teamMembers as $member)
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="team-member">
                        <div class="team-image">
                            <img src="{{ asset('images/nosotros/' . $member['img']) }}" alt="{{ $member['name'] }}" class="img-fluid">
                            <div class="team-overlay"></div>
                        </div>
                        <div class="team-info">
                            <h3>{{ $member['name'] }}</h3>
                            <p class="position">{{ $member['position'] }}</p>
                            <p class="description">{{ $member['desc'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Sección: Testimonios -->
    <section class="about-section testimonials-section">
        <div class="container">
            <div class="section-title-container text-center mb-5">
                <h2 class="section-title">Voces de la Parrilla</h2>
                <div class="speed-line mx-auto"></div>
            </div>
            <div class="row">
                @php
                $testimonials = [
                    ['name' => 'Roberto G.', 'text' => 'La calidad de los coleccionables es de otro nivel. Cada pieza cuenta una historia épica de la F1. Su atención al detalle es impresionante.', 'rating' => 5],
                    ['name' => 'María T.', 'text' => 'F1Collector combina pasión y profesionalismo. Mis compras siempre llegan con un toque especial. Recomiendo totalmente sus servicios.', 'rating' => 5],
                    ['name' => 'David M.', 'text' => 'El casco a escala que compré es una obra maestra. ¡F1Collector es mi equipo favorito! Su conocimiento del mundo de la F1 es incomparable.', 'rating' => 5]
                ];
                @endphp
                
                @foreach($testimonials as $testimonial)
                <div class="col-lg-4 mb-4">
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <p>{{ $testimonial['text'] }}</p>
                        </div>
                        <div class="testimonial-author">
                            <p class="author-name">{{ $testimonial['name'] }}</p>
                            <div class="rating">
                                @for ($i = 0; $i < $testimonial['rating']; $i++)
                                <i class="bi bi-star-fill"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Sección CTA -->
    <section class="about-section cta-section">
        <div class="container">
            <div class="cta-container">
                <div class="row align-items-center">
                    <div class="col-lg-8 col-md-7">
                        <h2>¡Pisa el Acelerador!</h2>
                        <p>Explora nuestro catálogo y encuentra el coleccionable que llevará tu pasión por la F1 al siguiente nivel.</p>
                    </div>
                    <div class="col-lg-4 col-md-5 text-md-end text-center mt-3 mt-md-0">
                        <a href="{{ route('catalogo') }}" class="btn btn-racing-primary btn-lg">Ver Catálogo</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection