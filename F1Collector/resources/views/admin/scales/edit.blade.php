@extends('layouts.app')

@section('title', 'Editar Escala | F1 Collector')

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
                        <li class="breadcrumb-item active" aria-current="page">Editar</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Tarjeta principal -->
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="card-header bg-dark text-white p-4">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-white bg-opacity-25 me-3">
                                <i class="bi bi-pencil-fill text-white fs-4"></i>
                            </div>
                            <div>
                                <h3 class="card-title mb-0 fw-bold">Editar Escala</h3>
                                <p class="card-subtitle mb-0 text-white-50">Modificar información de la escala "{{ $scale->value }}"</p>
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

                        <form method="POST" action="{{ route('admin.scales.update', $scale) }}" class="needs-validation" novalidate>
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="value" class="form-label">Valor de escala</label>
                                <input type="text" class="form-control @error('value') is-invalid @enderror" 
                                       id="value" name="value" required value="{{ old('value', $scale->value) }}">
                                @error('value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Actualice el valor de la escala si es necesario.
                                </div>
                            </div>

                            @php
                                $productCount = $scale->products ? $scale->products->count() : 0;
                            @endphp
                            
                            @if($productCount > 0)
                                <div class="alert alert-info border-0 mb-4 products-alert">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <i class="bi bi-info-circle-fill fs-4"></i>
                                        </div>
                                        <div>
                                            <h5 class="alert-heading mb-1">Productos asociados</h5>
                                            <p class="mb-0">Esta escala está siendo utilizada por {{ $productCount }} producto(s). Los cambios que realice se aplicarán a todos estos productos.</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                                <div>
                                    <a href="{{ route('admin.scales.index') }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-left me-1"></i> Cancelar
                                    </a>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-dark">
                                        <i class="bi bi-check-circle me-1"></i> Guardar Cambios
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Información adicional -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card border-0 shadow-sm rounded-3">
                            <div class="card-body p-4">
                                <h5 class="card-title mb-3">
                                    <i class="bi bi-info-circle-fill text-secondary me-2"></i>
                                    Historial de la escala
                                </h5>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <h6 class="text-muted">Fecha de creación</h6>
                                            <p class="mb-0">{{ $scale->created_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <h6 class="text-muted">Última actualización</h6>
                                            <p class="mb-0">{{ $scale->updated_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <h6 class="text-muted">ID de la escala</h6>
                                            <p class="mb-0">{{ $scale->id }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <h6 class="text-muted">Productos asociados</h6>
                                            <p class="mb-0">
                                                <span class="badge bg-{{ $productCount > 0 ? 'success' : 'secondary' }} rounded-pill">
                                                    {{ $productCount }} producto{{ $productCount != 1 ? 's' : '' }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Acciones rápidas -->
                <div class="card border-0 shadow-sm rounded-3 mt-4">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-3">
                            <i class="bi bi-lightning-fill text-warning me-2"></i>
                            Acciones rápidas
                        </h5>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-dark w-100">
                                    <i class="bi bi-box-seam me-2"></i>
                                    Ver productos
                                </a>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteScaleModal">
                                    <i class="bi bi-trash me-2"></i>
                                    Eliminar escala
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación de eliminación -->
<div class="modal fade" id="deleteScaleModal" tabindex="-1" aria-labelledby="deleteScaleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteScaleModalLabel">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar la escala <strong>{{ $scale->value }}</strong>?</p>
                
                @if($productCount > 0)
                    <div class="alert alert-warning mb-0">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="bi bi-exclamation-triangle-fill fs-4"></i>
                            </div>
                            <div>
                                <strong>¡Atención!</strong> Esta escala tiene {{ $productCount }} producto(s) asociado(s). Si la eliminas, deberás editar los productos para asignarles una nueva escala.
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('admin.scales.destroy', $scale) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash-fill me-1"></i> Sí, eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
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