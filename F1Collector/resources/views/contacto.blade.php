@extends('layouts.app')

@section('title', 'F1 Collector - Contacto')

@section('content')
<link rel="stylesheet" href="{{ asset('css/contacto.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">

<div class="contact-page">
    <!-- Banner principal -->
    <div class="contact-banner">
        <div class="banner-content container">
            <div class="row">
                <div class="col-lg-8 col-md-10 mx-auto text-center">
                    <h1 class="display-3 banner-title">Contacta con Nosotros</h1>
                    <p class="lead banner-subtitle">¿Tienes preguntas sobre nuestros coleccionables o necesitas ayuda? Estamos aquí para ti.</p>
                    <div class="racing-line mt-4 mx-auto"></div>
                </div>
            </div>
        </div>
        <div class="banner-overlay"></div>
    </div>

    <!-- Sección: Formulario de Contacto -->
    <section class="contact-section form-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="section-title-container">
                        <h2 class="section-title">Envíanos tu Mensaje</h2>
                        <div class="speed-line"></div>
                    </div>
                    <p class="contact-intro">Estamos listos para responder a tus preguntas y ayudarte a encontrar el coleccionable perfecto. Completa el formulario y nos pondremos en contacto contigo lo antes posible.</p>

                    @if(session('success'))
                    <div class="alert alert-success contact-alert">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger contact-alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                    </div>
                    @endif

                    <form action="{{ route('contacto.enviar') }}" method="POST" class="contact-form">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="nombre">Nombre Completo</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                            @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                            <textarea class="form-control @error('mensaje') is-invalid @enderror" id="mensaje" name="mensaje" rows="5" required>{{ old('mensaje') }}</textarea>
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
                            <button type="submit" class="btn btn-racing-primary">
                                <i class="bi bi-send-fill me-2"></i>Enviar Mensaje
                            </button>
                        </div>
                    </form>
                </div>

                <div class="col-lg-6">
                    <div class="contact-info-container">
                        <div class="section-title-container">
                            <h2 class="section-title">Información de Contacto</h2>
                            <div class="speed-line"></div>
                        </div>

                        <div class="contact-info-items">
                            <div class="contact-info-item">
                                <div class="contact-icon">
                                    <i class="bi bi-geo-alt-fill"></i>
                                </div>
                                <div class="contact-text">
                                    <h3>Nuestra Ubicación</h3>
                                    <p>Circuito de Barcelona-Catalunya<br>08160 Montmeló, Barcelona, España</p>
                                </div>
                            </div>

                            <div class="contact-info-item">
                                <div class="contact-icon">
                                    <i class="bi bi-envelope-fill"></i>
                                </div>
                                <div class="contact-text">
                                    <h3>Correo Electrónico</h3>
                                    <p><a href="mailto:f1.collector12@gmail.com">f1.collector12@gmail.com</a></p>
                                </div>
                            </div>

                            <div class="contact-info-item">
                                <div class="contact-icon">
                                    <i class="bi bi-telephone-fill"></i>
                                </div>
                                <div class="contact-text">
                                    <h3>Teléfono</h3>
                                    <p><a href="tel:+34900123456">+34 900 123 456</a></p>
                                </div>
                            </div>

                            <div class="contact-info-item">
                                <div class="contact-icon">
                                    <i class="bi bi-clock-fill"></i>
                                </div>
                                <div class="contact-text">
                                    <h3>Horario de Atención</h3>
                                    <p>Lunes a Viernes: 9:00 - 18:00<br>Fin de semana: Cerrado</p>
                                </div>
                            </div>
                        </div>

                        <div class="social-media-container">
                            <h3>Síguenos en Redes</h3>
                            <div class="social-icons">
                                <a href="#" class="social-icon" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                                <a href="#" class="social-icon" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
                                <a href="#" class="social-icon" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                                <a href="#" class="social-icon" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                                <a href="#" class="social-icon" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<!-- Sección: Mapa -->
<section class="contact-section map-section">
    <div class="container mb-3">
        <!-- Barra de búsqueda -->
        <div class="map-search-container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" id="map-search-input" class="form-control" placeholder="Buscar ubicación...">
                        <button class="btn btn-racing-primary" type="button" id="search-button" onclick="searchLocation()">
                            <i class="bi bi-search"></i> Buscar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-fluid p-0">
        <div class="map-container">
            <iframe id="google-map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2988.4548130938163!2d2.2546080761943215!3d41.57068548586371!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12a4b8af789f4acd%3A0xb0a599661c6b66ff!2sCircuito%20de%20Barcelona-Catalunya!5e0!3m2!1ses!2ses!4v1713363321099!5m2!1ses!2ses" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            <div class="map-overlay"></div>
        </div>
    </div>
</section>

    <!-- Sección: FAQ -->
    <section class="contact-section faq-section">
        <div class="container">
            <div class="section-title-container text-center mb-5">
                <h2 class="section-title">Preguntas Frecuentes</h2>
                <div class="speed-line mx-auto"></div>
            </div>

            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="accordion" id="faqAccordion">
                        <!-- Pregunta 1 -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    ¿Cómo puedo verificar la autenticidad de mis coleccionables?
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
                                    ¿Realizan envíos internacionales?
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
                                    ¿Cuál es su política de devoluciones?
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
                                    ¿Ofrecen productos personalizados?
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
                                    ¿Cómo puedo seguir mi pedido?
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Una vez realizado tu pedido, recibirás un correo electrónico de confirmación con un número de seguimiento. Puedes utilizar este número en la sección "Seguimiento de Pedidos" de nuestra web o directamente en la página del transportista asignado para conocer el estado de tu envío en tiempo real.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección CTA -->
    <section class="contact-section cta-section">
        <div class="container">
            <div class="cta-container">
                <div class="row align-items-center">
                    <div class="col-lg-8 col-md-7">
                        <h2>¿No encuentras lo que buscas?</h2>
                        <p>Explora nuestro catálogo o ponte en contacto con nosotros para ayudarte a encontrar ese coleccionable especial que buscas.</p>
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

<script>

function searchLocation() {
    const searchInput = document.getElementById('map-search-input').value;
    if (searchInput.trim() !== '') {
        window.open(`https://www.google.com/maps/search/${encodeURIComponent(searchInput)}`, '_blank');
    }
}

</script>
