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
                    <form method="GET" action="{{ route('catalogo') }}" id="filter-form">
                        <div class="card border-0 shadow-sm sticky-top" style="top: 20px; z-index: 1020;">
                            <div class="card-header bg-danger text-white py-3 d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 fw-bold">Filtros</h5>
                            </div>
                            <div class="card-body p-4">
                                {{-- Filtro por Escudería --}}
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

                                {{-- Filtro por Escala --}}
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

                                {{-- Filtro por Precio --}}
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
                                    @if(request('teams') || request('scales') || request('min_price') || request('max_price'))
                                    <div class="mt-2">
                                        <button type="button" id="clearAllFilters" class="btn btn-sm btn-outline-secondary w-100">
                                            <i class="bi bi-x-circle me-1"></i>Limpiar todo
                                        </button>
                                    </div>
                                    @endif
                                    <input type="hidden" name="ordenar" id="orden-actual" value="{{ request('ordenar', 'Relevancia') }}">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Cuadrícula de productos --}}
                <div class="col-lg-9">
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

                    <div class="row g-4">
                        @foreach($products as $product)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border-0 shadow-sm product-card transition-hover">
                                <div class="position-relative overflow-hidden product-img-container">
                                    <img src="{{ asset($product->image) }}" class="card-img-top product-img" alt="{{ $product->name }}">
                                    <div class="product-overlay">
                                        <button class="btn btn-sm btn-danger rounded-pill mx-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#ratingsModal-{{ $product->id }}">Detalles</button>
                                    </div>
                                    <span class="position-absolute top-0 end-0 bg-danger text-white m-3 px-2 py-1 rounded-pill small fw-bold">Nuevo</span>
                                </div>
                                <div class="card-body d-flex flex-column p-4">
                                    <p class="text-uppercase text-muted small mb-1">{{ $product->team ? $product->team->name : 'Sin escudería' }}</p>
                                    <h3 class="card-title h5 mb-2 product-title">{{ $product->name }}</h3>
                                    <div class="mb-2">
                                        <span class="text-muted small">Escala: {{ $product->scale ? $product->scale->value : 'Sin escala' }}</span>
                                    </div>
                                    <!-- Sistema de valoraciones en miniatura -->
                                    <div class="product-rating mb-2">
                                        <div class="d-flex align-items-center">
                                            <div class="stars">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <=round($product->valoracionMedia))
                                                    <i class="fas fa-star text-warning"></i>
                                                    @elseif ($i - 0.5 <= $product->valoracionMedia)
                                                        <i class="fas fa-star-half-alt text-warning"></i>
                                                        @else
                                                        <i class="far fa-star text-warning"></i>
                                                        @endif
                                                        @endfor
                                            </div>
                                            <span class="ms-2 text-muted small">
                                                {{ number_format($product->valoracionMedia, 1) }}/5 ({{ $product->numeroValoraciones }})
                                            </span>
                                        </div>
                                    </div>
                                    <p class="card-text text-muted small mb-3 flex-grow-1">{{ $product->description }}</p>
                                    <div class="mt-auto">
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

                    <!-- Modales de valoraciones (fuera del bucle principal) -->
                    @foreach($products as $product)
                    <div class="modal fade" id="ratingsModal-{{ $product->id }}" tabindex="-1" aria-labelledby="ratingsModalLabel-{{ $product->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title" id="ratingsModalLabel-{{ $product->id }}">Valoraciones: {{ $product->name }}</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <!-- Información básica del producto -->
                                        <div class="col-md-4 mb-4">
                                            <img src="{{ asset($product->image) }}" class="img-fluid rounded mb-3" alt="{{ $product->name }}">
                                            <h5 class="h6 mb-2">{{ $product->name }}</h5>
                                            <p class="text-uppercase text-muted small mb-1">{{ $product->team ? $product->team->name : 'Sin escudería' }}</p>
                                            <div class="mb-2">
                                                <span class="text-muted small">Escala: {{ $product->scale ? $product->scale->value : 'Sin escala' }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <span class="h5 fw-bold text-danger mb-0">€{{ number_format($product->price, 2) }}</span>
                                            </div>
                                        </div>

                                        <!-- Sección de valoraciones -->
                                        <div class="col-md-8">
                                            <h5 class="border-bottom pb-2 mb-3">Valoraciones y Comentarios</h5>

                                            <!-- Resumen de valoraciones -->
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="d-flex flex-column align-items-center me-3">
                                                    <span class="display-4 fw-bold">{{ number_format($product->valoracionMedia, 1) }}</span>
                                                    <div class="stars">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <=round($product->valoracionMedia))
                                                            <i class="fas fa-star text-warning"></i>
                                                            @elseif ($i - 0.5 <= $product->valoracionMedia)
                                                                <i class="fas fa-star-half-alt text-warning"></i>
                                                                @else
                                                                <i class="far fa-star text-warning"></i>
                                                                @endif
                                                                @endfor
                                                    </div>
                                                    <span class="text-muted small">{{ $product->numeroValoraciones }} valoraciones</span>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <!-- Distribución de estrellas (datos reales) -->
                                                    @php
                                                    $distribucion = $product->distribucionValoraciones;
                                                    @endphp

                                                    @for ($i = 5; $i >= 1; $i--)
                                                    @php
                                                    $cantidad = $distribucion[$i] ?? 0;
                                                    $porcentaje = $product->numeroValoraciones > 0 ? ($cantidad / $product->numeroValoraciones) * 100 : 0;
                                                    @endphp
                                                    <div class="d-flex align-items-center small mb-1">
                                                        <span class="me-2">{{ $i }}★</span>
                                                        <div class="progress flex-grow-1" style="height: 8px;">
                                                            <div class="progress-bar bg-warning" role="progressbar" style="width: {{ floatval($porcentaje)}}%"></div>
                                                        </div>
                                                        <span class="ms-2">{{ $cantidad }}</span>
                                                    </div>
                                                    @endfor
                                                </div>
                                            </div>

                                            <!-- Lista de valoraciones -->
                                            <div class="valoraciones-lista" style="max-height: 350px; overflow-y: auto;">
                                                @if($product->valoraciones->where('aprobada', true)->count() > 0)
                                                @foreach($product->valoraciones->where('aprobada', true) as $valoracion)
                                                <div class="card mb-2 shadow-sm">
                                                    <div class="card-body p-3">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <div>
                                                                <h6 class="mb-0">{{ $valoracion->user->name ?? 'Usuario' }}</h6>
                                                                <div class="text-warning small">
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        @if ($i <=$valoracion->puntuacion)
                                                                        <i class="fas fa-star"></i>
                                                                        @else
                                                                        <i class="far fa-star"></i>
                                                                        @endif
                                                                        @endfor
                                                                        @if($valoracion->compra_verificada)
                                                                        <span class="badge bg-success ms-2 small">Compra verificada</span>
                                                                        @endif
                                                                </div>
                                                            </div>
                                                            <small class="text-muted">{{ \Carbon\Carbon::parse($valoracion->created_at)->format('d/m/Y') }}</small>
                                                        </div>
                                                        <p class="small mb-0">{{ $valoracion->comentario }}</p>
                                                    </div>
                                                </div>
                                                @endforeach
                                                @else
                                                <div class="text-center py-4">
                                                    <i class="far fa-comment-dots fa-3x text-muted mb-3"></i>
                                                    <p class="text-muted">Este producto aún no tiene valoraciones.</p>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    @auth
                                    <a href="{{ route('valoraciones.productos') }}" class="btn btn-danger">
                                        <i class="fas fa-star me-1"></i> Añadir valoración
                                    </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

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

    @media (max-width: 991.98px) {
        .sticky-top {
            position: relative;
            top: 0;
        }
    }

    .search-box {
        position: sticky;
        top: 0;
        background-color: white;
        z-index: 1;
        padding: 5px 0;
    }

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
    function cambiarOrdenamiento(valor) {
        document.getElementById('orden-actual').value = valor;
        document.getElementById('filter-form').submit();
    }
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.add-to-cart').forEach(button => {
            const isInsideForm = button.closest('form') !== null;
            if (!isInsideForm) {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    showLoginAlert();
                });
            }
        });
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
        document.getElementById('clearTeamFilters')?.addEventListener('click', function() {
            document.querySelectorAll('input[name="teams[]"]').forEach(input => {
                input.checked = false;
            });
            document.getElementById('filter-form').submit();
        });
        document.getElementById('clearScaleFilters')?.addEventListener('click', function() {
            document.querySelectorAll('input[name="scales[]"]').forEach(input => {
                input.checked = false;
            });
            document.getElementById('filter-form').submit();
        });
        document.getElementById('clearPriceFilters')?.addEventListener('click', function() {
            document.querySelector('input[name="min_price"]').value = '';
            document.querySelector('input[name="max_price"]').value = '';
            document.getElementById('filter-form').submit();
        });
        document.getElementById('clearAllFilters')?.addEventListener('click', function() {
            document.querySelectorAll('input[name="teams[]"]').forEach(input => {
                input.checked = false;
            });
            document.querySelectorAll('input[name="scales[]"]').forEach(input => {
                input.checked = false;
            });
            document.querySelector('input[name="min_price"]').value = '';
            document.querySelector('input[name="max_price"]').value = '';
            const ordenActual = document.getElementById('orden-actual').value;
            if (ordenActual && ordenActual !== 'Relevancia') {
                window.location.href = '{{ route("catalogo") }}?ordenar=' + ordenActual;
            } else {
                window.location.href = '{{ route("catalogo") }}';
            }
        });

        function showLoginAlert() {
            const existing = document.getElementById('loginAlert');
            if (existing) existing.remove();
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
    window.addEventListener('beforeunload', () => {
        sessionStorage.setItem('catalogoScroll', window.scrollY);
    });
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
            input.addEventListener('blur', () => {
                form.submit();
            });
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