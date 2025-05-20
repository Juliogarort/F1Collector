<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', config('app.name', 'Laravel'))</title>
    <link rel="icon" href="{{ asset('images/logoferrari.png') }}" type="image/png">

    <!-- Tipografía -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Favicon
    <link rel="icon" type="image/png" href="{{ asset('images/Isotipo.png') }}"> -->

    <!-- Bootstrap & Iconos -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Toastify -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>


    <!-- Tus estilos y scripts compilados con Vite -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @vite(['resources/js/modalAuth.js'])
    @vite(['resources/js/profileModal.js'])

    @yield('head')
    @stack('scripts')
</head>

<body data-verified="{{ Auth::check() && Auth::user()->hasVerifiedEmail() ? 'true' : 'false' }}">
    <div id="app">
        @include('layouts.header')

        <main class="">
            @yield('content')
        </main>

        @include('layouts.footer')
    </div>

    @if(session('success'))
    <div id="success-message" class="d-none">{{ session('success') }}</div>
    @endif

    @if(session('error'))
    <div id="error-message" class="d-none">{{ session('error') }}</div>
    @endif

    @if (session('welcome_discount_code'))
    <!-- Modal de Código de Descuento -->
    <div class="modal fade" id="welcomeDiscountModal" tabindex="-1" aria-labelledby="welcomeDiscountLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="welcomeDiscountLabel">
                        🎉 ¡Bienvenido a F1 Collector!
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body text-center p-5">
                    <img src="{{ asset('images/fotomodaldescuento.jpg') }}" class="img-fluid mb-4" alt="F1 Car" style="max-height: 200px;">
                    <h4 class="fw-bold text-danger mb-3">¡Tienes un 20% de descuento en tu primer pedido!</h4>
                    <p class="mb-3">Usa este código en tu carrito o durante el pago:</p>
                    <div class="input-group justify-content-center" style="max-width: 400px; margin: auto;">
                        <input type="text" readonly class="form-control text-center border-danger fw-bold" id="discountCodeInput" value="{{ session('welcome_discount_code') }}">
                        <button class="btn btn-outline-danger" onclick="copyDiscountCode()">Copiar</button>
                    </div>
                    <small class="text-muted d-block mt-3">* Válido por 30 días y para un solo uso</small>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const welcomeModal = new bootstrap.Modal(document.getElementById('welcomeDiscountModal'));
            welcomeModal.show();

            // Una vez mostrado, hacemos una petición para borrar la variable de sesión
            fetch('{{ route('session.clear.discount') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });
        });

        function copyDiscountCode() {
            const input = document.getElementById("discountCodeInput");
            navigator.clipboard.writeText(input.value).then(() => {
                Toastify({
                    text: "¡Código copiado!",
                    duration: 3000,
                    gravity: "top",
                    position: "center",
                    backgroundColor: "#dc3545"
                }).showToast();
            });
        }
    </script>
@endif

</body>

</html>