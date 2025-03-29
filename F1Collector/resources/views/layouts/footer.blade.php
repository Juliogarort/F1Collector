<footer class="bg-dark text-white py-5">
    <div class="container">
        <div class="row">
            <!-- Logo y descripción -->
            <div class="col-md-4 mb-4 mb-md-0">
                <a href="{{ url('/') }}" class="d-inline-block mb-3">
                    <img src="{{ asset('img/logo.png') }}" class="img-fluid" alt="Logo F1Collector" style="max-height: 40px;">
                </a>
                <p class="text-muted">
                    F1Collector - Tu destino para coleccionables de Fórmula 1. Calidad, pasión y exclusividad en cada pieza.
                </p>
            </div>

            <!-- Enlaces rápidos -->
            <div class="col-md-4 mb-4 mb-md-0">
                <h5 class="fw-bold mb-3">Enlaces Rápidos</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ url('/') }}" class="text-muted text-decoration-none footer-link">Inicio</a></li>
                    <li><a href="{{ url('/catalogo') }}" class="text-muted text-decoration-none footer-link">Catálogo</a></li>
                    <li><a href="{{ url('/contacto') }}" class="text-muted text-decoration-none footer-link">Contacto</a></li>
                    <li><a href="{{ url('/nosotros') }}" class="text-muted text-decoration-none footer-link">Sobre Nosotros</a></li>
                </ul>
            </div>

            <!-- Contacto y redes sociales -->
            <div class="col-md-4">
                <h5 class="fw-bold mb-3">Contáctanos</h5>
                <ul class="list-unstyled text-muted">
                    <li><i class="bi bi-envelope-fill me-2"></i> info@f1collector.com</li>
                    <li><i class="bi bi-telephone-fill me-2"></i> +123 456 7890</li>
                    <li><i class="bi bi-geo-alt-fill me-2"></i> Av. Speed, 123, Ciudad F1</li>
                </ul>
                <div class="mt-3">
                    <a href="#" class="text-muted me-3 social-link"><i class="bi bi-facebook fs-5"></i></a>
                    <a href="#" class="text-muted me-3 social-link"><i class="bi bi-twitter fs-5"></i></a>
                    <a href="#" class="text-muted me-3 social-link"><i class="bi bi-instagram fs-5"></i></a>
                    <a href="#" class="text-muted social-link"><i class="bi bi-linkedin fs-5"></i></a>
                </div>
            </div>
        </div>

        <!-- Línea divisoria y copyright -->
        <hr class="my-4 border-secondary">
        <div class="text-center text-muted">
            <p>© {{ date('Y') }} F1Collector. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>