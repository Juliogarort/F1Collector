<header class="racing-header">

    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/carrito.css') }}">

    <script src="{{ asset('js/header.js') }}" defer></script>
    <script src="{{ asset('js/carrito.js') }}"></script>
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

                    <!-- Aquí está el botón modificado del carrito -->
                    <button type="button" class="btn btn-racing btn-cart me-2" title="Carrito" data-bs-toggle="modal" data-bs-target="#cartModal">
                        <i class="bi bi-cart-fill"></i>
                        @php
                        // Obtener el carrito del usuario actual
                        $cart = Auth::check() ? \App\Models\ShoppingCart::where('user_id', Auth::id())
                        ->with('items')
                        ->first() : null;

                        // Contar items en el carrito
                        $itemCount = $cart ? $cart->items->sum('quantity') : 0;
                        @endphp

                        @if($itemCount > 0)
                        <span class="cart-counter">
                            {{ $itemCount }}
                        </span>
                        @endif
                    </button>

                    <!-- CSS para el contador mejorado - Añade esto a tu archivo carrito.css o header.css -->
                    <style>
                        /* Estilos para el contador mejorado del carrito */
                        .btn-cart {
                            position: relative;
                        }

                        .cart-counter {
                            position: absolute;
                            top: -8px;
                            right: -8px;
                            min-width: 18px;
                            height: 18px;
                            padding: 0 5px;
                            border-radius: 9px;
                            background-color: var(--primary-color);
                            color: #fff;
                            font-size: 0.7rem;
                            font-weight: 700;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
                            border: 1px solid rgba(255, 255, 255, 0.3);
                            transform: scale(1);
                            animation: pulse-badge 1s ease-in-out;
                            z-index: 2;
                        }

                        @keyframes pulse-badge {
                            0% {
                                transform: scale(0.8);
                            }

                            50% {
                                transform: scale(1.2);
                            }

                            100% {
                                transform: scale(1);
                            }
                        }

                        /* Mejora para la visualización del botón */
                        .btn-cart i {
                            position: relative;
                            z-index: 1;
                        }

                        /* Efecto de resplandor al haber items */
                        .btn-cart:has(.cart-counter) {
                            box-shadow: 0 0 10px rgba(225, 6, 0, 0.3);
                        }
                    </style>

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

<!-- Modal del carrito (sin JavaScript embebido) -->
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
                @php
                // Obtener el carrito del usuario actual
                $cart = Auth::check() ? \App\Models\ShoppingCart::where('user_id', Auth::id())
                ->first() : null;

                // Obtener los items si existe el carrito
                $items = $cart ? $cart->items()->with('product')->get() : collect([]);

                // Calcular total (sin IVA)
                $total = $items->sum(function($item) {
                return $item->quantity * $item->product->price;
                });
                @endphp

                <div id="cartContent">
                    <!-- Mensaje de carrito vacío -->
                    @if($items->isEmpty())
                    <div class="text-center py-5" id="emptyCartMessage">
                        <div class="display-1 text-muted mb-3">
                            <i class="bi bi-cart-x"></i>
                        </div>
                        <h4 class="text-muted">Tu carrito está vacío</h4>
                        <p class="text-muted mt-3">Añade artículos al carrito para continuar con tu compra</p>
                        <a href="{{ route('catalogo') }}" class="btn btn-outline-danger mt-3">
                            <i class="bi bi-arrow-left me-2"></i>Explorar productos
                        </a>
                    </div>
                    @else
                    <!-- Lista de productos en el carrito -->
                    <div id="cartItems">
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

                        <!-- Items del carrito -->
                        @foreach($items as $item)
                        <div class="cart-item mb-4 p-3 border rounded shadow-sm bg-white">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3" style="width: 80px; height: 80px;">
                                            <img src="{{ asset($item->product->image) }}" class="img-fluid rounded" alt="{{ $item->product->name }}" style="object-fit: cover; width: 100%; height: 100%;">
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold">{{ $item->product->name }}</h6>
                                            <small class="text-muted d-block mb-2">{{ $item->product->team }} - {{ $item->product->type }}</small>
                                            <span class="badge bg-danger">En stock</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 text-center">
                                    <div class="input-group input-group-sm quantity-control">
                                        <a href="{{ route('cart.update') }}?item_id={{ $item->id }}&quantity={{ max(1, $item->quantity - 1) }}"
                                            class="btn btn-outline-danger decrease-qty"
                                            @if($item->quantity <= 1) disabled @endif>
                                                <i class="bi bi-dash"></i>
                                        </a>
                                        <input type="text" class="form-control text-center item-qty border-danger" value="{{ $item->quantity }}" readonly>
                                        <a href="{{ route('cart.update') }}?item_id={{ $item->id }}&quantity={{ min(10, $item->quantity + 1) }}"
                                            class="btn btn-outline-danger increase-qty"
                                            @if($item->quantity >= 10) disabled @endif>
                                            <i class="bi bi-plus"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-2 text-center">
                                    <span class="item-price fw-bold">€{{ number_format($item->quantity * $item->product->price, 2) }}</span>
                                </div>
                                <div class="col-md-2 text-center">
                                    <a href="{{ route('cart.remove', $item->id) }}" class="btn btn-sm btn-outline-danger remove-item" title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Resumen del carrito (sin IVA) -->
                    <div id="cartSummary" class="mt-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="mb-0 fw-bold">Resumen del pedido</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <span id="cartSubtotal" class="text-muted">€{{ number_format($total, 2) }}</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between fw-bold">
                                    <span>Total:</span>
                                    <span id="cartTotal" class="text-danger">€{{ number_format($total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Pie del modal -->
            <div class="modal-footer border-0 d-flex justify-content-between">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-arrow-left me-2"></i>Seguir comprando
                </button>

                @if(!$items->isEmpty())
                <div class="d-flex">
                    <a href="{{ route('cart.clear') }}" class="btn btn-outline-danger me-2">
                        <i class="bi bi-trash me-1"></i>Vaciar carrito
                    </a>
                    <a href="{{ route('checkout') }}" class="btn btn-danger">
                        Proceder al pago<i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
                @else
                <a href="{{ route('checkout') }}" class="btn btn-danger disabled">
                    Proceder al pago<i class="bi bi-arrow-right ms-2"></i>
                </a>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Elementos ocultos para mensajes flash -->
@if(session('success'))
<div id="success-message" class="d-none">{{ session('success') }}</div>
@endif

@if(session('error'))
<div id="error-message" class="d-none">{{ session('error') }}</div>
@endif

@if(session('openCartModal'))
    <div id="auto-open-cart-modal" style="display: none;"></div>
@endif