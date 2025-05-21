@extends('layouts.app')

@section('title', 'Valorar producto')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-lg rounded-4 bg-light">
                <div class="card-header py-4 rounded-top-4 bg-primary  text-white">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-star-fill me-2 fs-4"></i>
                        <h4 class="mb-0 fw-bold">Valorar producto</h4>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="rounded-circle border border-3 border-primary-subtle me-3" style="width: 60px; height: 60px; object-fit: cover;">
                        <div>
                            <h5 class="fw-semibold mb-1 text-primary">{{ $product->name }}</h5>
                            <p class="text-muted mb-0 small">
                                {{ $product->team ? $product->team->name : 'Sin escudería' }} - 
                                Escala: {{ $product->scale ? $product->scale->value : 'Sin escala' }}
                            </p>
                        </div>
                    </div>

                    <form action="{{ route('valoraciones.store', $product) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-primary">Tu valoración</label>
                            <div class="text-center mb-3">
                                <div class="d-inline-flex gap-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                    <span class="star-wrapper" data-rating="{{ $i }}">
                                        <i class="bi bi-star-fill fs-2"></i>
                                    </span>
                                    @endfor
                                </div>
                            </div>
                            <input type="range" id="rating" name="puntuacion" class="form-range accent-primary" min="1" max="5" step="1" value="{{ old('puntuacion', 3) }}" required>
                            <div class="text-center mt-2">
                                <span class="badge bg-primary bg-gradient px-3 py-2">
                                    <span id="ratingValue">3</span> de 5 estrellas
                                </span>
                            </div>
                            @error('puntuacion')
                            <div class="alert alert-danger mt-3">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="comentario" class="form-label fw-semibold text-primary">
                                <i class="bi bi-chat-left-text me-2"></i>Tu opinión (opcional)
                            </label>
                            <textarea id="comentario" name="comentario" class="form-control bg-light border-primary-subtle" rows="4" placeholder="¿Qué te ha parecido este producto?">{{ old('comentario') }}</textarea>
                            @error('comentario')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary px-4 btn-lg">
                                <i class="bi bi-x-lg me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary px-4 btn-lg">
                                <i class="bi bi-send-fill me-2"></i>Enviar valoración
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .star-wrapper {
        cursor: pointer;
        transition: transform 0.1s;
    }
    .star-wrapper.active i {
        color: #ffc107;
        text-shadow: 0 0 6px #ffecb3;
        transform: scale(1.15);
    }
    .star-wrapper i {
        color: #dee2e6;
        transition: color 0.2s, text-shadow 0.2s, transform 0.1s;
    }
    .form-range::-webkit-slider-thumb {
        background: #0d6efd;
    }
    .form-range::-moz-range-thumb {
        background: #0d6efd;
    }
    .form-range::-ms-thumb {
        background: #0d6efd;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const rangeInput = document.querySelector('#rating');
        const stars = document.querySelectorAll('.star-wrapper');
        const ratingValue = document.querySelector('#ratingValue');

        function updateStars(value) {
            stars.forEach(star => star.classList.toggle('active', star.dataset.rating <= value));
            ratingValue.textContent = value;
        }

        rangeInput.addEventListener('input', () => updateStars(rangeInput.value));

        stars.forEach(star => {
            star.addEventListener('click', () => {
                rangeInput.value = star.dataset.rating;
                updateStars(star.dataset.rating);
            });
            star.addEventListener('mouseover', () => updateStars(star.dataset.rating));
        });

        document.querySelector('.d-inline-flex').addEventListener('mouseleave', () => updateStars(rangeInput.value));
        updateStars(rangeInput.value);
    });
</script>
@endpush
