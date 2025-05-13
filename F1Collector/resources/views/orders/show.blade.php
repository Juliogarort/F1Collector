<!-- resources/views/orders/show.blade.php -->
@extends('layouts.app')

@section('title', 'F1 Collector - Detalles del Pedido')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0 text-danger fw-bold">Pedido #{{ $order->id }}</h1>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Volver a mis pedidos
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Detalles del pedido -->
        <div class="col-lg-8 mb-4 mb-lg-0">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light py-3">
                    <h5 class="mb-0 fw-bold">Productos</h5>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <thead class="border-bottom">
                                <tr>
                                    <th scope="col">Producto</th>
                                    <th scope="col" class="text-center">Cantidad</th>
                                    <th scope="col" class="text-end">Precio</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset($item->product->image) }}" class="img-fluid rounded me-3" style="width: 60px; height: 60px; object-fit: cover;" alt="{{ $item->product->name }}">
                                            <div>
                                                <h6 class="mb-0">{{ $item->product->name }}</h6>
                                                <small class="text-muted">{{ $item->product->team->name ?? '' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center align-middle">{{ $item->quantity }}</td>
                                    <td class="text-end align-middle">€{{ number_format($item->price, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="border-top">
                                <tr>
                                    <td colspan="2" class="text-end fw-bold">Total:</td>
                                    <td class="text-end fw-bold text-danger">€{{ number_format($order->total, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Información de envío -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light py-3">
                    <h5 class="mb-0 fw-bold">Información de envío</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nombre completo</label>
                            <p>{{ $order->full_name }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Teléfono</label>
                            <p>{{ $order->shipping_phone }}</p>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Dirección</label>
                            <p>{{ $order->shipping_address }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Ciudad</label>
                            <p>{{ $order->shipping_city }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Provincia</label>
                            <p>{{ $order->shipping_province }}</p>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Código Postal</label>
                            <p>{{ $order->shipping_zip }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Resumen del pedido -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light py-3">
                    <h5 class="mb-0 fw-bold">Resumen del pedido</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-3">
                        <span>Fecha del pedido:</span>
                        <span>{{ $order->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Hora:</span>
                        <span>{{ $order->created_at->format('H:i') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Método de pago:</span>
                        <span>{{ $order->payment_method == 'stripe' ? 'Tarjeta de crédito (Stripe)' : $order->payment_method }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Estado:</span>
                        <span>
                            @if($order->status == 'pending')
                                <span class="badge bg-warning text-dark">Pendiente</span>
                            @elseif($order->status == 'paid')
                                <span class="badge bg-success">Pagado</span>
                            @elseif($order->status == 'failed')
                                <span class="badge bg-danger">Fallido</span>
                            @else
                                <span class="badge bg-secondary">{{ $order->status }}</span>
                            @endif
                        </span>
                    </div>
                    
                    @if($order->payment_date)
                    <div class="d-flex justify-content-between mb-3">
                        <span>Fecha de pago:</span>
                        <span>{{ \Carbon\Carbon::parse($order->payment_date)->format('d/m/Y H:i') }}</span>
                    </div>
                    @endif
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between fw-bold">
                        <span>Total:</span>
                        <span class="text-danger">€{{ number_format($order->total, 2) }}</span>
                    </div>
                    
                    @if($order->status == 'pending')
                    <div class="mt-4">
                        <a href="{{ route('checkout.index') }}" class="btn btn-danger w-100">Completar pago</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection