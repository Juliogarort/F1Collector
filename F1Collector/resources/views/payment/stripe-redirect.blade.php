<!-- resources/views/payment/stripe-redirect.blade.php -->
@extends('layouts.app')

@section('title', 'F1 Collector - Redireccionando a Stripe')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="mb-4">
                <img src="{{ asset('images/stripe-logo.png') }}" alt="Stripe" class="img-fluid mb-4" style="max-width: 180px;">
                <h3 class="mb-3">Redireccionando a Stripe para finalizar tu pago</h3>
                <p class="text-muted">Por favor, espera mientras te redireccionamos al portal de pago seguro...</p>
                <div class="spinner-border text-danger mt-3" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar Stripe
        const stripe = Stripe("{{ config('services.stripe.key') }}");
        
        // Redirigir a la página de checkout de Stripe
        stripe.redirectToCheckout({
            sessionId: "{{ $stripeSession->id }}"
        }).then(function (result) {
            if (result.error) {
                // Si hay un error, mostrar mensaje y redirigir a la página de error
                alert(result.error.message);
                window.location.href = "{{ route('payment.failed') }}";
            }
        });
    });
</script>
@endpush