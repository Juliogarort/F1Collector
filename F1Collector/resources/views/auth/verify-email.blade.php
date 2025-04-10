@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h2>Verifica tu correo electrónico</h2>
    <p>Se ha enviado un correo de verificación a tu dirección.</p>
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="btn btn-primary mt-3">Reenviar correo</button>
    </form>
</div>

@if (Auth::check() && Auth::user()->hasVerifiedEmail())
    <script>
        window.location.href = '/';
    </script>
@endif
@endsection
