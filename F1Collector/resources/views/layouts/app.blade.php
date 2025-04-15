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

    @yield('head')
    @stack('scripts')
</head>

<body data-verified="{{ Auth::check() && Auth::user()->hasVerifiedEmail() ? 'true' : 'false' }}">
    <div id="app">
        @include('layouts.header')

        <main class="py-4">
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
</body>

</html>