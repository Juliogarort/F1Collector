@extends('layouts.app')

@section('title', 'Gestión de Pedidos')

@push('styles')
<style>
    .status-indicator {
        display: inline-block;
        padding: 0.35rem 0.65rem;
        font-size: 0.75rem;
        font-weight: 600;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 50rem;
    }

    .status-pending {
        background-color: #ffc107;
        color: #212529;
    }

    .status-paid {
        background-color: #0dcaf0;
        color: #fff;
    }

    .status-processing {
        background-color: #6c757d;
        color: #fff;
    }

    .status-shipped {
        background-color: #0d6efd;
        color: #fff;
    }

    .status-delivered {
        background-color: #198754;
        color: #fff;
    }

    .status-cancelled {
        background-color: #dc3545;
        color: #fff;
    }

    .table-orders th {
        font-weight: 600;
        color: #495057;
        border-top: none;
        background-color: #f8f9fa;
    }

    .table-orders td {
        vertical-align: middle;
    }

    .order-card {
        border-radius: 10px;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        transition: all 0.3s ease;
    }

    .order-card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .card-header-custom {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        padding: 1rem 1.25rem;
    }

    .filter-section {
        background-color: #f8f9fa;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    .btn-action {
        border-radius: 0.375rem;
        transition: all 0.2s;
    }

    .avatar-sm {
        width: 32px;
        height: 32px;
        font-size: 0.875rem;
    }

    .footer-spacer {
        height: 60px;
        /* Ajusta esta altura según necesites */
    }

    /* Solución para problemas con dropdown */
    .dropdown-menu {
        z-index: 1030;
        /* Asegura que el dropdown aparezca por encima de otros elementos */
    }

    .dropdown-menu.dropdown-menu-end {
        min-width: 180px;
        /* Ancho mínimo para el dropdown */
        margin-top: 0.5rem;
        /* Espacio entre el botón y el dropdown */
    }

    .status-action-btn {
        display: block;
        width: 100%;
        padding: 8px 12px;
        text-align: left;
        border: none;
        background: none;
        color: #212529;
        transition: background-color 0.2s;
    }

    .status-action-btn:hover {
        background-color: #f8f9fa;
    }

    .status-action-btn.text-danger:hover {
        background-color: #f8d7da;
    }

    .btn-group-status {
        position: relative;
    }

    /* Márgenes adicionales para la última fila */
    .table-orders tr:last-child td {
        padding-bottom: 1rem;
    }

    /* Ajuste responsive para la tabla */
    @media (max-width: 767.98px) {
        .table-orders td:last-child {
            position: relative;
            min-width: 110px;
            /* Ancho mínimo para las acciones */
        }

        .container-fluid {
            padding-left: 10px;
            padding-right: 10px;
        }

        .card-body {
            padding: 1rem;
        }

        .status-indicator {
            padding: 0.25rem 0.5rem;
            font-size: 0.7rem;
        }

        h3.fw-bold {
            font-size: 1.5rem;
        }

        .h2 {
            font-size: 1.5rem;
        }

        .footer-spacer {
            height: 40px;
            /* Menos espacio en móviles */
        }
    }
</style>
@endpush

