@extends('layouts.app')

@section('title', 'Añadir Escudería | F1 Collector')

@section('content')
<div class="team-form-page">
    <div class="container py-5">
        <!-- Breadcrumb -->
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.menu') }}" class="text-decoration-none"><i class="bi bi-speedometer2"></i> Panel</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.teams.index') }}" class="text-decoration-none">Escuderías</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Añadir</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Tarjeta principal -->
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="card-header header-create  p-4">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle  bg-opacity-25 me-3">
                                <i class="bi bi-flag-fill  fs-4"></i>
                            </div>
                            <div>
                                <h3 class="card-title mb-0 fw-bold">Añadir Nueva Escudería</h3>
                                <p class="card-subtitle mb-0 ">Complete el formulario para registrar una nueva escudería</p>
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

                        <form method="POST" action="{{ route('admin.teams.store') }}" class="needs-validation" novalidate>
                            @csrf

                            <div class="mb-4">
                                <label for="name" class="form-label">Nombre de la escudería</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" required value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Ingrese el nombre oficial de la escudería (Ej: Ferrari, Red Bull Racing, Mercedes-AMG Petronas).
                                </div>
                            </div>

                            <div class="row form-examples mt-4 mb-3">
                                <div class="col-md-12">
                                    <h6 class="text-muted mb-3">Ejemplos de escuderías populares:</h6>
                                    <div class="d-flex flex-wrap gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-secondary team-suggestion" data-name="Ferrari">
                                            Ferrari
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary team-suggestion" data-name="Red Bull Racing">
                                            Red Bull Racing
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary team-suggestion" data-name="Mercedes-AMG Petronas">
                                            Mercedes-AMG Petronas
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary team-suggestion" data-name="McLaren">
                                            McLaren
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary team-suggestion" data-name="Aston Martin">
                                            Aston Martin
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                                <a href="{{ route('admin.teams.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-1"></i> Guardar Escudería
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
                            Información Importante
                        </h5>
                        <p class="card-text">Las escuderías son esenciales para organizar los productos en categorías reconocibles para los coleccionistas. Recuerde que:</p>
                        <ul class="mb-0">
                            <li>Cada escudería debe tener un nombre único</li>
                            <li>Una vez creada, podrá asociar productos a esta escudería</li>
                            <li>Para evitar confusiones, use los nombres oficiales de las escuderías</li>
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
        // Script para autocompletar con sugerencias de escuderías
        const suggestions = document.querySelectorAll('.team-suggestion');
        const nameInput = document.getElementById('name');
        
        suggestions.forEach(suggestion => {
            suggestion.addEventListener('click', function() {
                nameInput.value = this.dataset.name;
                nameInput.focus();
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