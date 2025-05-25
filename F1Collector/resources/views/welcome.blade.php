@extends('layouts.app')

@section('title', 'F1 Collector - Colecciona la Velocidad')

@section('head')
<!-- Fonts para la landing -->
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    /* Variables CSS para F1 Landing */
    :root {
        --f1-red: #FF1801;
        --f1-dark: #0C0C0C;
        --f1-silver: #C5C5C5;
        --f1-gold: #FFD700;
        --f1-carbon: #1A1A1A;
        --gradient-primary: linear-gradient(135deg, #FF1801 0%, #000000 100%);
        --gradient-secondary: linear-gradient(45deg, #FFD700 0%, #FF1801 100%);
    }

    /* Ajuste para el header existente */
    .racing-header {
        z-index: 1001;
    }

    /* Hero Section */
    .hero-section {
        height: 100vh;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 0;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: -20%;
        left: 0;
        width: 100%;
        height: 120%;
        background-image: url('/images/contacto/spa.webp');
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
        position: relative;
    }

    .hero-title {
        font-family: 'Orbitron', monospace;
        font-weight: 900;
        font-size: clamp(3rem, 8vw, 6rem);
        background: var(--gradient-secondary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1rem;
        animation: glow 2s ease-in-out infinite alternate;
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
        font-size: 1.5rem;
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

    .cta-buttons {
        display: flex;
        gap: 20px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-primary-f1 {
        background: var(--gradient-primary);
        border: none;
        padding: 15px 40px;
        border-radius: 50px;
        color: white;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        cursor: pointer;
    }

    .btn-primary-f1:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(255, 24, 1, 0.4);
        color: white;
    }

    .btn-secondary-f1 {
        background: transparent;
        border: 2px solid var(--f1-red);
        padding: 13px 38px;
        border-radius: 50px;
        color: var(--f1-red);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        cursor: pointer;
    }

    .btn-secondary-f1:hover {
        background: var(--f1-red);
        color: white;
        transform: translateY(-3px);
    }

    /* Floating Elements */
    .floating-car {
        position: absolute;
        font-size: 4rem;
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

    /* Features Section */
    .features-section {
        padding: 100px 0;
        background: linear-gradient(180deg, var(--f1-dark) 0%, var(--f1-carbon) 100%);
    }

    .section-title {
        font-size: 3rem;
        text-align: center;
        margin-bottom: 4rem;
        background: var(--gradient-secondary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .feature-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 30px;
    }

    .feature-card {
        background: linear-gradient(145deg, rgba(255, 24, 1, 0.05), rgba(0, 0, 0, 0.3));
        border: 1px solid rgba(255, 24, 1, 0.2);
        border-radius: 20px;
        padding: 40px;
        text-align: center;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
    }

    .feature-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transition: left 0.6s;
    }

    .feature-card:hover::before {
        left: 100%;
    }

    .feature-card:hover {
        transform: translateY(-10px);
        border-color: var(--f1-red);
        box-shadow: 0 20px 40px rgba(255, 24, 1, 0.2);
    }

    .feature-icon {
        font-size: 3.5rem;
        color: var(--f1-red);
        margin-bottom: 20px;
        display: block;
    }

    .feature-title {
        font-family: 'Orbitron', monospace;
        font-size: 1.5rem;
        margin-bottom: 15px;
        color: white;
    }

    .feature-description {
        color: var(--f1-silver);
        line-height: 1.6;
    }

    /* Collection Preview */
    .collection-section {
        padding: 100px 0;
        background: var(--f1-dark);
    }

    .collection-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-top: 50px;
    }

    .collection-card {
        background: var(--f1-carbon);
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.4s ease;
        border: 1px solid rgba(255, 24, 1, 0.1);
    }

    .collection-card:hover {
        transform: scale(1.05);
        border-color: var(--f1-red);
        box-shadow: 0 25px 50px rgba(255, 24, 1, 0.3);
    }

    .card-image {
        height: 200px;
        background: linear-gradient(45deg, #333, #666);
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .card-content {
        padding: 25px;
    }

    .card-content h3 {
        color: white;
    }


    .card-title {
        font-family: 'Orbitron', monospace;
        font-size: 1.3rem;
        margin-bottom: 10px;
        color: white;
    }

    .card-price {
        color: var(--f1-gold);
        font-weight: 700;
        font-size: 1.2rem;
    }

    .card-description {
        color: var(--f1-silver);
        margin: 10px 0;
        font-size: 0.9rem;
    }

    /* Stats Section */
    .stats-section {
        padding: 80px 0;
        background: var(--gradient-primary);
        text-align: center;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 40px;
    }

    .stat-item {
        color: white;
    }

    .stat-number {
        font-family: 'Orbitron', monospace;
        font-size: 3rem;
        font-weight: 900;
        display: block;
        margin-bottom: 10px;
    }

    .stat-label {
        font-size: 1.1rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Newsletter */
    .newsletter-section {
        padding: 80px 0;
        background: var(--f1-carbon);
        text-align: center;
    }

    .newsletter-content {
        max-width: 600px;
        margin: 0 auto;
    }

    .newsletter-form {
        display: flex;
        gap: 15px;
        margin-top: 30px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .newsletter-input {
        flex: 1;
        min-width: 250px;
        padding: 15px 20px;
        border: 2px solid rgba(255, 24, 1, 0.3);
        border-radius: 50px;
        background: transparent;
        color: white;
        font-size: 1rem;
    }

    .newsletter-input:focus {
        outline: none;
        border-color: var(--f1-red);
    }

    .newsletter-input::placeholder {
        color: var(--f1-silver);
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

    /* Responsive */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 3rem;
        }

        .hero-subtitle {
            font-size: 1.2rem;
        }

        .cta-buttons {
            flex-direction: column;
            align-items: center;
        }

        .section-title {
            font-size: 2rem;
        }

        .feature-grid {
            grid-template-columns: 1fr;
        }

        .newsletter-form {
            flex-direction: column;
            align-items: center;
        }

        .newsletter-input {
            width: 100%;
            max-width: 400px;
        }
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="floating-car"><i class="fas fa-racing-flag"></i></div>
    <div class="floating-car"><i class="fas fa-trophy"></i></div>
    <div class="floating-car"><i class="fas fa-stopwatch"></i></div>

    <div class="hero-content">
        <h1 class="hero-title">F1 COLLECTOR</h1>
        <p class="hero-subtitle">Colecciona la Velocidad, Vive la Pasión</p>

        <div class="speed-indicator">
            <span>VELOCIDAD MÁXIMA</span>
            <div class="speed-line"></div>
            <span>350 KM/H</span>
        </div>

        <div class="cta-buttons">
            <a href="{{ route('catalogo') }}" class="btn-primary-f1">Explorar Colección</a>
            <a href="{{ route('catalogo') }}" class="btn-secondary-f1">Ver Catálogo</a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section">
    <div class="container">
        <h2 class="section-title fade-in">Características Premium</h2>

        <div class="feature-grid">
            <div class="feature-card fade-in">
                <i class="fas fa-medal feature-icon"></i>
                <h3 class="feature-title">Autenticidad Garantizada</h3>
                <p class="feature-description">Modelos oficialmente licenciados con certificados de autenticidad y numeración exclusiva para cada pieza.</p>
            </div>

            <div class="feature-card fade-in">
                <i class="fas fa-gem feature-icon"></i>
                <h3 class="feature-title">Calidad Excepcional</h3>
                <p class="feature-description">Fabricados con materiales premium y detalles meticulosos que capturan la esencia de cada monoplaza legendario.</p>
            </div>

            <div class="feature-card fade-in">
                <i class="fas fa-shipping-fast feature-icon"></i>
                <h3 class="feature-title">Envío Seguro</h3>
                <p class="feature-description">Embalaje especializado y seguimiento completo para garantizar que tu inversión llegue en perfectas condiciones.</p>
            </div>
        </div>
    </div>
</section>

<!-- Collection Preview -->
<section class="collection-section">
    <div class="container">
        <h2 class="section-title fade-in">Modelos Destacados</h2>

        <div class="collection-grid">
            <div class="collection-card fade-in">
                <div class="card-image">
                    @if(file_exists(public_path('images/ferrari.webp')))
                    <img src="{{ asset('images/ferrari.webp') }}" alt="Ferrari SF-75">
                    @else
                    <i class="fas fa-car-side" style="font-size: 4rem; color: var(--f1-red);"></i>
                    @endif
                </div>
                <div class="card-content">
                    <h3 class="card-title">Ferrari SF-75</h3>
                    <p class="card-description">Edición Leclerc 2023 - Escala 1:43</p>
                    <div class="card-price">€249.99</div>
                </div>
            </div>

            <div class="collection-card fade-in">
                <div class="card-image">
                    @if(file_exists(public_path('images/redbull.webp')))
                    <img src="{{ asset('images/redbull.webp') }}" alt="Red Bull RB19">
                    @else
                    <i class="fas fa-car-side" style="font-size: 4rem; color: var(--f1-red);"></i>
                    @endif
                </div>
                <div class="card-content">
                    <h3 class="card-title">Red Bull RB19</h3>
                    <p class="card-description">Verstappen Campeón - Edición Limitada</p>
                    <div class="card-price">€279.99</div>
                </div>
            </div>

            <div class="collection-card fade-in">
                <div class="card-image">
                    @if(file_exists(public_path('images/mercedes.webp')))
                    <img src="{{ asset('images/mercedes.webp') }}" alt="Mercedes W14">
                    @else
                    <i class="fas fa-car-side" style="font-size: 4rem; color: var(--f1-red);"></i>
                    @endif
                </div>
                <div class="card-content">
                    <h3 class="card-title">Mercedes W14</h3>
                    <p class="card-description">Hamilton Legacy Collection</p>
                    <div class="card-price">€259.99</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="stats-grid fade-in">
            <div class="stat-item">
                <span class="stat-number" data-target="10000">0</span>
                <span class="stat-label">Coleccionistas</span>
            </div>
            <div class="stat-item">
                <span class="stat-number" data-target="500">0</span>
                <span class="stat-label">Modelos Únicos</span>
            </div>
            <div class="stat-item">
                <span class="stat-number" data-target="25">0</span>
                <span class="stat-label">Países</span>
            </div>
            <div class="stat-item">
                <span class="stat-number" data-target="98">0</span>
                <span class="stat-label">% Satisfacción</span>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter -->
<section class="newsletter-section">
    <div class="container">
        <div class="newsletter-content fade-in">
            <h2 class="section-title">Únete al Paddock VIP</h2>
            <p class="hero-subtitle">Recibe acceso exclusivo a lanzamientos, ofertas especiales y contenido premium</p>

            <form class="newsletter-form" action="#" method="POST">
                @csrf
                <input type="email" name="email" class="newsletter-input" placeholder="Tu email de piloto..." required>
                <button type="submit" class="btn-primary-f1">Acelerar</button>
            </form>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Scroll animations
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

        // Counter animation
        function animateCounters() {
            const counters = document.querySelectorAll('.stat-number');

            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target'));
                const increment = target / 100;
                let current = 0;

                const updateCounter = () => {
                    if (current < target) {
                        current += increment;
                        counter.textContent = Math.ceil(current);
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = target;
                    }
                };

                updateCounter();
            });
        }

        // Trigger counter animation when stats section is visible
        const statsSection = document.querySelector('.stats-section');
        if (statsSection) {
            const statsObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateCounters();
                        statsObserver.unobserve(entry.target);
                    }
                });
            });

            statsObserver.observe(statsSection);
        }

        // Parallax effect for hero background only
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const heroBackground = document.querySelector('.hero-section::before');
            const heroSection = document.querySelector('.hero-section');

            if (heroSection) {
                // Solo aplicar parallax al pseudo-elemento de fondo
                heroSection.style.setProperty('--scroll-offset', scrolled * 0.3 + 'px');
            }
        });

        // Aplicar el parallax usando CSS custom properties
        const style = document.createElement('style');
        style.textContent = `
        .hero-section::before {
            transform: translateY(var(--scroll-offset, 0));
        }
    `;
        document.head.appendChild(style);

        // Newsletter form handling
        const newsletterForm = document.querySelector('.newsletter-form');
        if (newsletterForm) {
            newsletterForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const email = this.querySelector('input[name="email"]').value;
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;

                // Show loading state
                submitBtn.textContent = 'Procesando...';
                submitBtn.disabled = true;

                // Simulate form submission (aquí puedes agregar tu lógica real)
                setTimeout(() => {
                    // Mostrar mensaje de éxito usando Toastify (ya incluido en tu layout)
                    if (typeof Toastify !== 'undefined') {
                        Toastify({
                            text: "¡Gracias por suscribirte al Paddock VIP!",
                            duration: 3000,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "linear-gradient(to right, #FF1801, #FFD700)",
                        }).showToast();
                    } else {
                        alert('¡Gracias por suscribirte al Paddock VIP!');
                    }

                    this.reset();
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                }, 1500);
            });
        }
    });
</script>
@endsection