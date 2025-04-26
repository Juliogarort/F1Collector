<!-- resources/views/payment/failed.blade.php -->
@extends('layouts.app')

@section('title', 'F1 Collector - Pago Fallido')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="mb-4">
                <div class="bg-danger text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 100px; height: 100px;">
                    <i class="fas fa-times-circle fa-4x"></i>
                </div>
                <h1 class="h3 fw-bold mb-3">El pago no pudo ser procesado</h1>
                <p class="text-muted mb-4">Lo sentimos, ha ocurrido un problema al procesar tu pago.</p>
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
                    <div class="d-flex justify-content-between">
                        <span>Total:</span>
                        <span class="fw-bold text-danger">€{{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>
            
            <div class="alert alert-info mb-4">
                <h5 class="fw-bold">¿Qué ha ocurrido?</h5>
                <p class="mb-0">El pago no ha podido completarse por alguno de los siguientes motivos:</p>
                <ul class="text-start mt-2 mb-0">
                    <li>Fondos insuficientes en la cuenta</li>
                    <li>Datos de la tarjeta incorrectos</li>
                    <li>Problema de conexión con la pasarela de pago</li>
                    <li>La operación fue rechazada por el banco emisor</li>
                </ul>
            </div>
            
            <div class="d-grid gap-2 col-md-8 mx-auto">
                <a href="{{ route('checkout.index') }}" class="btn btn-danger py-2">Intentar pagar de nuevo</a>
                <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary py-2">Volver al carrito</a>
                <a href="{{ route('contacto') }}" class="btn btn-outline-dark py-2">Contactar con soporte</a>
            </div>
        </div>
    </div>
</div>
@endsection