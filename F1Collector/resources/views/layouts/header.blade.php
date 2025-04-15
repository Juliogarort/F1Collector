<header class="racing-header">

    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/carrito.css') }}">

    <script src="{{ asset('js/header.js') }}" defer></script>
    <script src="{{ asset('js/carrito.js') }}" ></script>
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

                    <button type="button" class="btn btn-racing btn-cart me-2" title="Carrito">
                        <i class="bi bi-cart-fill"></i>
                    </button>

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

<!-- Modal de registro -->
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

<!-- Modal del carrito -->
<div class="modal fade" id="cartModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content racing-modal">
            <!-- Encabezado del modal -->
            <div class="modal-header border-0 bg-gradient-dark">
                <h5 class="modal-title fw-bold text-danger">
                    <i class="bi bi-cart3 me-2"></i>Mi carrito
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- Cuerpo del modal -->
            <div class="modal-body p-4">
                <div id="cartContent">
                    <!-- Mensaje de carrito vacío -->
                    <div class="text-center py-5" id="emptyCartMessage">
                        <div class="display-1 text-muted mb-3">
                            <i class="bi bi-cart-x"></i>
                        </div>
                        <h4 class="text-muted">Tu carrito está vacío</h4>
                        <p class="text-muted mt-3">Añade artículos al carrito para continuar con tu compra</p>
                        <button type="button" class="btn btn-outline-danger mt-3" data-bs-dismiss="modal">
                            <i class="bi bi-arrow-left me-2"></i>Explorar productos
                        </button>
                    </div>

                    <!-- Lista de productos en el carrito -->
                    <div id="cartItems" class="d-none">
                        <!-- Encabezado de la lista de productos -->
                        <div class="row mb-3 pb-2 border-bottom d-none d-md-flex">
                            <div class="col-md-6">
                                <span class="fw-bold">Producto</span>
                            </div>
                            <div class="col-md-2 text-center">
                                <span class="fw-bold">Cantidad</span>
                            </div>
                            <div class="col-md-2 text-center">
                                <span class="fw-bold">Precio</span>
                            </div>
                            <div class="col-md-2 text-center">
                                <span class="fw-bold">Acciones</span>
                            </div>
                        </div>
                        
                        <!-- Ejemplo de un ítem en el carrito (esto será generado dinámicamente) -->
                        <div class="cart-item mb-4 p-3 border rounded shadow-sm bg-white">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3" style="width: 80px; height: 80px;">
                                            <img src="{{ asset('images/product-placeholder.jpg') }}" class="img-fluid rounded" alt="Producto" style="object-fit: cover; width: 100%; height: 100%;">
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold">Nombre del producto</h6>
                                            <small class="text-muted d-block mb-2">Categoría</small>
                                            <span class="badge bg-danger">En stock</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 text-center">
                                    <div class="input-group input-group-sm quantity-control">
                                        <button class="btn btn-outline-danger decrease-qty">
                                            <i class="bi bi-dash"></i>
                                        </button>
                                        <input type="text" class="form-control text-center item-qty border-danger" value="1" readonly>
                                        <button class="btn btn-outline-danger increase-qty">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-2 text-center">
                                    <span class="item-price fw-bold">€99.99</span>
                                </div>
                                <div class="col-md-2 text-center">
                                    <button class="btn btn-sm btn-outline-danger remove-item" title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Puedes duplicar el ítem de arriba para mostrar varios productos -->
                    </div>
                </div>

                <!-- Resumen del carrito -->
                <div id="cartSummary" class="mt-4 d-none">
                    <div class="card shadow-sm">
                        <div class="card-header bg-light">
                            <h6 class="mb-0 fw-bold">Resumen del pedido</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span id="cartSubtotal" class="text-muted">€99.99</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>IVA (21%):</span>
                                <span id="cartTax" class="text-muted">€21.00</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold">
                                <span>Total:</span>
                                <span id="cartTotal" class="text-danger">€120.99</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Pie del modal -->
            <div class="modal-footer border-0 d-flex justify-content-between">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-arrow-left me-2"></i>Seguir comprando
                </button>
                <a href="{{ url('/checkout') }}" class="btn btn-danger" id="checkoutButton">
                    Proceder al pago<i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>
