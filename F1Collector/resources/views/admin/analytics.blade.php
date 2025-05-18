@extends('layouts.app')

@section('title', 'F1 Collector - Analítica')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-danger mb-0">Panel de Analítica</h1>
        <a href="{{ route('admin.menu') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Volver al Panel
        </a>
    </div>

    <!-- Tarjetas de resumen -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle p-3 bg-light">
                        <i class="bi bi-people-fill text-primary fs-3"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="text-muted mb-1">Usuarios</h6>
                        <h3 class="fw-bold mb-0">{{ $totalUsers }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle p-3 bg-light">
                        <i class="bi bi-box-seam text-warning fs-3"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="text-muted mb-1">Productos</h6>
                        <h3 class="fw-bold mb-0">{{ $totalProducts }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle p-3 bg-light">
                        <i class="bi bi-cart-check text-success fs-3"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="text-muted mb-1">Pedidos</h6>
                        <h3 class="fw-bold mb-0">{{ $totalOrders }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle p-3 bg-light">
                        <i class="bi bi-currency-euro text-danger fs-3"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="text-muted mb-1">Ingresos</h6>
                        <h3 class="fw-bold mb-0">{{ number_format($totalRevenue, 2) }}€</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos principales -->
    <div class="row mb-4"
         data-chart-data="{{ json_encode([
             'newUsers' => [
                 'labels' => $newUsersData['labels'],
                 'data' => $newUsersData['data']
             ],
             'revenue' => [
                 'labels' => $revenueData['labels'],
                 'data' => $revenueData['data']
             ],
             'orderStatus' => [
                 'labels' => $orderStatusDistribution['labels'],
                 'data' => $orderStatusDistribution['data'],
                 'backgroundColor' => $orderStatusDistribution['backgroundColor']
             ]
         ]) }}">
        <!-- Gráfico de nuevos usuarios -->
        <div class="col-lg-6 mb-4 mb-lg-0">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Nuevos Usuarios</h5>
                </div>
                <div class="card-body">
                    <canvas id="newUsersChart" width="100%" height="300"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Gráfico de ingresos -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Ingresos Mensuales</h5>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" width="100%" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Tabla de productos más vendidos -->
        <div class="col-lg-7 mb-4 mb-lg-0">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Productos Más Vendidos</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th class="text-center">Unidades</th>
                                    <th class="text-end">Ingresos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topProducts as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}" class="img-thumbnail me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                            <span>{{ $item->product->name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $item->total_quantity }}</td>
                                    <td class="text-end fw-bold">{{ number_format($item->total_revenue, 2) }}€</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Gráfico de distribución de pedidos por estado -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Estados de Pedidos</h5>
                </div>
                <div class="card-body">
                    <canvas id="orderStatusChart" width="100%" height="260"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Obtener datos de los gráficos
    const chartData = JSON.parse(document.querySelector('[data-chart-data]').dataset.chartData);
    
    // Configuración de colores
    const primaryColor = '#e74c3c';
    const secondaryColor = '#3498db';
    
    // Gráfico de nuevos usuarios
    const newUsersCtx = document.getElementById('newUsersChart').getContext('2d');
    new Chart(newUsersCtx, {
        type: 'bar',
        data: {
            labels: chartData.newUsers.labels,
            datasets: [{
                label: 'Nuevos Usuarios',
                data: chartData.newUsers.data,
                backgroundColor: primaryColor,
                borderColor: primaryColor,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
    
    // Gráfico de ingresos
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: chartData.revenue.labels,
            datasets: [{
                label: 'Ingresos (€)',
                data: chartData.revenue.data,
                backgroundColor: 'rgba(52, 152, 219, 0.2)',
                borderColor: secondaryColor,
                borderWidth: 2,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value + '€';
                        }
                    }
                }
            }
        }
    });
    
    // Gráfico de estado de pedidos
    const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
    new Chart(orderStatusCtx, {
        type: 'doughnut',
        data: {
            labels: chartData.orderStatus.labels,
            datasets: [{
                data: chartData.orderStatus.data,
                backgroundColor: chartData.orderStatus.backgroundColor,
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right'
                }
            }
        }
    });
});
</script>
@endpush

@push('styles')
<style>
    .card {
        border-radius: 10px;
        transition: transform 0.2s;
    }
    
    .card:hover {
        transform: translateY(-5px);
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(231, 76, 60, 0.05);
    }
    
    .rounded-circle {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
@endpush