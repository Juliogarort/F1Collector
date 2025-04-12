<header class="racing-header">

    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <script src="{{ asset('js/header.js') }}" defer></script>
    <nav class="navbar navbar-expand-lg navbar-dark shadow">
        <div class="container">
            <!-- Logo -->
            @if(Auth::check() && Auth::user()->email === 'admin@example.com')
            <a class="navbar-brand disabled" href="#">
                <img src="{{ asset('images/logoferrari.png') }}" class="logo img-fluid" alt="Logo F1Collector">
            </a>
            @else
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/logoferrari.png') }}" class="logo img-fluid" alt="Logo F1Collector">
            </a>
            @endif

            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Menu Items -->
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link px-3 text-black" href="{{ url('/') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 text-black" href="{{ route('catalogo') }}">Catálogo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 text-black" href="{{ url('/contacto') }}">Contacto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 text-black" href="{{ url('/nosotros') }}">Sobre Nosotros</a>
                    </li>
                </ul>

                <!-- User Actions -->
                <div class="d-flex align-items-center ms-auto user-actions">
                    @auth
                    <span class="welcome-text me-3">Bienvenido, {{ Auth::user()->name }}</span>
                    @endauth

                    <!-- Action Buttons -->
                    @auth
                    <a href="{{ route('wishlist.index') }}" class="btn btn-racing btn-wishlist me-2" title="Lista de deseos">
                        <i class="bi bi-heart-fill"></i>
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="btn btn-racing btn-wishlist me-2" title="Lista de deseos">
                        <i class="bi bi-heart-fill"></i>
                    </a>
                    @endauth

                    <a href="{{ url('/cart') }}" class="btn btn-racing btn-cart me-2" title="Carrito">
                        <i class="bi bi-cart-fill"></i>
                    </a>

                    @auth
                    <a href="{{ route('profile.index') }}" class="btn btn-racing btn-profile me-2" title="Perfil">
                        <i class="bi bi-gear-fill"></i>
                    </a>
                    <a href="{{ route('logout') }}" class="btn btn-racing btn-logout"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Cerrar sesión">
                        <i class="bi bi-box-arrow-right"></i>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    @else
                    <button class="btn btn-racing btn-login me-2" id="openLoginModal">
                        <i class="bi bi-box-arrow-in-right"></i> Iniciar sesión
                    </button>
                    <button class="btn btn-racing btn-register" id="openRegisterModal">
                        <i class="bi bi-person-plus-fill"></i> Registrarse
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </nav>
</header>

<!-- Modales -->
<!-- Versión mejorada del modal de inicio de sesión -->
<div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content racing-modal">
            <div class="modal-header">
                <h5 class="modal-title">Iniciar sesión</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Opcional: Alerta para errores -->
                <div class="alert" style="display: none;"></div>
                
                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf
                    <div class="mb-3">
                        <label for="loginEmail" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="loginEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="loginPassword" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="loginPassword" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-racing-primary w-100">Entrar</button>
                </form>
                <!-- El script añadirá automáticamente el enlace de "olvidaste contraseña" y el divisor -->
            </div>
        </div>
    </div>
</div>

<!-- Versión mejorada del modal de registro -->
<div class="modal fade" id="registerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content racing-modal">
            <div class="modal-header">
                <h5 class="modal-title">Registro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Opcional: Alerta para errores -->
                <div class="alert" style="display: none;"></div>
                
                <form method="POST" action="{{ route('register') }}" id="registerForm">
                    @csrf
                    <div class="mb-3">
                        <label for="registerName" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="registerName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="registerEmail" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="registerEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="registerPassword" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="registerPassword" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="registerPassword_confirmation" class="form-label">Confirmar contraseña</label>
                        <input type="password" class="form-control" id="registerPassword_confirmation" name="password_confirmation" required>
                    </div>
                    <button type="submit" class="btn btn-racing-primary w-100">Registrarse</button>
                </form>
                <!-- El script añadirá automáticamente el divisor y el enlace para cambiar de modal -->
            </div>
        </div>
    </div>
</div>