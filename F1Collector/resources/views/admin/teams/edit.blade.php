@extends('layouts.app')

@section('title', 'Editar Escudería | F1 Collector')

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
                        <li class="breadcrumb-item active" aria-current="page">Editar</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Tarjeta principal -->
                <div class="card border-0 shadow-sm rounded-3 ">
                    <div class="card-header header-edit  p-4">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle  bg-opacity-25 me-3">
                                <i class="bi bi-pencil-fill  fs-4"></i>
                            </div>
                            <div>
                                <h3 class="card-title mb-0 fw-bold">Editar Escudería</h3>
                                <p class="card-subtitle mb-0">Modificar información de la escudería "{{ $team->name }}"</p>
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

                        <form method="POST" action="{{ route('admin.teams.update', $team) }}" class="needs-validation" novalidate>
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="name" class="form-label">Nombre de la escudería</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" required value="{{ old('name', $team->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Actualice el nombre oficial de la escudería si es necesario.
                                </div>
                            </div>

                            @php
                                $productCount = $team->products->count();
                            @endphp
                            
                            @if($productCount > 0)
                                <div class="alert alert-info border-0 mb-4 products-alert">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <i class="bi bi-info-circle-fill fs-4"></i>
                                        </div>
                                        <div>
                                            <h5 class="alert-heading mb-1">Productos asociados</h5>
                                            <p class="mb-0">Esta escudería está siendo utilizada por {{ $productCount }} producto(s). Los cambios que realice se aplicarán a todos estos productos.</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                                <div>
                                    <a href="{{ route('admin.teams.index') }}" class="btn btn-outline-secondary">
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
                                    Historial de la escudería
                                </h5>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <h6 class="text-muted">Fecha de creación</h6>
                                            <p class="mb-0">{{ $team->created_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <h6 class="text-muted">Última actualización</h6>
                                            <p class="mb-0">{{ $team->updated_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <h6 class="text-muted">ID de la escudería</h6>
                                            <p class="mb-0">{{ $team->id }}</p>
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
                                <button type="button" class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteTeamModal">
                                    <i class="bi bi-trash me-2"></i>
                                    Eliminar escudería
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
<div class="modal fade" id="deleteTeamModal" tabindex="-1" aria-labelledby="deleteTeamModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteTeamModalLabel">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar la escudería <strong>{{ $team->name }}</strong>?</p>
                
                @if($productCount > 0)
                    <div class="alert alert-warning mb-0">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="bi bi-exclamation-triangle-fill fs-4"></i>
                            </div>
                            <div>
                                <strong>¡Atención!</strong> Esta escudería tiene {{ $productCount }} producto(s) asociado(s). Si la eliminas, deberás editar los productos para asignarles una nueva escudería.
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('admin.teams.destroy', $team) }}" method="POST" class="d-inline">
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