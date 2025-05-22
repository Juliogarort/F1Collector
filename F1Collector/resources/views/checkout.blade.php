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
    
    <form method="POST" action="{{ route('checkout.process') }}">
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
                                                    <small class="text-muted">{{ $item->product->team->name ?? 'Sin equipo' }}</small>
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
                                <input type="text" name="firstName" id="firstName"
                                    class="form-control @error('firstName') is-invalid @enderror"
                                    required
                                    value="{{ old('firstName', $address->first_name ?? '') }}">
                                @error('firstName')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="lastName" class="form-label">Apellidos</label>
                                <input type="text" name="lastName" id="lastName"
                                    class="form-control @error('lastName') is-invalid @enderror"
                                    required
                                    value="{{ old('lastName', $address->last_name ?? '') }}">
                                @error('lastName')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="address" class="form-label">Dirección</label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror"
                                    id="address" name="address" required value="{{ old('address', $address->street ?? '') }}">
                                @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-5">
                                <label for="city" class="form-label">Ciudad</label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror"
                                    id="city" name="city" required value="{{ old('city', $address->city ?? '') }}">
                                @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="province" class="form-label">Provincia</label>
                                <input type="text" class="form-control @error('province') is-invalid @enderror"
                                    id="province" name="province" required value="{{ old('province', $address->state ?? '') }}">
                                @error('province')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="zip" class="form-label">Código Postal</label>
                                <input type="text" class="form-control @error('zip') is-invalid @enderror"
                                    id="zip" name="zip" required value="{{ old('zip', $address->postal_code ?? '') }}">
                                @error('zip')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="phone" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" required value="{{ old('phone', Auth::user()->phone ?? '') }}">
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

                        <!-- Mostrar descuento si está aplicado -->
                        @if(isset($appliedDiscount) && $appliedDiscount)
                        <div class="d-flex justify-content-between mb-2 text-success">
                            <span>
                                <i class="bi bi-percent me-1"></i>
                                Descuento ({{ $appliedDiscount['code'] }})
                            </span>
                            <span>-€{{ number_format($discountAmount, 2) }}</span>
                        </div>
                        @endif

                        <hr>

                        <!-- Sección de código de descuento -->
                        @if(!isset($appliedDiscount) || !$appliedDiscount)
                        <div class="mb-3">
                            <label for="discount_code" class="form-label fw-bold">Código de descuento</label>
                            <div class="input-group">
                                <input type="text" 
                                       name="discount_code" 
                                       id="discount_code" 
                                       class="form-control border-danger" 
                                       placeholder="Introduce tu código" 
                                       value="{{ old('discount_code') }}">
                                <button type="button" 
                                        class="btn btn-outline-danger" 
                                        onclick="applyDiscount()">
                                    <i class="bi bi-check me-1"></i>Aplicar
                                </button>
                            </div>
                            <small class="text-muted">¿Tienes un código de descuento? Introdúcelo aquí</small>
                        </div>
                        @else
                        <div class="mb-3">
                            <div class="alert alert-success d-flex justify-content-between align-items-center py-2">
                                <span>
                                    <i class="bi bi-check-circle me-2"></i>
                                    Código aplicado: <strong>{{ $appliedDiscount['code'] }}</strong>
                                </span>
                                <button type="button" 
                                        class="btn btn-sm btn-outline-danger" 
                                        onclick="removeDiscount()"
                                        title="Quitar descuento">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        </div>
                        @endif

                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold text-danger">€{{ number_format($total, 2) }}</span>
                        </div>

                        <!-- Información sobre pago con Stripe -->
                        <div class="mb-4">
                            <h6 class="mb-3">Método de pago</h6>
                            <div class="d-flex align-items-center mb-3">
                                <span class="me-3">Pago seguro con</span>
                                @if(file_exists(public_path('images/stripe-logo.png')))
                                <img src="{{ asset('images/stripe-logo.png') }}" alt="Stripe" height="30">
                                @else
                                <span class="badge bg-primary">Stripe</span>
                                @endif
                            </div>
                            <div class="d-flex mb-2">
                                @if(file_exists(public_path('images/credit-cards.png')))
                                <img src="{{ asset('images/credit-cards.png') }}" alt="Tarjetas aceptadas" class="img-fluid" style="max-height: 30px;">
                                @else
                                <div class="d-flex">
                                    <span class="badge bg-secondary me-1">VISA</span>
                                    <span class="badge bg-secondary me-1">MasterCard</span>
                                    <span class="badge bg-secondary">American Express</span>
                                </div>
                                @endif
                            </div>
                            <p class="small text-muted">Serás redirigido a la pasarela de pago seguro de Stripe para completar tu compra.</p>
                        </div>

                        <!-- Mostrar ahorro si hay descuento -->
                        @if(isset($appliedDiscount) && $appliedDiscount)
                        <div class="alert alert-info mb-3">
                            <i class="bi bi-piggy-bank me-2"></i>
                            <strong>¡Ahorras €{{ number_format($discountAmount, 2) }}!</strong>
                        </div>
                        @endif

                        <!-- Botón para finalizar compra -->
                        <button class="btn btn-danger w-100 py-3 fw-bold" type="submit">
                            <i class="bi bi-credit-card me-2"></i>
                            Continuar al Pago
                        </button>

                        <!-- Política de seguridad -->
                        <div class="text-center mt-3">
                            <small class="text-muted">
                                <i class="bi bi-shield-check me-1"></i>
                                Compra 100% segura y protegida
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Formularios ocultos para descuentos -->
<form id="applyDiscountForm" method="POST" action="{{ route('cart.applyDiscount') }}" style="display: none;">
    @csrf
    <input type="hidden" name="discount_code" id="hiddenDiscountCode">
