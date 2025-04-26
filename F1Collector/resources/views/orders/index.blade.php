<!-- resources/views/orders/index.blade.php -->
@extends('layouts.app')

@section('title', 'F1 Collector - Mis Pedidos')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12 mb-4">
            <h1 class="h3 mb-0 text-danger fw-bold">Mis Pedidos</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @if($orders->count() > 0)
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col" class="ps-4">Nº Pedido</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col" class="text-end pe-4">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <td class="ps-4">#{{ $order->id }}</td>
                                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                        <td>€{{ number_format($order->total, 2) }}</td>
                                        <td>
                                            @if($order->status == 'pending')
                                                <span class="badge bg-warning text-dark">Pendiente</span>
                                            @elseif($order->status == 'paid')
                                                <span class="badge bg-success">Pagado</span>
                                            @elseif($order->status == 'failed')
                                                <span class="badge bg-danger">Fallido</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $order->status }}</span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4">
                                            <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-danger">
                                                Ver detalles
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5 text-center">
                        <div class="mb-4">
                            <i class="fas fa-shopping-bag fa-3x text-muted"></i>
                        </div>
                        <h3 class="h4 mb-3">No tienes pedidos todavía</h3>
                        <p class="text-muted mb-4">Parece que aún no has realizado ningún pedido.</p>
                        <a href="{{ route('catalogo') }}" class="btn btn-danger">Ir a la tienda</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection