@extends('layouts.app')

@section('title', 'F1 Collector - Catálogo de Modelos')

@section('content')
<div class="container-fluid p-0">
    {{-- Cabecera del Catálogo --}}
    <header class="bg-dark text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 text-center">
                    <h1 class="display-4 fw-bold text-danger mb-3">Catálogo de Modelos</h1>
                    <p class="lead text-light mb-0">Explora nuestra exclusiva colección de modelos a escala de F1</p>
                </div>
            </div>
        </div>
    </header>

    {{-- Sección de Filtros y Productos --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                {{-- Columna izquierda con el formulario --}}
                <div class="col-lg-3 mb-4 mb-lg-0">
                    {{-- FORMULARIO DE FILTROS --}}
                    <form method="GET" action="{{ route('catalogo') }}" id="filter-form">
                        <div class="card border-0 shadow-sm sticky-top" style="top: 20px; z-index: 1020;">
                            <div class="card-header bg-danger text-white py-3 d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 fw-bold">Filtros</h5>
                            </div>
                            <div class="card-body p-4">
                                {{-- Filtro por Escudería (DROPDOWN) --}}
                                <div class="mb-4">
                                    <button class="btn btn-outline-secondary w-100 d-flex justify-content-between align-items-center"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseTeams"
                                        aria-expanded="false"
                                        aria-controls="collapseTeams">
                                        <span class="fw-bold text-uppercase small">Escudería</span>
                                        <i class="bi bi-chevron-down"></i>
                                    </button>

                                    <div class="collapse mt-2" id="collapseTeams">
                                        <div class="card card-body border-0 p-2" style="max-height: 250px; overflow-y: auto;">
                                            <div class="search-box mb-2">
                                                <input type="text" id="teamSearch" class="form-control form-control-sm" placeholder="Buscar escudería...">
                                            </div>

                                            @foreach ($teams as $team)
                                            <div class="form-check mb-2 team-check-item">
                                                <input class="form-check-input" type="checkbox" name="teams[]" value="{{ $team->id }}"
                                                    id="team-{{ $team->id }}" {{ in_array($team->id, request('teams', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="team-{{ $team->id }}">{{ $team->name }}</label>
                                            </div>
                                            @endforeach

                                            @if(count(request('teams', [])) > 0)
                                            <div class="mt-2 text-end">
                                                <button type="button" class="btn btn-sm btn-outline-danger" id="clearTeamFilters">
                                                    <i class="bi bi-x-circle me-1"></i>Limpiar
                                                </button>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Filtro por Escala (ORIGINAL) --}}
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="fw-bold mb-0 text-uppercase small">Escala</h6>
                                        @if(count(request('scales', [])) > 0)
                                        <button type="button" class="btn btn-sm btn-outline-danger p-1 px-2" id="clearScaleFilters">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                        @endif
                                    </div>
                                    @foreach ($scales as $scale)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="scales[]" value="{{ $scale->id }}"
                                            id="scale-{{ $scale->id }}" {{ in_array($scale->id, request('scales', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="scale-{{ $scale->id }}">{{ $scale->value }}</label>
                                    </div>
                                    @endforeach
                                </div>

                                {{-- Filtro por Precio (ORIGINAL) --}}
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="fw-bold mb-0 text-uppercase small">Precio</h6>
                                        @if(request('min_price') || request('max_price'))
                                        <button type="button" class="btn btn-sm btn-outline-danger p-1 px-2" id="clearPriceFilters">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="me-2">€</span>
                                        <input type="number" name="min_price" class="form-control form-control-sm me-2" style="max-width: 90px;"
                                            value="{{ request('min_price') }}" min="0" placeholder="Mín.">
                                        <span class="mx-1">-</span>
                                        <input type="number" name="max_price" class="form-control form-control-sm ms-2" style="max-width: 90px;"
                                            value="{{ request('max_price') }}" min="0" placeholder="Máx.">
                                    </div>
                                    <div class="mt-2">
                                        <button type="submit" class="btn btn-sm btn-danger w-100">Aplicar filtros</button>
                                    </div>
                                    {{-- Botón "Limpiar todo" reubicado aquí, justo debajo del botón aplicar filtros --}}
                                    @if(request('teams') || request('scales') || request('min_price') || request('max_price'))
                                    <div class="mt-2">
                                        <button type="button" id="clearAllFilters" class="btn btn-sm btn-outline-secondary w-100">
                                            <i class="bi bi-x-circle me-1"></i>Limpiar todo
                                        </button>
                                    </div>
                                    @endif

                                </div>

                                {{-- Campo oculto para mantener el ordenamiento cuando se aplican filtros --}}
                                <input type="hidden" name="ordenar" id="orden-actual" value="{{ request('ordenar', 'Relevancia') }}">
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Cuadrícula de productos --}}
                <div class="col-lg-9">
                    {{-- Opciones de ordenamiento --}}
                    <div class="d-flex justify-content-between align-items-center bg-white p-3 mb-4 shadow-sm rounded">
                        <div>
                            <span class="text-muted">Mostrando {{ $products->count() }} productos</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <label for="ordenar" class="me-2 text-nowrap">Ordenar por:</label>
                            <select class="form-select form-select-sm" id="ordenar" onchange="cambiarOrdenamiento(this.value)">
                                <option value="Relevancia" {{ request('ordenar') == 'Relevancia' ? 'selected' : '' }}>Relevancia</option>
                                <option value="Precio: Menor a Mayor" {{ request('ordenar') == 'Precio: Menor a Mayor' ? 'selected' : '' }}>Precio: Menor a Mayor</option>
                                <option value="Precio: Mayor a Menor" {{ request('ordenar') == 'Precio: Mayor a Menor' ? 'selected' : '' }}>Precio: Mayor a Menor</option>
                                <option value="Más Recientes" {{ request('ordenar') == 'Más Recientes' ? 'selected' : '' }}>Más Recientes</option>
                                <option value="Más Populares" {{ request('ordenar') == 'Más Populares' ? 'selected' : '' }}>Más Populares</option>
                            </select>
                        </div>
                    </div>

                    {{-- Productos --}}
                    <div class="row g-4">
                        @foreach($products as $product)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border-0 shadow-sm product-card transition-hover">
                                <div class="position-relative overflow-hidden product-img-container">
                                    <img src="{{ asset($product->image) }}" class="card-img-top product-img" alt="{{ $product->name }}">
                                    <div class="product-overlay">
                                        <button class="btn btn-sm btn-danger rounded-pill mx-1">Detalles</button>
                                    </div>
                                    <span class="position-absolute top-0 end-0 bg-danger text-white m-3 px-2 py-1 rounded-pill small fw-bold">Nuevo</span>
                                </div>
                                <div class="card-body d-flex flex-column p-4">
                                    <p class="text-uppercase text-muted small mb-1">{{ $product->team ? $product->team->name : 'Sin escudería' }}</p>
                                    <h3 class="card-title h5 mb-2 product-title">{{ $product->name }}</h3>
                                    <div class="mb-2">
                                        <span class="text-muted small">Escala: {{ $product->scale ? $product->scale->value : 'Sin escala' }}</span>
                                    </div>
                                    <p class="card-text text-muted small mb-3 flex-grow-1">{{ $product->description }}</p>
                                    <div class="mt-auto">
                                        <!-- Añadimos el precio aquí -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="h5 fw-bold text-danger mb-0">€{{ number_format($product->price, 2) }}</span>
                                        </div>
                                        @auth
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                @php
                                                $isInWishlist = Auth::user()->wishlist &&
                                                Auth::user()->wishlist->products->contains($product->id);
                                                @endphp
                                                <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm rounded-circle {{ $isInWishlist ? 'btn-danger' : 'btn-outline-danger' }}" title="Favorito">
                                                        <i class="{{ $isInWishlist ? 'fas fa-heart' : 'far fa-heart' }}"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn btn-dark rounded-pill px-3 add-to-cart">
                                                    <i class="fas fa-shopping-cart me-1"></i> Añadir
                                                </button>
                                            </form>
                                        </div>
                                        @else
                                        <!-- Aviso para usuarios no registrados -->
                                        <div class="text-center">
                                            <p class="small text-muted mb-2">Para comprar, inicia sesión o regístrate</p>
                                            <button type="button" class="btn btn-outline-danger btn-sm rounded-pill w-100 open-login-modal">
                                                <i class="fas fa-user-lock me-1"></i> Iniciar sesión
                                            </button>
                                        </div>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Paginación --}}
                    @if($products->hasPages())
                    <div class="pagination-container mt-5">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div class="pagination-info mb-3 mb-md-0">
                                <span class="text-muted">
                                    Mostrando {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} de {{ $products->total() }} productos
                                </span>
                            </div>
                            <nav aria-label="Navegación de páginas">
                                <ul class="pagination pagination-danger mb-0">
                                    {{ $products->onEachSide(1)->links('pagination::bootstrap-5') }}
                                </ul>
                            </nav>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </section>

    {{-- Banner de suscripción --}}
    <section class="bg-gradient-danger py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mb-3 mb-lg-0">
                    <h3 class="fw-bold mb-2">¿Buscas un modelo específico?</h3>
                    <p class="mb-0 lead">Contáctanos y te ayudaremos a encontrar ese modelo único que estás buscando.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('catalogo') }}" class="btn btn-outline-dark btn-lg rounded-pill px-4 fw-bold">Contactar</a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<style>
    /* Estilos personalizados para el catálogo */
    .product-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
    }

    .product-img-container {
        position: relative;
        overflow: hidden;
        height: 200px;
    }

    .product-img {
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .product-card:hover .product-img {
        transform: scale(1.05);
    }

    .product-overlay {
        position: absolute;
        bottom: -50px;
        left: 0;
        right: 0;
        background-color: rgba(0, 0, 0, 0.7);
        padding: 10px;
        transition: bottom 0.3s ease;
        text-align: center;
    }

    .product-card:hover .product-overlay {
        bottom: 0;
    }

    .product-title {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .add-to-cart {
        transition: all 0.3s ease;
    }

    .add-to-cart:hover {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .bg-gradient-danger {
        background: linear-gradient(45deg, #dc3545, #a71d2a);
    }

    /* Estilo para sticky filter en móvil */
    @media (max-width: 991.98px) {
        .sticky-top {
            position: relative;
            top: 0;
        }
    }

    /* Estilos para el dropdown de escuderías */
    .search-box {
        position: sticky;
        top: 0;
        background-color: white;
        z-index: 1;
        padding: 5px 0;
    }

    /* Estilizar el botón de filtro */
    .btn-outline-secondary {
        color: #6c757d;
        border-color: #ced4da;
        background-color: #fff;
    }

    .btn-outline-secondary:hover,
    .btn-outline-secondary:focus {
        background-color: #f8f9fa;
        border-color: #ced4da;
        box-shadow: none;
    }

    /* Animación para el dropdown */
    .collapse.show {
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Estilo para botón Limpiar Todo */
    #clearAllFilters {
        font-size: 0.8rem;
        border-color: rgba(255, 255, 255, 0.5);
    }

    #clearAllFilters:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }
</style>
@endpush

@push('scripts')
<script>
    // Función para cambiar el ordenamiento y enviar el formulario
    function cambiarOrdenamiento(valor) {
        document.getElementById('orden-actual').value = valor;
        document.getElementById('filter-form').submit();
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Solo interceptamos los botones que NO están dentro de un formulario
        document.querySelectorAll('.add-to-cart').forEach(button => {
            const isInsideForm = button.closest('form') !== null;

            if (!isInsideForm) {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    showLoginAlert();
                });
            }
        });

        // Buscador de escuderías
        const teamSearch = document.getElementById('teamSearch');
        if (teamSearch) {
            teamSearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                document.querySelectorAll('.team-check-item').forEach(item => {
                    const teamName = item.querySelector('label').textContent.toLowerCase();
                    if (teamName.includes(searchTerm)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }

        // Limpiar filtros de escuderías
        document.getElementById('clearTeamFilters')?.addEventListener('click', function() {
            document.querySelectorAll('input[name="teams[]"]').forEach(input => {
                input.checked = false;
            });
            document.getElementById('filter-form').submit();
        });

        // Limpiar filtros de escalas
        document.getElementById('clearScaleFilters')?.addEventListener('click', function() {
            document.querySelectorAll('input[name="scales[]"]').forEach(input => {
                input.checked = false;
            });
            document.getElementById('filter-form').submit();
        });

        // Limpiar filtros de precio
        document.getElementById('clearPriceFilters')?.addEventListener('click', function() {
            document.querySelector('input[name="min_price"]').value = '';
            document.querySelector('input[name="max_price"]').value = '';
            document.getElementById('filter-form').submit();
        });

        // Limpiar todos los filtros
        document.getElementById('clearAllFilters')?.addEventListener('click', function() {
            // Limpiar escuderías
            document.querySelectorAll('input[name="teams[]"]').forEach(input => {
                input.checked = false;
            });

            // Limpiar escalas
            document.querySelectorAll('input[name="scales[]"]').forEach(input => {
                input.checked = false;
            });

            // Limpiar precios
            document.querySelector('input[name="min_price"]').value = '';
            document.querySelector('input[name="max_price"]').value = '';

            // Mantener ordenamiento
            const ordenActual = document.getElementById('orden-actual').value;

            // Redirigir a la página de catálogo sin filtros pero manteniendo orden
            if (ordenActual && ordenActual !== 'Relevancia') {
                window.location.href = '{{ route("catalogo") }}?ordenar=' + ordenActual;
            } else {
                window.location.href = '{{ route("catalogo") }}';
            }
        });

        function showLoginAlert() {
            const existing = document.getElementById('loginAlert');
            if (existing) existing.remove(); // evita duplicados

            const alert = document.createElement('div');
            alert.id = 'loginAlert';
            alert.className = 'alert alert-danger position-fixed top-0 start-50 translate-middle-x mt-3 shadow text-center';
            alert.style.zIndex = '1055';
            alert.style.minWidth = '350px';
            alert.style.maxWidth = '90%';
            alert.innerHTML = `
                <div class="d-flex align-items-center justify-content-center">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <span><strong>Debes iniciar sesión</strong> para añadir productos al carrito.</span>
                </div>
                <div class="progress mt-2" style="height: 4px;">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 100%"></div>
                </div>
            `;

            document.body.appendChild(alert);

            // Animación de la barra de progreso y eliminación automática
            let progress = alert.querySelector('.progress-bar');
            let width = 100;
            const interval = setInterval(() => {
                width -= 2;
                progress.style.width = width + '%';

                if (width <= 0) {
                    clearInterval(interval);
                    alert.remove();
                }
            }, 100);
        }
    });

    // Guardar scroll antes de recargar
    window.addEventListener('beforeunload', () => {
        sessionStorage.setItem('catalogoScroll', window.scrollY);
    });

    // Restaurar scroll después de recargar
    window.addEventListener('load', () => {
        const scroll = sessionStorage.getItem('catalogoScroll');
        if (scroll !== null) {
            window.scrollTo(0, parseInt(scroll));
            sessionStorage.removeItem('catalogoScroll');
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('filter-form');
        const inputs = document.querySelectorAll('#filter-form input[name="min_price"], #filter-form input[name="max_price"]');

        inputs.forEach(input => {
            // Enviar formulario al perder foco
            input.addEventListener('blur', () => {
                form.submit();
            });

            // Enviar formulario si pulsa Enter dentro del input
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    form.submit();
                }
            });
        });
    });
</script>
@endpush