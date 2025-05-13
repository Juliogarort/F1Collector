@extends('layouts.app')

@section('title', 'F1 Collector - Inicio')

@section('content')
<link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">

<!-- puntero personalizao 
<div id="custom-f1-cursor">
    <img src="{{ asset('images/puntero.png') }}" alt="F1 Cursor">
</div>  -->
<div class="welcome-page">
    <!-- Hero Banner -->
    <div class="hero-banner">
        <div class="banner-content container">
            <div class="row align-items-center">
                <div class="col-lg-7 text-center text-lg-start">
                    <h1 class="display-4 banner-title">F1 COLLECTOR</h1>
                    <div class="speed-line mb-4"></div>
                    <p class="lead banner-subtitle">
                        Descubre la pasión de la Fórmula 1 con nuestra exclusiva colección de modelos a escala, capturando la esencia de los monoplazas más emblemáticos de la historia.
                    </p>
                    <div class="d-flex justify-content-center justify-content-lg-start gap-3">
                        <a href="{{ route('catalogo') }}" class="btn btn-racing-primary">Explorar Catálogo</a>
                        <a href="{{ route('catalogo') }}" class="btn btn-racing-secondary">Nuestra Colección</a>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-block">
                    <div class="hero-image-container">
                        <img src="{{ asset('images/coleccion.webp') }}" class="img-fluid" alt="Modelo F1">
                        <div class="carbon-fiber-overlay"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="banner-overlay"></div>
    </div>

