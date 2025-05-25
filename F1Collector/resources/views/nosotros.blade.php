@extends('layouts.app')

@section('title', 'F1 Collector - Sobre Nosotros')

@section('head')
<!-- Fonts para consistencia con landing -->
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    /* Variables CSS matching landing page */
    :root {
        --f1-red: #FF1801;
        --f1-dark: #0C0C0C;
        --f1-silver: #C5C5C5;
        --f1-gold: #FFD700;
        --f1-carbon: #1A1A1A;
        --gradient-primary: linear-gradient(135deg, #FF1801 0%, #000000 100%);
        --gradient-secondary: linear-gradient(45deg, #FFD700 0%, #FF1801 100%);
    }

    /* Body styling */
    body {
        font-family: 'Inter', sans-serif;
        color: #FFFFFF;
        background: var(--f1-dark);
        overflow-x: hidden;
    }

    /* Hero Section similar to landing */
    .about-hero-section {
        height: 80vh;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.8)),
        url("{{ asset('images/nosotros/goats.jpeg') }}") center/cover;
    }

    .about-hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 120%;
        background-size: cover;
        background-attachment: fixed;
        z-index: -1;
        will-change: transform;
    }

    .hero-content {
        text-align: center;
        z-index: 10;
        max-width: 800px;
        padding: 0 20px;
    }

    .hero-title {
        font-family: 'Orbitron', monospace;
        font-weight: 900;
        font-size: clamp(2.5rem, 6vw, 4.5rem);
        background: var(--gradient-secondary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1rem;
        animation: glow 2s ease-in-out infinite alternate;
        text-transform: uppercase;
    }

    @keyframes glow {
        from {
            filter: drop-shadow(0 0 20px rgba(255, 24, 1, 0.5));
        }

        to {
            filter: drop-shadow(0 0 40px rgba(255, 24, 1, 0.8));
        }
    }

    .hero-subtitle {
        font-size: 1.3rem;
        color: var(--f1-silver);
        margin-bottom: 2rem;
        font-weight: 300;
    }

    .speed-indicator {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 3rem;
        padding: 10px 20px;
        background: rgba(255, 24, 1, 0.1);
        border: 1px solid var(--f1-red);
        border-radius: 50px;
        backdrop-filter: blur(10px);
    }

    .speed-line {
        width: 50px;
        height: 3px;
        background: var(--gradient-secondary);
        position: relative;
        overflow: hidden;
    }

    .speed-line::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 100%;
        background: white;
        animation: dash 1.5s infinite;
    }

    @keyframes dash {
        0% {
            transform: translateX(-30px);
        }

        100% {
            transform: translateX(70px);
        }
    }

    /* Floating Elements */
    .floating-car {
        position: absolute;
        font-size: 3rem;
        color: var(--f1-red);
        opacity: 0.1;
        animation: float 6s ease-in-out infinite;
        z-index: 1;
    }

    .floating-car:nth-child(1) {
        top: 20%;
        left: 10%;
        animation-delay: 0s;
    }

    .floating-car:nth-child(2) {
        top: 60%;
        right: 15%;
        animation-delay: 2s;
    }

    .floating-car:nth-child(3) {
        bottom: 20%;
        left: 20%;
        animation-delay: 4s;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0px) rotate(0deg);
        }

        50% {
            transform: translateY(-20px) rotate(5deg);
        }
    }

    /* Section Styling similar to landing */
    .about-section {
        padding: 100px 0;
        position: relative;
    }

    .section-title {
        font-family: 'Orbitron', monospace;
        font-size: clamp(2rem, 4vw, 3rem);
        text-align: center;
        margin-bottom: 4rem;
        background: var(--gradient-secondary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-transform: uppercase;
        font-weight: 700;
    }

    /* History Section */
    .history-section {
        background: linear-gradient(180deg, var(--f1-dark) 0%, var(--f1-carbon) 100%);
    }

    .history-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
    }

    .history-image-container {
        position: relative;
        overflow: hidden;
        border-radius: 20px;
        border: 2px solid rgba(255, 24, 1, 0.3);
        transition: all 0.4s ease;
    }

    .history-image-container:hover {
        border-color: var(--f1-red);
        box-shadow: 0 25px 50px rgba(255, 24, 1, 0.3);
        transform: scale(1.02);
    }

    .history-image-container img {
        width: 100%;
        height: 400px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .history-image-container:hover img {
        transform: scale(1.1);
    }

    .history-text h3 {
        font-family: 'Orbitron', monospace;
        color: var(--f1-gold);
        font-size: 1.5rem;
        margin-bottom: 1rem;
        text-transform: uppercase;
    }

    .history-text p {
        color: var(--f1-silver);
        line-height: 1.8;
        margin-bottom: 1.5rem;
        font-size: 1.1rem;
    }

    /* Values Section with grid */
    .values-section {
        background: var(--gradient-primary);
    }

    .values-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 30px;
    }

    .value-card {
        background: linear-gradient(145deg, rgba(255, 255, 255, 0.05), rgba(0, 0, 0, 0.3));
        border: 1px solid rgba(255, 24, 1, 0.2);
        border-radius: 20px;
        padding: 40px;
        text-align: center;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
    }

    .value-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transition: left 0.6s;
    }

    .value-card:hover::before {
        left: 100%;
    }

    .value-card:hover {
        transform: translateY(-10px);
        border-color: var(--f1-red);
        box-shadow: 0 20px 40px rgba(255, 24, 1, 0.4);
    }

    .value-icon {
        font-size: 3.5rem;
        color: var(--f1-gold);
        margin-bottom: 20px;
        display: block;
        transition: transform 0.3s ease;
    }

    .value-card:hover .value-icon {
        transform: scale(1.2) rotate(5deg);
    }

    .value-card h3 {
        font-family: 'Orbitron', monospace;
        font-size: 1.5rem;
        margin-bottom: 15px;
        color: white;
        text-transform: uppercase;
    }

    .value-card p {
        color: var(--f1-silver);
        line-height: 1.6;
    }

    /* Team Section */
    .team-section {
        background: linear-gradient(180deg, var(--f1-carbon) 0%, var(--f1-dark) 100%);
    }

    .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 40px;
    }

    .team-member {
        background: linear-gradient(145deg, rgba(255, 24, 1, 0.05), rgba(0, 0, 0, 0.3));
        border: 1px solid rgba(255, 24, 1, 0.2);
        border-radius: 20px;
        padding: 30px;
        text-align: center;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
    }

    .team-member:hover {
        transform: translateY(-10px);
        border-color: var(--f1-red);
        box-shadow: 0 25px 50px rgba(255, 24, 1, 0.3);
    }

    .team-image {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        margin: 0 auto 20px;
        overflow: hidden;
        border: 3px solid var(--f1-red);
        position: relative;
    }

    .team-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .team-member:hover .team-image img {
        transform: scale(1.1);
    }

    .team-info h3 {
        font-family: 'Orbitron', monospace;
        color: white;
        font-size: 1.2rem;
        margin-bottom: 5px;
        text-transform: uppercase;
    }

    .team-info .position {
        color: var(--f1-gold);
        font-weight: 600;
        margin-bottom: 10px;
        text-transform: uppercase;
        font-size: 0.9rem;
    }

    .team-info .description {
        color: var(--f1-silver);
        font-size: 0.95rem;
        line-height: 1.5;
    }

    /* Testimonials Section */
    .testimonials-section {
        background: var(--f1-dark);
    }

    .testimonials-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 30px;
    }

    .testimonial-card {
        background: linear-gradient(145deg, rgba(255, 24, 1, 0.05), rgba(0, 0, 0, 0.3));
        border: 1px solid rgba(255, 24, 1, 0.2);
        border-radius: 20px;
        padding: 35px;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
    }

    .testimonial-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: var(--gradient-secondary);
    }

    .testimonial-card:hover {
        transform: translateY(-10px);
        border-color: var(--f1-red);
        box-shadow: 0 25px 50px rgba(255, 24, 1, 0.3);
    }

    .testimonial-content p {
        color: var(--f1-silver);
        font-style: italic;
        line-height: 1.6;
        margin-bottom: 20px;
        font-size: 1.05rem;
    }

    .testimonial-author {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid rgba(255, 24, 1, 0.2);
        padding-top: 15px;
    }

    .author-name {
        font-family: 'Orbitron', monospace;
        color: var(--f1-gold);
        font-weight: 600;
        text-transform: uppercase;
    }

    .rating {
        color: var(--f1-gold);
        font-size: 1.1rem;
    }

    /* CTA Section */

    .cta-section {
        background: var(--gradient-primary);
        padding: 80px 0;
        text-align: center;
    }

    .cta-content {
        max-width: 600px;
        margin: 0 auto;
    }

    .cta-content h2 {
        font-family: 'Orbitron', monospace;
        font-size: 2.5rem;
        color: white;
        margin-bottom: 1rem;
        text-transform: uppercase;
    }

    .cta-content p {
        color: var(--f1-silver);
        font-size: 1.2rem;
        margin-bottom: 2rem;
    }

    .btn-primary-f1 {
        background: white;
        color: var(--f1-red);
        border: none;
        padding: 15px 40px;
        border-radius: 50px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        cursor: pointer;
        font-family: 'Orbitron', monospace;
    }

    .btn-primary-f1:hover {
        background: var(--f1-gold);
        color: var(--f1-dark);
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(255, 215, 0, 0.4);
    }

    /* Scroll animations */
    .fade-in {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s ease;
    }

    .fade-in.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .about-hero-section {
            height: 60vh;
        }

        .hero-title {
            font-size: 2.5rem;
        }

        .hero-subtitle {
            font-size: 1.1rem;
        }

        .history-content {
            grid-template-columns: 1fr;
            gap: 40px;
        }

        .history-image-container img {
            height: 300px;
        }

        .section-title {
            font-size: 2rem;
        }

        .about-section {
            padding: 60px 0;
        }

        .values-grid,
        .team-grid,
        .testimonials-grid {
            grid-template-columns: 1fr;
        }

        .value-card,
        .team-member,
        .testimonial-card {
            padding: 25px;
        }

        .testimonial-author {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="about-hero-section">
    <div class="floating-car"><i class="fas fa-racing-flag"></i></div>
    <div class="floating-car"><i class="fas fa-trophy"></i></div>
    <div class="floating-car"><i class="fas fa-stopwatch"></i></div>

    <div class="hero-content">
        <h1 class="hero-title">Acelerando la Pasión</h1>
        <p class="hero-subtitle">Donde la historia y la velocidad se convierten en coleccionables únicos</p>
        <div class="speed-indicator text-white">
            <span>DESDE</span>
            <span>2018</span>
        </div>

        <a href="{{ route('catalogo') }}" class="btn-primary-f1" style="margin-left: 16px;">Descubre Nuestra Colección</a>

    </div>
</section>

<!-- Historia Section -->
<section class="about-section history-section">
    <div class="container">
        <h2 class="section-title fade-in">Nuestra Historia</h2>

        <div class="history-content fade-in">
            <div class="history-image-container">
                <img src="{{ asset('images/f1alonso.jpg') }}" alt="Nuestra Historia">
            </div>

            <div class="history-text">
                <h3>Del Rugido a la Realidad</h3>
                <p>Fundada en 2018, F1Collector surgió del rugido de los motores y la pasión por la Fórmula 1. Lo que comenzó como un sueño entre aficionados se ha convertido en el referente mundial de coleccionables exclusivos.</p>

                <p>Cada pieza en nuestro catálogo es un homenaje a la velocidad, la ingeniería y las leyendas de la F1. Seleccionamos cuidadosamente cada artículo, asegurando autenticidad y calidad inigualables.</p>

                <p>Con conexiones directas con equipos, pilotos y fabricantes, ofrecemos coleccionables que capturan momentos icónicos del automovilismo, diseñados para los verdaderos fanáticos.</p>
            </div>
        </div>
    </div>
</section>

<!-- Valores Section -->
<section class="about-section values-section">
    <div class="container">
        <h2 class="section-title fade-in">Nuestros Pilares</h2>

        <div class="values-grid">
            <div class="value-card fade-in">
                <i class="fas fa-shield-check value-icon"></i>
                <h3>Autenticidad</h3>
                <p>Cada coleccionable es verificado por expertos y respaldado por certificados, garantizando su origen y calidad premium.</p>
            </div>

            <div class="value-card fade-in">
                <i class="fas fa-tachometer-alt value-icon"></i>
                <h3>Precisión</h3>
                <p>Buscamos la perfección en cada detalle, desde la curación de productos hasta la experiencia del cliente.</p>
            </div>

            <div class="value-card fade-in">
                <i class="fas fa-flag-checkered value-icon"></i>
                <h3>Pasión</h3>
                <p>Unimos a una comunidad global de fanáticos que viven y respiran la emoción de la Fórmula 1.</p>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="about-section team-section">
    <div class="container">
        <h2 class="section-title fade-in">Nuestra Escudería</h2>

        <div class="team-grid">
            @php
            $teamMembers = [
            ['name' => 'Carlos Martínez', 'position' => 'Fundador & CEO', 'desc' => 'Lidera con visión y pasión, guiando a F1Collector como un campeón en la pista.', 'img' => 'cs.png'],
            ['name' => 'Laura Sánchez', 'position' => 'Directora de Adquisiciones', 'desc' => 'Navega el mundo de la F1 para traer piezas únicas a nuestra colección.', 'img' => 'susie.png'],
            ['name' => 'Miguel Torres', 'position' => 'Especialista en Contenido', 'desc' => 'Cuenta las historias detrás de cada coleccionable con precisión y pasión.', 'img' => 'nano.png'],
            ['name' => 'Ana López', 'position' => 'Atención al Cliente', 'desc' => 'Asegura que cada fanático cruce la meta con una sonrisa.', 'img' => 'marta.png']
            ];
            @endphp

            @foreach($teamMembers as $member)
            <div class="team-member fade-in">
                <div class="team-image">
                    <img src="{{ asset('images/nosotros/' . $member['img']) }}" alt="{{ $member['name'] }}">
                </div>
                <div class="team-info">
                    <h3>{{ $member['name'] }}</h3>
                    <p class="position">{{ $member['position'] }}</p>
                    <p class="description">{{ $member['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="about-section testimonials-section">
    <div class="container">
        <h2 class="section-title fade-in">Voces de la Parrilla</h2>

        <div class="testimonials-grid">
            @php
            $testimonials = [
            ['name' => 'Roberto G.', 'text' => 'La calidad de los coleccionables es de otro nivel. Cada pieza cuenta una historia épica de la F1. Su atención al detalle es impresionante.', 'rating' => 5],
            ['name' => 'María T.', 'text' => 'F1Collector combina pasión y profesionalismo. Mis compras siempre llegan con un toque especial. Recomiendo totalmente sus servicios.', 'rating' => 5],
            ['name' => 'David M.', 'text' => 'El casco a escala que compré es una obra maestra. ¡F1Collector es mi equipo favorito! Su conocimiento del mundo de la F1 es incomparable.', 'rating' => 5]
            ];
            @endphp

            @foreach($testimonials as $testimonial)
            <div class="testimonial-card fade-in">
                <div class="testimonial-content">
                    <p>"{{ $testimonial['text'] }}"</p>
                </div>
                <div class="testimonial-author">
                    <span class="author-name">{{ $testimonial['name'] }}</span>
                    <div class="rating">
                        @for ($i = 0; $i < $testimonial['rating']; $i++)
                            <i class="fas fa-star"></i>
                            @endfor
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content fade-in">
            <h2>¡Pisa el Acelerador!</h2>
            <p>Explora nuestro catálogo y encuentra el coleccionable que llevará tu pasión por la F1 al siguiente nivel.</p>
            <a href="{{ route('catalogo') }}" class="btn-primary-f1">Ver Catálogo</a>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Scroll animations similar to landing page
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-in').forEach(el => {
            observer.observe(el);
        });

        // Parallax effect for hero background
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const heroSection = document.querySelector('.about-hero-section');

            if (heroSection) {
                heroSection.style.setProperty('--scroll-offset', scrolled * 0.3 + 'px');
            }
        });

        // Apply parallax using CSS custom properties
        const style = document.createElement('style');
        style.textContent = `
        .about-hero-section::before {
            transform: translateY(var(--scroll-offset, 0));
        }
    `;
        document.head.appendChild(style);
    });
</script>
@endsection