@section('content')
<div class="container py-5 mb-5">
    <!-- Header con estilo similar a la vista de Usuarios -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <h1 class="h3 text-primary mb-3 mb-md-0">
            <i class="bi bi-cart-fill me-2"></i>Gestión de Pedidos
        </h1>
        <a href="{{ route('admin.menu') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Volver al Panel
        </a>
    </div>

    <!-- Subtítulo descriptivo -->
    <p class="text-muted mb-4">Administra y da seguimiento a los pedidos de tus clientes</p>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Tarjetas de Resumen -->
    <div class="row mb-4">
        <div class="col-6 col-md-3 mb-3 mb-md-0">
            <div class="card bg-white border-0 order-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted fw-normal mb-1">Total Pedidos</h6>
                            <h3 class="fw-bold mb-0">{{ $orders->total() }}</h3>
                        </div>
                        <div class="rounded-circle bg-light p-2 p-sm-3">
                            <i class="bi bi-cart-fill text-primary fs-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="col-6 col-md-3 mb-3 mb-md-0">
            <div class="card bg-white border-0 order-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted fw-normal mb-1">Pendientes</h6>
                            <h3 class="fw-bold mb-0">{{ $orders->where('status', 'pending')->count() }}</h3>
                        </div>
                        <div class="rounded-circle bg-warning bg-opacity-10 p-2 p-sm-3">
                            <i class="bi bi-hourglass-split text-warning fs-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="col-6 col-md-3 mt-3 mt-md-0">
            <div class="card bg-white border-0 order-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted fw-normal mb-1">Completados</h6>
                            <h3 class="fw-bold mb-0">{{ $orders->where('status', 'delivered')->count() }}</h3>
                        </div>
                        <div class="rounded-circle bg-success bg-opacity-10 p-2 p-sm-3">
                            <i class="bi bi-check-circle-fill text-success fs-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3 mt-3 mt-md-0">
            <div class="card bg-white border-0 order-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted fw-normal mb-1">Ingresos</h6>
                            <h3 class="fw-bold mb-0">{{ number_format($orders->sum('total'), 2) }} €</h3>
                        </div>
                        <div class="rounded-circle bg-primary bg-opacity-10 p-2 p-sm-3">
                            <i class="bi bi-currency-euro text-primary fs-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 order-card">
        <div class="card-header-custom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Listado de Pedidos</h5>
                <span class="text-muted">{{ $orders->firstItem() ?? 0 }}-{{ $orders->lastItem() ?? 0 }} de {{ $orders->total() }} pedidos</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-orders mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Pedido</th>
                            <th>Cliente</th>
                            <th class="d-none d-md-table-cell">Fecha</th>
                            <th class="d-none d-sm-table-cell">Total</th>
                            <th>Estado</th>
                            <th class="d-none d-lg-table-cell">Pago</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td class="ps-4 fw-bold">#{{ $order->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-light rounded-circle me-2 d-flex align-items-center justify-content-center">
                                        <span class="text-primary">{{ strtoupper(substr($order->full_name, 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <div>{{ $order->full_name }}</div>
                                        <small class="text-muted d-none d-sm-inline">{{ $order->user->email ?? 'N/A' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="d-none d-md-table-cell">
                                <div>{{ $order->created_at->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                            </td>
                            <td class="fw-bold d-none d-sm-table-cell">{{ number_format($order->total, 2) }} €</td>
                            <td>
                                <span class="status-indicator status-{{ $order->status }}">
                                    {{ ucfirst($order->status === 'pending' ? 'Pendiente' : 
                                        ($order->status === 'paid' ? 'Pagado' : 
                                        ($order->status === 'processing' ? 'Procesando' : 
                                        ($order->status === 'shipped' ? 'Enviado' : 
                                        ($order->status === 'delivered' ? 'Entregado' : 'Cancelado'))))) }}
                                </span>
                            </td>
                            <td class="d-none d-lg-table-cell">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-credit-card me-2 {{ $order->payment_method === 'stripe' ? 'text-primary' : 'text-secondary' }}"></i>
                                    {{ ucfirst($order->payment_method) }}
                                </div>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary btn-action">
                                        <i class="bi bi-eye me-1 d-none d-md-inline"></i><span class="d-none d-md-inline">Ver</span><i class="bi bi-eye d-inline d-md-none"></i>
                                    </a>
                                    <!-- Solución alternativa sin dropdown -->
                                    <a href="{{ route('admin.orders.show', $order->id) }}#status-update" class="btn btn-sm btn-outline-secondary btn-action">
                                        <i class="bi bi-gear-fill me-1 d-none d-md-inline"></i><span class="d-none d-md-inline">Estados</span><i class="bi bi-gear-fill d-inline d-md-none"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="bi bi-inbox fs-1 text-muted mb-3"></i>
                                    <h5 class="fw-normal text-muted mb-1">No hay pedidos disponibles</h5>
                                    <p class="text-muted">Cuando los clientes realicen pedidos, aparecerán aquí.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($orders->hasPages())
            <nav aria-label="Navegación de páginas">
                <ul class="pagination pagination-danger mb-0">
                    {{ $orders->onEachSide(1)->links('pagination::bootstrap-5') }}
                </ul>
            </nav>
            @endif
        </div>
    </div>

    <!-- Espaciador para separar del footer -->
    <div class="footer-spacer"></div>
</div>
@endsection