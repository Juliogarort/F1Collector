<!-- resources/views/checkout.blade.php -->
@extends('layouts.app')

@section('title', 'F1 Collector - Finalizar compra')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12 mb-4">
            <h1 class="h3 mb-0 text-danger fw-bold">Finalizar compra</h1>
        </div>
    </div>

    <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
        @csrf
        <div class="row">
            <!-- Resumen del pedido - Columna izquierda -->
            <div class="col-lg-8 mb-4 mb-lg-0">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light py-3">
                        <h5 class="mb-0 fw-bold">Resumen del pedido</h5>
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
                                    @foreach($items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset($item->product->image) }}" class="img-fluid rounded me-3" style="width: 60px; height: 60px; object-fit: cover;" alt="{{ $item->product->name }}">
                                                <div>
                                                    <h6 class="mb-0">{{ $item->product->name }}</h6>
                                                    <small class="text-muted">{{ $item->product->team->name }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">{{ $item->quantity }}</td>
                                        <td class="text-end align-middle">€{{ number_format($item->product->price * $item->quantity, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Formulario de dirección de envío -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light py-3">
                        <h5 class="mb-0 fw-bold">Dirección de envío</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="firstName" class="form-label">Nombre</label>
                                <input type="text" class="form-control @error('firstName') is-invalid @enderror"
                                    id="firstName" name="firstName" required value="{{ old('firstName') }}">
                                @error('firstName')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="lastName" class="form-label">Apellidos</label>
                                <input type="text" class="form-control @error('lastName') is-invalid @enderror"
                                    id="lastName" name="lastName" required value="{{ old('lastName') }}">
                                @error('lastName')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="address" class="form-label">Dirección</label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror"
                                    id="address" name="address" required value="{{ old('address') }}">
                                @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-5">
                                <label for="city" class="form-label">Ciudad</label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror"
                                    id="city" name="city" required value="{{ old('city') }}">
                                @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="province" class="form-label">Provincia</label>
                                <input type="text" class="form-control @error('province') is-invalid @enderror"
                                    id="province" name="province" required value="{{ old('province') }}">
                                @error('province')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="zip" class="form-label">Código Postal</label>
                                <input type="text" class="form-control @error('zip') is-invalid @enderror"
                                    id="zip" name="zip" required value="{{ old('zip') }}">
                                @error('zip')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="phone" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" required value="{{ old('phone') }}">
                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resumen de pago - Columna derecha -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm position-sticky" style="top: 20px;">
                    <div class="card-header bg-light py-3">
                        <h5 class="mb-0 fw-bold">Resumen de pago</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span>€{{ number_format($subtotal, 2) }}</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Envío</span>
                            <span>€{{ number_format($shipping, 2) }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold text-danger">€{{ number_format($total, 2) }}</span>
                        </div>

                        <!-- Información sobre pago con Stripe -->
                        <div class="mb-4">
                            <h6 class="mb-3">Método de pago</h6>
                            <div class="d-flex align-items-center mb-3">
                                <span class="me-3">Pago seguro con</span>
                                <img src="{{ asset('images/stripe-logo.png') }}" alt="Stripe" height="30">
                            </div>
                            <div class="d-flex mb-2">
                                <img src="{{ asset('images/credit-cards.png') }}" alt="Tarjetas aceptadas" class="img-fluid" style="max-height: 30px;">
                            </div>
                            <p class="small text-muted">Serás redirigido a la pasarela de pago seguro de Stripe para completar tu compra.</p>
                        </div>

                        <!-- Botón para finalizar compra -->
                        <button class="btn btn-danger w-100 py-3 fw-bold" type="submit">
                            Continuar al Pago
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    /* Estilos adicionales para la página de checkout */
    .card {
        border-radius: 10px;
    }

    .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
        border-color: #dc3545;
    }

    .form-check-input:checked {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .form-check-input:focus {
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
        border-color: #dc3545;
    }
</style>
@endpush