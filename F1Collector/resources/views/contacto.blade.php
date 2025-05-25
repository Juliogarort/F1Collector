@extends('layouts.app')

@section('title', 'F1 Collector - Contacto')

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
    .contact-hero-section {
        height: 70vh;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .contact-hero-section::before {
        content: '';
        position: absolute;
        top: -20%;	
        left: 0;
        width: 100%;
        height: 120%;
        background-image: url('/images/contacto/circuito.jpg');
        background-position: center;
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
        font-size: clamp(2.5rem, 6vw, 4rem);
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

    /* Section Styling */
    .contact-section {
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

    /* Form Section */
    .form-section {
        background: linear-gradient(180deg, var(--f1-dark) 0%, var(--f1-carbon) 100%);
    }

    .contact-form-container {
        background: linear-gradient(145deg, rgba(255, 24, 1, 0.05), rgba(0, 0, 0, 0.3));
        border: 1px solid rgba(255, 24, 1, 0.2);
        border-radius: 20px;
        padding: 40px;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
    }

    .contact-form-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transition: left 0.6s;
    }

    .contact-form-container:hover::before {
        left: 100%;
    }

    .contact-form-container:hover {
        border-color: var(--f1-red);
        box-shadow: 0 25px 50px rgba(255, 24, 1, 0.3);
    }

    .form-intro {
        color: var(--f1-silver);
        font-size: 1.1rem;
        line-height: 1.6;
        margin-bottom: 2rem;
        text-align: center;
    }

    .form-group label {
        font-family: 'Orbitron', monospace;
        font-weight: 600;
        color: var(--f1-gold);
        margin-bottom: 8px;
        text-transform: uppercase;
        font-size: 0.9rem;
        letter-spacing: 0.5px;
    }

    .form-control,
    .form-select {
        background: rgba(255, 255, 255, 0.05);
        border: 2px solid rgba(255, 24, 1, 0.3);
        border-radius: 10px;
        padding: 15px;
        font-size: 1rem;
        color: white;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        background: rgba(255, 255, 255, 0.1);
        border-color: var(--f1-red);
        box-shadow: 0 0 0 0.25rem rgba(255, 24, 1, 0.25);
        color: white;
    }

    .form-control::placeholder {
        color: var(--f1-silver);
        opacity: 0.7;
    }

    .form-select option {
        background: var(--f1-carbon);
        color: white;
    }

    .form-check-input {
        width: 1.2em;
        height: 1.2em;
        border: 2px solid rgba(255, 24, 1, 0.3);
        border-radius: 4px;
        background: transparent;
    }

    .form-check-input:checked {
        background-color: var(--f1-red);
        border-color: var(--f1-red);
    }

    .form-check-input:focus {
        border-color: var(--f1-red);
        box-shadow: 0 0 0 0.25rem rgba(255, 24, 1, 0.25);
    }

    .form-check-label {
        color: var(--f1-silver);
        font-size: 0.95rem;
        line-height: 1.4;
    }

    .btn-primary-f1 {
        background: var(--gradient-primary);
        border: none;
        padding: 15px 40px;
        border-radius: 50px;
        color: white;
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
        background: var(--gradient-secondary);
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(255, 24, 1, 0.4);
        color: white;
    }

    /* Info Section */
    .info-section {
        background: var(--gradient-primary);
    }

    .contact-info-container {
        background: linear-gradient(145deg, rgba(255, 255, 255, 0.05), rgba(0, 0, 0, 0.3));
        border: 1px solid rgba(255, 24, 1, 0.2);
        border-radius: 20px;
        padding: 40px;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
        height: 100%;
    }

    .contact-info-container:hover {
        border-color: var(--f1-gold);
        box-shadow: 0 25px 50px rgba(255, 215, 0, 0.3);
    }

    .contact-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
        margin-top: 40px;
    }

    .contact-info-item {
        background: linear-gradient(145deg, rgba(255, 24, 1, 0.05), rgba(0, 0, 0, 0.3));
        border: 1px solid rgba(255, 24, 1, 0.2);
        border-radius: 15px;
        padding: 25px;
        text-align: center;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
    }

    .contact-info-item:hover {
        transform: translateY(-10px);
        border-color: var(--f1-red);
        box-shadow: 0 20px 40px rgba(255, 24, 1, 0.3);
    }

    .contact-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: var(--gradient-secondary);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 1.5rem;
        color: white;
        transition: transform 0.3s ease;
    }

    .contact-info-item:hover .contact-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .contact-info-item h3 {
        font-family: 'Orbitron', monospace;
        color: white;
        font-size: 1.2rem;
        margin-bottom: 10px;
        text-transform: uppercase;
    }

    .contact-info-item p {
        color: var(--f1-silver);
        font-size: 0.95rem;
        line-height: 1.5;
        margin: 0;
    }

    .contact-info-item a {
        color: var(--f1-gold);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .contact-info-item a:hover {
        color: var(--f1-red);
        text-decoration: underline;
    }

    /* Social Media */
    .social-section {
        background: var(--f1-dark);
        text-align: center;
    }

    .social-icons {
        display: flex;
        justify-content: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .social-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(145deg, rgba(255, 24, 1, 0.05), rgba(0, 0, 0, 0.3));
        border: 2px solid rgba(255, 24, 1, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--f1-red);
        font-size: 1.5rem;
        text-decoration: none;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
    }

    .social-icon::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: var(--gradient-secondary);
        transition: left 0.4s;
        z-index: -1;
    }

    .social-icon:hover::before {
        left: 0;
    }

    .social-icon:hover {
        color: white;
        border-color: var(--f1-gold);
        transform: scale(1.1) translateY(-5px);
        box-shadow: 0 15px 35px rgba(255, 24, 1, 0.4);
    }

    /* Map Section */
    .map-section {
        background: linear-gradient(180deg, var(--f1-carbon) 0%, var(--f1-dark) 100%);
    }

    .map-search-container {
        margin-bottom: 40px;
    }

    .map-search-container .input-group {
        border-radius: 50px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .map-search-container .form-control {
        border: none;
        padding: 15px 25px;
        font-size: 1rem;
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border-radius: 50px 0 0 50px;
    }

    .map-search-container .form-control::placeholder {
        color: var(--f1-silver);
    }

    .map-search-container .btn {
        border-radius: 0 50px 50px 0;
        padding: 15px 30px;
        border: none;
    }

    .map-container {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
        border: 2px solid rgba(255, 24, 1, 0.3);
        transition: all 0.4s ease;
    }

    .map-container:hover {
        border-color: var(--f1-red);
        box-shadow: 0 30px 60px rgba(255, 24, 1, 0.3);
    }

    /* FAQ Section */
    .faq-section {
        background: var(--gradient-primary);
    }

    .accordion {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .accordion-item {
        border: none;
        background: transparent;
    }

    .accordion-button {
        background: rgba(255, 255, 255, 0.05);
        border: none;
        padding: 25px 30px;
        color: white;
        font-family: 'Orbitron', monospace;
        font-weight: 600;
        font-size: 1.1rem;
        box-shadow: none;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .accordion-button:not(.collapsed) {
        background: var(--gradient-secondary);
        color: white;
        box-shadow: none;
    }

    .accordion-button:focus {
        border-color: var(--f1-red);
        box-shadow: 0 0 0 0.25rem rgba(255, 24, 1, 0.25);
    }

    .accordion-button::after {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23ffffff'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
    }

    .accordion-body {
        padding: 25px 30px;
        color: black;
        line-height: 1.6;
        font-size: 1rem;
        background: rgba(0, 0, 0, 0.2);
    }

    /* CTA Section */
    .cta-section {
        background: var(--f1-carbon);

        text-align: center;
    }

    .cta-content {
        background: linear-gradient(145deg, rgba(255, 24, 1, 0.05), rgba(0, 0, 0, 0.3));
        border: 1px solid rgba(255, 24, 1, 0.2);
        border-radius: 20px;
        padding: 50px;
        backdrop-filter: blur(10px);
        position: relative;
        overflow: hidden;
    }

    .cta-content::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transition: left 0.6s;
    }

    .cta-content:hover::before {
        left: 100%;
    }

    .cta-content h2 {
        font-family: 'Orbitron', monospace;
        font-weight: 700;
        font-size: 2rem;
        margin-bottom: 15px;
        color: white;
        text-transform: uppercase;
    }

    .cta-content p {
        font-size: 1.1rem;
        color: var(--f1-silver);
        margin-bottom: 2rem;
    }

    /* Alerts */
    .contact-alert {
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 30px;
        border: none;
        backdrop-filter: blur(10px);
    }

    .alert-success {
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.2), rgba(40, 167, 69, 0.1));
        color: #d4edda;
        border: 1px solid rgba(40, 167, 69, 0.3);
    }

    .alert-danger {
        background: linear-gradient(135deg, rgba(255, 24, 1, 0.2), rgba(255, 24, 1, 0.1));
        color: #f8d7da;
        border: 1px solid rgba(255, 24, 1, 0.3);
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
        .contact-hero-section {
            height: 60vh;
        }

        .hero-title {
            font-size: 2.5rem;
        }

        .hero-subtitle {
            font-size: 1.1rem;
        }

        .section-title {
            font-size: 2rem;
        }

        .contact-section {
            padding: 60px 0;
        }

        .contact-form-container,
        .contact-info-container,
        .cta-content {
            padding: 30px 25px;
        }

        .contact-info-grid {
            grid-template-columns: 1fr;
        }

        .social-icons {
            gap: 15px;
        }

        .social-icon {
            width: 50px;
            height: 50px;
            font-size: 1.2rem;
        }
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="contact-hero-section">
    <div class="floating-car"><i class="fas fa-envelope"></i></div>
    <div class="floating-car"><i class="fas fa-phone"></i></div>
    <div class="floating-car"><i class="fas fa-map-marker-alt"></i></div>

    <div class="hero-content">
        <h1 class="hero-title">Contacta con Nosotros</h1>
        <p class="hero-subtitle">¿Tienes preguntas sobre nuestros coleccionables o necesitas ayuda? Estamos aquí para ti.</p>

        <div class="speed-indicator">
            <span>RESPUESTA</span>
            <div class="speed-line"></div>
            <span>24H</span>
        </div>
    </div>
</section>

<!-- Form Section -->
<section class="contact-section form-section">
    <div class="container">
        <h2 class="section-title fade-in">Envíanos tu Mensaje</h2>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="contact-form-container fade-in">
                    <p class="form-intro">Estamos listos para responder a tus preguntas y ayudarte a encontrar el coleccionable perfecto. Completa el formulario y nos pondremos en contacto contigo lo antes posible.</p>

                    @if(session('success'))
                    <div class="alert alert-success contact-alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger contact-alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                    </div>
                    @endif

                    <form action="{{ route('contacto.enviar') }}" method="POST" class="contact-form">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="nombre">Nombre Completo</label>
                                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" required placeholder="Tu nombre completo">
                                    @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="email">Correo Electrónico</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required placeholder="tu@email.com">
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="asunto">Asunto</label>
                            <select class="form-select @error('asunto') is-invalid @enderror" id="asunto" name="asunto" required>
                                <option value="" selected disabled>Selecciona un asunto</option>
                                <option value="Información sobre productos" {{ old('asunto') == 'Información sobre productos' ? 'selected' : '' }}>Información sobre productos</option>
                                <option value="Estado de mi pedido" {{ old('asunto') == 'Estado de mi pedido' ? 'selected' : '' }}>Estado de mi pedido</option>
                                <option value="Devoluciones y garantías" {{ old('asunto') == 'Devoluciones y garantías' ? 'selected' : '' }}>Devoluciones y garantías</option>
                                <option value="Colaboraciones" {{ old('asunto') == 'Colaboraciones' ? 'selected' : '' }}>Colaboraciones</option>
                                <option value="Otro" {{ old('asunto') == 'Otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('asunto')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="mensaje">Mensaje</label>
                            <textarea class="form-control @error('mensaje') is-invalid @enderror" id="mensaje" name="mensaje" rows="5" required placeholder="Escribe tu mensaje aquí...">{{ old('mensaje') }}</textarea>
                            @error('mensaje')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input @error('politica') is-invalid @enderror" type="checkbox" id="politica" name="politica" required {{ old('politica') ? 'checked' : '' }}>
                            <label class="form-check-label" for="politica">
                                Acepto la política de privacidad y el tratamiento de mis datos
                            </label>
                            @error('politica')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn-primary-f1">
                                <i class="fas fa-paper-plane me-2"></i>Enviar Mensaje
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Info Section -->
<section class="contact-section info-section">
    <div class="container">
        <h2 class="section-title fade-in">Información de Contacto</h2>

        <div class="contact-info-grid fade-in">
            <div class="contact-info-item">
                <div class="contact-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h3>Nuestra Ubicación</h3>
                <p>Circuito de Barcelona-Catalunya<br>08160 Montmeló, Barcelona, España</p>
            </div>

            <div class="contact-info-item">
                <div class="contact-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <h3>Correo Electrónico</h3>
                <p><a href="mailto:f1.collector12@gmail.com">f1.collector12@gmail.com</a></p>
            </div>

            <div class="contact-info-item">
                <div class="contact-icon">
                    <i class="fas fa-phone"></i>
                </div>
                <h3>Teléfono</h3>
                <p><a href="tel:+34900123456">+34 900 123 456</a></p>
            </div>

            <div class="contact-info-item">
                <div class="contact-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h3>Horario de Atención</h3>
                <p>Lunes a Viernes: 9:00 - 18:00<br>Fin de semana: Cerrado</p>
            </div>
        </div>
    </div>
</section>

<!-- Social Media Section -->
<section class="contact-section social-section">
    <div class="container">
        <h2 class="section-title fade-in">Síguenos en Redes</h2>

        <div class="social-icons fade-in">
            <a href="#" class="social-icon" aria-label="Facebook">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="social-icon" aria-label="Twitter">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="social-icon" aria-label="Instagram">
                <i class="fab fa-instagram"></i>
            </a>
            <a href="#" class="social-icon" aria-label="YouTube">
                <i class="fab fa-youtube"></i>
            </a>
            <a href="#" class="social-icon" aria-label="LinkedIn">
                <i class="fab fa-linkedin-in"></i>
            </a>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="contact-section map-section">
    <div class="container">
        <h2 class="section-title fade-in">Encuéntranos</h2>

        <div class="map-search-container fade-in">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" id="map-search-input" class="form-control" placeholder="Buscar ubicación...">
                        <button class="btn btn-primary-f1" type="button" id="search-button" onclick="searchLocation()">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="map-container fade-in">
            <iframe id="google-map"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2988.4548130938163!2d2.2546080761943215!3d41.57068548586371!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a4b8af789f4acd%3A0xb0a599661c6b66ff!2sCircuito%20de%20Barcelona-Catalunya!5e0!3m2!1ses!2ses!4v1713363321099!5m2!1ses!2ses"
                width="100%"
                height="450"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="contact-section faq-section">
    <div class="container">
        <h2 class="section-title fade-in">Preguntas Frecuentes</h2>

        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="accordion fade-in" id="faqAccordion">
                    <!-- Pregunta 1 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <i class="fas fa-certificate me-3"></i>¿Cómo puedo verificar la autenticidad de mis coleccionables?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Todos nuestros coleccionables vienen con un certificado de autenticidad que incluye un número de serie único. También puedes verificar la autenticidad en nuestra página web introduciendo el código QR o el número de serie en la sección "Verificar Producto".
                            </div>
                        </div>
                    </div>

                    <!-- Pregunta 2 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <i class="fas fa-shipping-fast me-3"></i>¿Realizan envíos internacionales?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Sí, realizamos envíos a más de 50 países. Los tiempos de entrega varían según la ubicación, pero generalmente oscilan entre 3-7 días laborables para Europa y 7-14 días para el resto del mundo. Todos nuestros envíos incluyen seguimiento y seguro.
                            </div>
                        </div>
                    </div>

                    <!-- Pregunta 3 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <i class="fas fa-undo-alt me-3"></i>¿Cuál es su política de devoluciones?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Aceptamos devoluciones dentro de los 30 días posteriores a la recepción del producto, siempre que el artículo se encuentre en su estado original y con todo el embalaje. Los gastos de envío de devolución corren por cuenta del cliente, excepto en casos de productos defectuosos.
                            </div>
                        </div>
                    </div>

                    <!-- Pregunta 4 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                <i class="fas fa-palette me-3"></i>¿Ofrecen productos personalizados?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Sí, ofrecemos servicios de personalización para determinados productos. Puedes solicitar grabados especiales, combinaciones de colores específicas o incluso piezas totalmente personalizadas. Para más información, ponte en contacto con nuestro equipo a través del formulario o por correo electrónico.
                            </div>
                        </div>
                    </div>

                    <!-- Pregunta 5 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                <i class="fas fa-truck me-3"></i>¿Cómo puedo seguir mi pedido?
                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Una vez realizado tu pedido, recibirás un correo electrónico de confirmación con un número de seguimiento. Puedes utilizar este número en la sección "Seguimiento de Pedidos" de nuestra web o directamente en la página del transportista asignado para conocer el estado de tu envío en tiempo real.
                            </div>
                        </div>
                    </div>

                    <!-- Pregunta 6 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSix">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                <i class="fas fa-shield-alt me-3"></i>¿Cómo garantizan la calidad de sus productos?
                            </button>
                        </h2>
                        <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Trabajamos exclusivamente con fabricantes autorizados y realizamos controles de calidad rigurosos. Cada producto pasa por múltiples inspecciones antes del envío. Además, ofrecemos garantía de por vida contra defectos de fabricación en todos nuestros coleccionables premium.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="contact-section cta-section">
    <div class="container">
        <div class="cta-content fade-in">
            <h2>¿No encuentras lo que buscas?</h2>
            <p>Explora nuestro catálogo premium o ponte en contacto con nosotros para ayudarte a encontrar ese coleccionable especial que buscas.</p>
            <a href="{{ route('catalogo') }}" class="btn-primary-f1">
                <i class="fas fa-rocket me-2"></i>Ver Catálogo
            </a>
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
            const heroSection = document.querySelector('.contact-hero-section');

            if (heroSection) {
                heroSection.style.setProperty('--scroll-offset', scrolled * 0.3 + 'px');
            }
        });

        // Apply parallax using CSS custom properties
        const style = document.createElement('style');
        style.textContent = `
        .contact-hero-section::before {
            transform: translateY(var(--scroll-offset, 0));
        }
    `;
        document.head.appendChild(style);

        // Map search functionality
        window.searchLocation = function() {
            const searchInput = document.getElementById('map-search-input').value;
            if (searchInput.trim() !== '') {
                window.open(`https://www.google.com/maps/search/${encodeURIComponent(searchInput)}`, '_blank');
            }
        }

        // Allow search with Enter key
        document.getElementById('map-search-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchLocation();
            }
        });

        // Enhanced form interactions
        const formElements = document.querySelectorAll('.form-control, .form-select');
        formElements.forEach(element => {
            element.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });

            element.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });

        // Submit button animation
        const submitBtn = document.querySelector('.btn-primary-f1');
        if (submitBtn) {
            submitBtn.addEventListener('click', function() {
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            });
        }

        // Contact info items hover effects
        const contactItems = document.querySelectorAll('.contact-info-item');
        contactItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                const icon = this.querySelector('.contact-icon');
                if (icon) {
                    icon.style.transform = 'scale(1.1) rotate(5deg)';
                }
            });

            item.addEventListener('mouseleave', function() {
                const icon = this.querySelector('.contact-icon');
                if (icon) {
                    icon.style.transform = 'scale(1) rotate(0deg)';
                }
            });
        });

        // Accordion button animations
        const accordionButtons = document.querySelectorAll('.accordion-button');
        accordionButtons.forEach(button => {
            button.addEventListener('click', function() {
                const icon = this.querySelector('i');
                if (icon) {
                    icon.style.transform = 'rotate(360deg)';
                    setTimeout(() => {
                        icon.style.transform = '';
                    }, 300);
                }
            });
        });

        // Enhanced form validation
        const form = document.querySelector('.contact-form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('is-invalid');
                        field.addEventListener('input', function() {
                            this.classList.remove('is-invalid');
                        }, {
                            once: true
                        });
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    const firstInvalid = form.querySelector('.is-invalid');
                    if (firstInvalid) {
                        firstInvalid.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        firstInvalid.focus();
                    }
                }
            });
        }

        // Character counter for textarea
        const messageTextarea = document.getElementById('mensaje');
        if (messageTextarea) {
            const maxLength = 1000;
            const counter = document.createElement('div');
            counter.className = 'text-muted small mt-1 text-end';
            counter.style.color = 'var(--f1-silver)';
            counter.innerHTML = `<span id="char-count">0</span>/${maxLength} caracteres`;
            messageTextarea.parentElement.appendChild(counter);

            messageTextarea.addEventListener('input', function() {
                const charCount = this.value.length;
                document.getElementById('char-count').textContent = charCount;

                if (charCount > maxLength * 0.9) {
                    counter.style.color = 'var(--f1-gold)';
                } else {
                    counter.style.color = 'var(--f1-silver)';
                }
            });
        }

        // Social icons enhanced hover effects
        const socialIcons = document.querySelectorAll('.social-icon');
        socialIcons.forEach(icon => {
            icon.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.1) translateY(-5px) rotate(5deg)';
            });

            icon.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1) translateY(0) rotate(0deg)';
            });
        });

        // Map container hover effect
        const mapContainer = document.querySelector('.map-container');
        if (mapContainer) {
            mapContainer.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.02)';
            });

            mapContainer.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        }
    });
</script>
@endsection