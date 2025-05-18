@extends('layouts.app')

@section('title', 'Detalle de Pedido #' . $order->id)

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 mb-0">Detalle de Pedido #{{ $order->id }}</h1>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="row">
        <!-- Información general del pedido -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Información del Pedido</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-5 fw-bold">Estado:</div>
                        <div class="col-7">
                            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="d-flex">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-select form-select-sm me-2">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Pagado</option>
                                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Procesando</option>
                                    <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Enviado</option>
                                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Entregado</option>
                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary">Actualizar</button>
                            </form>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5 fw-bold">Fecha de creación:</div>
                        <div class="col-7">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5 fw-bold">Método de pago:</div>
                        <div class="col-7">{{ ucfirst($order->payment_method) }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5 fw-bold">ID de pago:</div>
                        <div class="col-7">{{ $order->payment_id ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5 fw-bold">Fecha de pago:</div>
                        <div class="col-7">{{ $order->payment_date ? date('d/m/Y H:i', strtotime($order->payment_date)) : 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5 fw-bold">Total:</div>
                        <div class="col-7 fw-bold text-success">{{ number_format($order->total, 2) }} €</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información del cliente -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Información del Cliente</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-5 fw-bold">Nombre completo:</div>
                        <div class="col-7">{{ $order->full_name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5 fw-bold">Email:</div>
                        <div class="col-7">{{ $order->user->email }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5 fw-bold">Teléfono:</div>
                        <div class="col-7">{{ $order->shipping_phone }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5 fw-bold">Dirección:</div>
                        <div class="col-7">{{ $order->shipping_address }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5 fw-bold">Ciudad:</div>
                        <div class="col-7">{{ $order->shipping_city }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5 fw-bold">Provincia:</div>
                        <div class="col-7">{{ $order->shipping_province }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-5 fw-bold">Código postal:</div>
                        <div class="col-7">{{ $order->shipping_zip }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Productos del pedido -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">Productos</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Imagen</th>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product->id }}</td>
                            <td>
                                @if($item->product->image)
                                <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}" class="img-thumbnail" style="width: 50px;">
                                @else
                                <span class="text-muted">Sin imagen</span>
                                @endif
                            </td>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ number_format($item->price, 2) }} €</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price * $item->quantity, 2) }} €</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-end fw-bold">Total:</td>
                            <td class="fw-bold">{{ number_format($order->total, 2) }} €</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection