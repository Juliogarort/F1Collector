<footer class="racing-footer">
<link rel="stylesheet" href="{{ asset('css/footer.css') }}">

    <!-- Decoradores visuales -->
    <div class="footer-speed-line"></div>
    <div class="footer-accent-corner top-left"></div>
    <div class="footer-accent-corner top-right"></div>
    
    <div class="container">
        <div class="row footer-main">
            <!-- Logo y descripción -->
            <div class="col-lg-4 col-md-6 mb-5 mb-lg-0 footer-brand">
                <div class="brand-wrapper">
                    <a href="{{ url('/') }}" class="footer-logo">
                        <img src="{{ asset('images/ferrari.webp') }}" alt="Logo F1Collector" class="logo img-fluid">
                        <span class="sr-only">F1Collector</span>
                    </a>
                    <div class="brand-line"></div>
                </div>
                <p class="brand-description">
                    Tu destino premium para coleccionables de Fórmula 1. Seleccionamos cada pieza con pasión, 
                    garantizando calidad y exclusividad para los verdaderos aficionados.
                </p>
                
                <!-- Newsletter simple -->
                <div class="newsletter-compact">
                    <h6 class="newsletter-title">Mantente al día</h6>
                    <form action="#" method="post" class="newsletter-form">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Tu email" aria-label="Tu email" required>
                            <button class="btn btn-racing-subscribe" type="submit">
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Enlaces rápidos y navegación principal -->
            <div class="col-lg-4 col-md-6 mb-5 mb-lg-0 footer-links">
                <div class="links-wrapper">
                    <h5 class="footer-heading">Enlaces Rápidos</h5>
                    <div class="row">
                        <div class="col-6">
                            <ul class="footer-nav">
                                <li><a href="{{ url('/') }}"><span class="nav-dot"></span>Inicio</a></li>
                                <li><a href="{{ url('/catalogo') }}"><span class="nav-dot"></span>Catálogo</a></li>
                                <li><a href="{{ url('/contacto') }}"><span class="nav-dot"></span>Contacto</a></li>
                                <li><a href="{{ url('/nosotros') }}"><span class="nav-dot"></span>Nosotros</a></li>
                            </ul>
                        </div>
                        <div class="col-6">
                            <ul class="footer-nav">
                                <li><a href="#"><span class="nav-dot"></span>Novedades</a></li>
                                <li><a href="#"><span class="nav-dot"></span>Ofertas</a></li>
                                <li><a href="#"><span class="nav-dot"></span>Blog</a></li>
                                <li><a href="#"><span class="nav-dot"></span>FAQ</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contacto y redes sociales -->
            <div class="col-lg-4 col-md-12 footer-contact">
                <h5 class="footer-heading">Contáctanos</h5>
                <ul class="contact-list">
                    <li>
                        <div class="contact-icon"><i class="bi bi-envelope-fill"></i></div>
                        <div class="contact-info">
                            <span class="contact-label">Email</span>
                            <span class="contact-text">info@f1collector.com</span>
                        </div>
                    </li>
                    <li>
                        <div class="contact-icon"><i class="bi bi-telephone-fill"></i></div>
                        <div class="contact-info">
                            <span class="contact-label">Teléfono</span>
                            <span class="contact-text">+123 456 7890</span>
                        </div>
                    </li>
                    <li>
                        <div class="contact-icon"><i class="bi bi-geo-alt-fill"></i></div>
                        <div class="contact-info">
                            <span class="contact-label">Dirección</span>
                            <span class="contact-text">Av. Speed, 123, Ciudad F1</span>
                        </div>
                    </li>
                </ul>
                
                <!-- Redes sociales -->
                <div class="social-area">
                    <h6 class="social-title">Síguenos</h6>
                    <div class="social-links">
                        <a href="#" aria-label="Facebook" class="social-icon">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" aria-label="Twitter" class="social-icon">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="#" aria-label="Instagram" class="social-icon">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" aria-label="YouTube" class="social-icon">
                            <i class="bi bi-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer inferior con copyright y enlaces legales -->
        <div class="footer-bottom">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="copyright">© {{ date('Y') }} F1Collector. Todos los derechos reservados.</p>
                </div>
                <div class="col-md-6">
                    <div class="legal-links text-center text-md-end">
                        <a href="#">Privacidad</a>
                        <a href="#">Términos</a>
                        <a href="#">Cookies</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Decorador inferior -->
    <div class="footer-accent-corner bottom-left"></div>
    <div class="footer-accent-corner bottom-right"></div>
</footer>