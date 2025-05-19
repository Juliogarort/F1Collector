<!-- resources/views/payment/success.blade.php -->
@extends('layouts.app')

@section('title', 'F1 Collector - Pago Completado')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="mb-4">
                <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 100px; height: 100px;">
                    <i class="fas fa-check-circle fa-4x"></i>
                </div>
                <h1 class="h3 fw-bold mb-3">¡Pago completado con éxito!</h1>
                <p class="text-muted mb-4">Gracias por tu compra. Tu pedido ha sido procesado correctamente.</p>
            </div>
            
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Detalles del pedido</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Número de pedido:</span>
                        <span class="fw-bold">#{{ $order->id }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Fecha:</span>
                        <span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Método de pago:</span>
                        <span>Tarjeta de crédito (Stripe)</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Total:</span>
                        <span class="fw-bold text-danger">€{{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>
            
            <div class="mb-4">
                <p>Hemos enviado un correo electrónico con los detalles de tu compra a tu dirección de email.</p>
                <p>Puedes consultar el estado de tu pedido en cualquier momento desde tu área de cliente.</p>
            </div>
            
            <div class="d-grid gap-2 col-md-6 mx-auto">
                <a href="{{ route('orders.index') }}" class="btn btn-outline-danger py-2">Ver mis pedidos</a>
                <a href="{{ route('catalogo') }}" class="btn btn-danger py-2">Seguir comprando</a>
                <div class="d-grid gap-2 col-md-6 mx-auto">
    <a href="{{ route('orders.invoice', $order) }}" class="btn btn-outline-secondary py-2">
        <i class="fas fa-file-invoice me-2"></i>Descargar factura
    </a>
</div>
            </div>
        </div>
    </div>
</div>
@endsection