</form>

<form id="removeDiscountForm" method="POST" action="{{ route('cart.removeDiscount') }}" style="display: none;">
    @csrf
</form>
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

    .alert {
        border-radius: 8px;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
    }

    .input-group .btn {
        border-radius: 0 0.375rem 0.375rem 0;
    }

    .input-group .form-control {
        border-radius: 0.375rem 0 0 0.375rem;
    }

    /* Animación para el botón de aplicar descuento */
    .btn-outline-danger {
        transition: all 0.3s ease;
    }

    /* Estilo para el alert de descuento aplicado */
    .alert-success {
        background-color: rgba(25, 135, 84, 0.1);
        border-color: rgba(25, 135, 84, 0.2);
        color: #0f5132;
    }

    /* Estilo para el alert de ahorro */
    .alert-info {
        background-color: rgba(13, 110, 253, 0.1);
        border-color: rgba(13, 110, 253, 0.2);
        color: #055160;
    }

    /* Mejora visual para badges */
    .badge {
        font-size: 0.75rem;
    }
</style>
@endpush

@push('scripts')
<script>
function applyDiscount() {
    const discountCode = document.getElementById('discount_code').value.trim();
    
    if (!discountCode) {
        // Mostrar alerta más elegante
        showAlert('Por favor, introduce un código de descuento', 'warning');
        return;
    }
    
    // Deshabilitar el botón mientras se procesa
    const button = event.target;
    const originalText = button.innerHTML;
    button.disabled = true;
    button.innerHTML = '<i class="bi bi-hourglass-split"></i> Aplicando...';
    
    document.getElementById('hiddenDiscountCode').value = discountCode;
    document.getElementById('applyDiscountForm').submit();
}

function removeDiscount() {
    if (confirm('¿Estás seguro de que quieres quitar el descuento?')) {
        document.getElementById('removeDiscountForm').submit();
    }
}

function showAlert(message, type = 'info') {
    // Crear alerta temporal
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    alertDiv.style.top = '20px';
    alertDiv.style.right = '20px';
    alertDiv.style.zIndex = '9999';
    alertDiv.style.minWidth = '300px';
    
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(alertDiv);
    
    // Remover después de 5 segundos
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}

// Permitir aplicar descuento con Enter
document.addEventListener('DOMContentLoaded', function() {
    const discountInput = document.getElementById('discount_code');
    if (discountInput) {
        discountInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                applyDiscount();
            }
        });
    }
});

// Validación en tiempo real del código de descuento
document.addEventListener('DOMContentLoaded', function() {
    const discountInput = document.getElementById('discount_code');
    if (discountInput) {
        discountInput.addEventListener('input', function() {
            const value = this.value.trim();
            const applyButton = document.querySelector('[onclick="applyDiscount()"]');
            
            if (value.length > 0) {
                applyButton.disabled = false;
                applyButton.classList.remove('btn-outline-danger');
                applyButton.classList.add('btn-danger');
            } else {
                applyButton.disabled = true;
                applyButton.classList.remove('btn-danger');
                applyButton.classList.add('btn-outline-danger');
            }
        });
    }
});
</script>
@endpush