<!-- Sección Interactiva de Experiencia F1 -->
<section class="interactive-experience-section">
    <div class="container">
        
        <div class="section-title-container text-center mb-5">
            <h2 class="section-title">La Experiencia F1</h2>
            <div class="speed-line mx-auto"></div>
        </div>
        
        <div class="experience-container">
            <div class="racing-line"></div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="experience-card" data-card="1">
                        <div class="experience-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div class="experience-content">
                            <h3>Modelos Auténticos</h3>
                            <p>Réplicas precisas certificadas por los equipos oficiales de Fórmula 1</p>
                        </div>
                        <div class="glow-effect"></div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="experience-card" data-card="2">
                        <div class="experience-icon">
                            <i class="fas fa-medal"></i>
                        </div>
                        <div class="experience-content">
                            <h3>Ediciones Limitadas</h3>
                            <p>Coleccionables exclusivos numerados y con certificado de autenticidad</p>
                        </div>
                        <div class="glow-effect"></div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="experience-card" data-card="3">
                        <div class="experience-icon">
                            <i class="fas fa-car"></i>
                        </div>
                        <div class="experience-content">
                            <h3>Calidad Premium</h3>
                            <p>Fabricados con materiales de alta precisión y detalles meticulosos</p>
                        </div>
                        <div class="glow-effect"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

    <!-- Sección de Modelos Destacados -->
    <section class="featured-models-section">
        <div class="container">
            <div class="section-title-container text-center mb-5">
                <h2 class="section-title">Modelos Destacados</h2>
                <div class="speed-line mx-auto"></div>
                <p class="section-subtitle">Nuestra selección de los modelos más exclusivos</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="model-card">
                        <div class="model-image">
                            <img src="{{ asset('images/ferrari.webp') }}" class="img-fluid" alt="Ferrari SF-75">
                            <div class="model-overlay"></div>
                        </div>
                        <div class="model-info">
                            <h3>Ferrari SF-75</h3>
                            <p>Edición conmemorativa del monoplaza de Charles Leclerc</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="model-price">$249.99</span>
                                <a href="#" class="btn btn-racing-outline">Detalles</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="model-card">
                        <div class="model-image">
                            <img src="{{ asset('images/redbull.webp') }}" class="img-fluid" alt="Red Bull RB18">
                            <div class="model-overlay"></div>
                        </div>
                        <div class="model-info">
                            <h3>Red Bull RB18</h3>
                            <p>Modelo del campeonato de Max Verstappen</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="model-price">$279.99</span>
                                <a href="#" class="btn btn-racing-outline">Detalles</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="model-card">
                        <div class="model-image">
                            <img src="{{ asset('images/mercedes.webp') }}" class="img-fluid" alt="Mercedes W13">
                            <div class="model-overlay"></div>
                        </div>
                        <div class="model-info">
                            <h3>Mercedes W13</h3>
                            <p>Réplica del monoplaza de George Russell</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="model-price">$259.99</span>
                                <a href="#" class="btn btn-racing-outline">Detalles</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de Newsletter (CTA) -->
    <section class="newsletter-section">
        <div class="container">
            <div class="cta-container">
                <div class="row justify-content-center text-center">
                    <div class="col-lg-8">
                        <h2>¡No Te Pierdas Ninguna Vuelta!</h2>
                        <p>Suscríbete a nuestro newsletter y recibe información exclusiva sobre nuevos modelos y ofertas especiales</p>
                        
                        <form class="row g-3 justify-content-center mt-4">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="email" class="form-control" placeholder="Tu correo electrónico" required>
                                    <button class="btn btn-racing-primary" type="submit">Suscribirse</button>
                                </div>
                            </div>
                        </form>
                    </div>
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
document.addEventListener('DOMContentLoaded', function() {
    // Cursor personalizado para toda la página
    const customCursor = document.getElementById('custom-f1-cursor');
    const body = document.body;
    let isHoveringClickable = false;
    
    // Verificar si estamos en dispositivo móvil
    const isMobile = window.innerWidth < 768;
    
    if (!isMobile && customCursor) {
        // Añadir clase para ocultar el cursor normal
        body.classList.add('custom-cursor');
        
        // Mostrar el cursor personalizado y seguir el ratón
        document.addEventListener('mousemove', function(e) {
            customCursor.style.opacity = '1';
            customCursor.style.left = e.clientX + 'px';
            customCursor.style.top = e.clientY + 'px';
            
            // Efecto de rotación basado en la velocidad del movimiento
            const speed = Math.sqrt(e.movementX * e.movementX + e.movementY * e.movementY);
            const rotation = speed * 2; // Ajustar para cambiar la intensidad
            const direction = e.movementX > 0 ? 1 : -1;
            
            // Limitar la rotación máxima
            const maxRotation = 25;
            const finalRotation = Math.min(rotation, maxRotation) * direction;
            
            // Aplicar rotación solo si hay movimiento significativo
            if (speed > 1) {
                customCursor.querySelector('img').style.transform = `rotate(${finalRotation}deg)`;
            } else {
                // Volver gradualmente a la posición normal cuando el movimiento es lento
                customCursor.querySelector('img').style.transform = 'rotate(0deg)';
            }
        });
        
        // Detectar cuando el ratón está sobre elementos clickeables
        const clickables = document.querySelectorAll('a, button, .btn, .card, .experience-card, .model-card');
        
        clickables.forEach(element => {
            element.addEventListener('mouseenter', function() {
                isHoveringClickable = true;
                // Añadir efecto al cursor cuando está sobre elemento clickeable
                customCursor.style.transform = 'translate(-50%, -50%) scale(1.2)';
                customCursor.style.filter = 'drop-shadow(0 0 10px rgba(225, 6, 0, 0.8))';
            });
            
            element.addEventListener('mouseleave', function() {
                isHoveringClickable = false;
                // Restaurar el efecto normal
                customCursor.style.transform = 'translate(-50%, -50%) scale(1)';
                customCursor.style.filter = 'none';
            });
        });
        
        // Efecto de "click" en el cursor
        document.addEventListener('mousedown', function() {
            customCursor.style.transform = 'translate(-50%, -50%) scale(0.8)';
        });
        
        document.addEventListener('mouseup', function() {
            if (isHoveringClickable) {
                customCursor.style.transform = 'translate(-50%, -50%) scale(1.2)';
            } else {
                customCursor.style.transform = 'translate(-50%, -50%) scale(1)';
            }
        });
    }

    // Efectos para las tarjetas de experiencia F1
    const experienceCards = document.querySelectorAll('.experience-card');
    
    experienceCards.forEach(card => {
        // Añadir animación al hacer hover
        card.addEventListener('mouseenter', function() {
            this.classList.add('hovered');
            
            // Resaltar la línea de carrera debajo de la tarjeta con brillo
            const racingLine = document.querySelector('.racing-line');
            if (racingLine) {
                racingLine.style.boxShadow = '0 0 30px rgba(225, 6, 0, 0.7)';
            }
        });
        
        card.addEventListener('mouseleave', function() {
            this.classList.remove('hovered');
            
            // Restaurar la línea de carrera
            const racingLine = document.querySelector('.racing-line');
            if (racingLine) {
                racingLine.style.boxShadow = '0 0 20px rgba(225, 6, 0, 0.4)';
            }
        });
    });

    // Animación para la línea de carrera
    const racingLine = document.querySelector('.racing-line');
    if (racingLine) {
        // Añadir efecto de "pulso" cada pocos segundos
        setInterval(() => {
            racingLine.style.boxShadow = '0 0 40px rgba(225, 6, 0, 0.9)';
            
            setTimeout(() => {
                racingLine.style.boxShadow = '0 0 20px rgba(225, 6, 0, 0.4)';
            }, 500);
        }, 4000);
    }
});

    document.addEventListener('DOMContentLoaded', function() {
        // Solo ejecutar en pantallas de tamaño medio o superior
        if (window.innerWidth >= 768) {
            const trackSection = document.querySelector('.interactive-track-section');
            const trackContainer = document.querySelector('.track-interactive-container');
            const customCursor = document.getElementById('custom-cursor');
            const featurePoints = document.querySelectorAll('.feature-point');
            
            let isHoveringPoint = false;
            
            // Mostrar el cursor personalizado solo cuando el ratón está dentro de la sección
            trackSection.addEventListener('mouseenter', function() {
                customCursor.style.opacity = '1';
            });
            
            trackSection.addEventListener('mouseleave', function() {
                customCursor.style.opacity = '0';
            });
            
            // Mover el cursor personalizado con el movimiento del ratón
            document.addEventListener('mousemove', function(e) {
                // Solo actualizar si está visible
                if (customCursor.style.opacity === '1') {
                    customCursor.style.left = e.clientX + 'px';
                    customCursor.style.top = e.clientY + 'px';
                    
                    // Efecto de rotación sutil basado en la velocidad del movimiento
                    const speed = Math.sqrt(e.movementX * e.movementX + e.movementY * e.movementY);
                    const rotation = speed * 2; // Ajustar este multiplicador para cambiar la intensidad
                    const direction = e.movementX > 0 ? 1 : -1;
                    
                    // Limitar la rotación máxima
                    const maxRotation = 35;
                    const finalRotation = Math.min(rotation, maxRotation) * direction;
                    
                    // Aplicar rotación solo si hay movimiento significativo
                    if (speed > 1) {
                        customCursor.querySelector('img').style.transform = `rotate(${finalRotation}deg)`;
                    } else {
                        // Volver gradualmente a la posición normal cuando el movimiento es lento
                        customCursor.querySelector('img').style.transform = 'rotate(0deg)';
                    }
                }
            });
            
            // Detectar cuando el ratón está sobre un punto de característica
            featurePoints.forEach(point => {
                point.addEventListener('mouseenter', function() {
                    isHoveringPoint = true;
                    // Añadir efecto al cursor cuando está sobre un punto
                    customCursor.style.filter = 'drop-shadow(0 0 15px rgba(225, 6, 0, 0.9))';
                    // Aumentar ligeramente el tamaño del cursor
                    customCursor.style.transform = 'translate(-50%, -50%) scale(1.2)';
                });
                
                point.addEventListener('mouseleave', function() {
                    isHoveringPoint = false;
                    // Restaurar el efecto normal
                    customCursor.style.filter = 'drop-shadow(0 0 8px rgba(225, 6, 0, 0.7))';
                    // Restaurar el tamaño normal
                    customCursor.style.transform = 'translate(-50%, -50%) scale(1)';
                });
            });
            
            // Animación adicional para los puntos de característica
            featurePoints.forEach(point => {
                // Aplicar una animación de "flotación" para cada punto
                const marker = point.querySelector('.point-marker');
                
                // Añadir una animación sutil de movimiento
                setInterval(() => {
                    const randomX = Math.random() * 5 - 2.5; // -2.5 a 2.5
                    const randomY = Math.random() * 5 - 2.5; // -2.5 a 2.5
                    
                    marker.style.transform = `translate(${randomX}px, ${randomY}px)`;
                    
                    setTimeout(() => {
                        marker.style.transform = 'translate(0, 0)';
                    }, 500);
                }, 3000);
            });
            
            // Cambiar el cursor normal para los enlaces y elementos clickeables dentro de la sección
            const clickables = trackSection.querySelectorAll('a, button, .point-marker');
            
            clickables.forEach(element => {
                element.style.cursor = 'pointer';
            });
        }
    });
</script>
@endpush