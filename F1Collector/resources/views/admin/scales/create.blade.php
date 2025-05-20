@extends('layouts.app')

@section('title', 'Añadir Escala | F1 Collector')

@section('content')
<div class="scale-form-page">
    <div class="container py-5">
        <!-- Breadcrumb -->
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.menu') }}" class="text-decoration-none"><i class="bi bi-speedometer2"></i> Panel</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.scales.index') }}" class="text-decoration-none">Escalas</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Añadir</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Tarjeta principal -->
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="card-header bg-primary text-white p-4">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-white bg-opacity-25 me-3">
                                <i class="bi bi-rulers text-white fs-4"></i>
                            </div>
                            <div>
                                <h3 class="card-title mb-0 fw-bold">Añadir Nueva Escala</h3>
                                <p class="card-subtitle mb-0 text-white-50">Complete el formulario para registrar una nueva escala</p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger border-start border-danger border-4 mb-4">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <i class="bi bi-exclamation-triangle-fill fs-4"></i>
                                    </div>
                                    <div>
                                        <h5 class="alert-heading mb-1">Por favor corrige los siguientes errores:</h5>
                                        <ul class="mb-0 ps-3">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.scales.store') }}" class="needs-validation" novalidate>
                            @csrf

                            <div class="mb-4">
                                <label for="value" class="form-label">Valor de escala</label>
                                <input type="text" class="form-control @error('value') is-invalid @enderror" 
                                       id="value" name="value" required value="{{ old('value') }}">
                                @error('value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Ingrese el valor de la escala (Ej: 1:18, 1:43, 1:24, etc.).
                                </div>
                            </div>

                            <div class="row scale-examples mt-4 mb-3">
                                <div class="col-md-12">
                                    <h6 class="text-muted mb-3">Escalas comunes en modelos de F1:</h6>
                                    <div class="d-flex flex-wrap gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-secondary scale-suggestion" data-value="1:18">
                                            1:18
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary scale-suggestion" data-value="1:24">
                                            1:24
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary scale-suggestion" data-value="1:43">
                                            1:43
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary scale-suggestion" data-value="1:64">
                                            1:64
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary scale-suggestion" data-value="1:8">
                                            1:8
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                                <a href="{{ route('admin.scales.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i> Guardar Escala
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tarjeta de ayuda -->
                <div class="card border-0 shadow-sm rounded-3 mt-4">
                    <div class="card-body p-4">
                        <h5 class="card-title">
                            <i class="bi bi-info-circle-fill text-primary me-2"></i>
                            Información sobre escalas
                        </h5>
                        <p class="card-text">Las escalas indican la proporción entre el tamaño del modelo y el vehículo real. Por ejemplo:</p>
                        <ul class="mb-0">
                            <li><strong>1:18</strong> - Un modelo a escala 1:18 es 18 veces más pequeño que el vehículo real</li>
                            <li><strong>1:43</strong> - Escala popular para coleccionistas debido a su tamaño compacto</li>
                            <li><strong>1:8</strong> - Modelos de gran tamaño con alto nivel de detalle</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Script para autocompletar con sugerencias de escalas
        const suggestions = document.querySelectorAll('.scale-suggestion');
        const valueInput = document.getElementById('value');
        
        suggestions.forEach(suggestion => {
            suggestion.addEventListener('click', function() {
                valueInput.value = this.dataset.value;
                valueInput.focus();
            });
        });
        
        // Validación del formulario
        const form = document.querySelector('.needs-validation');
        
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            form.classList.add('was-validated');
        });
    });
</script>
@endpush
@endsection