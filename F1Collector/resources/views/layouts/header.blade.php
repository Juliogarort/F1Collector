<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <!-- Logo -->
            @if(Auth::user() && Auth::user()->email === 'admin@example.com')
                <a class="navbar-brand disabled" href="#">
                    {{-- <img src="{{ asset('img/logo.png') }}" class="logo img-fluid" alt="Logo F1Collector" style="max-height: 40px;"> --}}
                </a>
            @else
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{-- <img src="{{ asset('img/logo.png') }}" class="logo img-fluid" alt="Logo F1Collector" style="max-height: 40px;"> --}}
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
                @if(!Auth::user() || Auth::user()->email !== 'admin@example.com')
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link px-3 text-white" href="{{ url('/') }}">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3 text-white" href="{{ route('catalogo') }}">Catálogo</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3 text-white" href="{{ url('/contacto') }}">Contacto</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3 text-white" href="{{ url('/nosotros') }}">Sobre Nosotros</a>
                        </li>
                    </ul>
                @endif

                <!-- User Actions -->
                <div class="d-flex align-items-center ms-auto">
                    @auth
                        <span class="text-white me-3">Bienvenido, {{ Auth::user()->name }}</span>
                    @endauth

                    <!-- Action Buttons -->
                    @if(!Auth::user() || Auth::user()->email !== 'admin@example.com')
                        @auth
                            <a href="{{ route('wishlist.index') }}" class="btn btn-outline-warning me-2" title="Lista de deseos">
                                <i class="bi bi-heart-fill"></i>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-warning me-2" title="Lista de deseos">
                                <i class="bi bi-heart-fill"></i>
                            </a>
                        @endauth

                        <a href="{{ url('/cart') }}" class="btn btn-outline-success me-2" title="Carrito">
                            <i class="bi bi-cart-fill"></i>
                        </a>
                    @endif

                    @auth
                        <a href="{{ route('profile.index') }}" class="btn btn-outline-light me-2" title="Perfil">
                            <i class="bi bi-gear-fill"></i>
                        </a>
                        <a href="{{ route('logout') }}" class="btn btn-outline-danger" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Cerrar sesión">
                            <i class="bi bi-box-arrow-right"></i>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @else
                        <a href="{{ url('/login') }}" class="btn btn-outline-primary" title="Iniciar sesión">
                            <i class="bi bi-person-fill"></i>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
</header>

<!-- Optional CSS for additional styling -->
<style>
    .navbar {
        padding: 1rem 0;
        transition: all 0.3s ease;
    }
    
    .nav-link {
        font-weight: 500;
        position: relative;
    }
    
    .nav-link:hover {
        color: #ffd700 !important; /* Golden hover effect */
    }
    
    .nav-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: -5px;
        left: 0;
        background-color: #ffd700;
        transition: width 0.3s ease;
    }
    
    .nav-link:hover::after {
        width: 100%;
    }
    
    .btn {
        padding: 0.375rem 0.75rem;
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-2px);
    }
</style>