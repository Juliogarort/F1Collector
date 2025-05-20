@extends('layouts.app')

@section('title', 'Gestión de Escuderías | F1 Collector')

@section('content')
<div class="teams-management">
    <div class="container py-5">
        <!-- Header con breadcrumb -->
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.menu') }}" class="text-decoration-none"><i class="bi bi-speedometer2"></i> Panel</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Escuderías</li>
                    </ol>
                </nav>
            </div>
        </div>
        
        <!-- Header principal -->
        <div class="row align-items-center mb-4">
            <div class="col-lg-6">
                <h1 class="h2 fw-bold mb-0">
                    <i class="bi bi-flag-fill me-2 text-primary"></i>Gestión de Escuderías
                </h1>
                <p class="text-muted mt-2 mb-0">Administración de escuderías para los modelos F1 Collector</p>
            </div>
            <div class="col-lg-6 mt-3 mt-lg-0 text-lg-end">
                <a href="{{ route('admin.teams.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Añadir Escudería
                </a>
                <a href="{{ route('admin.menu') }}" class="btn btn-outline-secondary ms-2">
                    <i class="bi bi-arrow-left me-1"></i> Volver al Panel
                </a>
            </div>
        </div>
        
        <!-- Alertas -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm border-start border-success border-4" role="alert">
                <div class="d-flex">
                    <div class="me-3">
                        <i class="bi bi-check-circle-fill fs-4"></i>
                    </div>
                    <div>
                        <h5 class="alert-heading mb-1">¡Operación exitosa!</h5>
                        <p class="mb-0">{!! session('success') !!}</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm border-start border-danger border-4" role="alert">
                <div class="d-flex">
                    <div class="me-3">
                        <i class="bi bi-exclamation-triangle-fill fs-4"></i>
                    </div>
                    <div>
                        <h5 class="alert-heading mb-1">¡Ha ocurrido un error!</h5>
                        <p class="mb-0">{!! session('error') !!}</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        <!-- Tabla de escuderías con diseño premium -->
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-bold text-primary">
                    <i class="bi bi-table me-2"></i>Listado de Escuderías
                </h5>
                <span class="badge bg-primary rounded-pill">{{ $teams->count() }} escuderías</span>
            </div>

            <div class="card-body p-0">
                @if ($teams->isEmpty())
                    <div class="text-center py-5">
                        <img src="{{ asset('images/empty-state.svg') }}" alt="No hay escuderías" class="img-fluid mb-3" style="max-width: 200px;">
                        <h4 class="text-muted">No hay escuderías registradas</h4>
                        <p class="text-muted mb-4">Comienza añadiendo la primera escudería para tus modelos de colección.</p>
                        <a href="{{ route('admin.teams.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i> Añadir Primera Escudería
                        </a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3 ps-4" style="width: 80px;">ID</th>
                                    <th class="py-3">Nombre</th>
                                    <th class="py-3">Productos</th>
                                    <th class="py-3 text-end pe-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                                @foreach ($teams as $team)
                                    <tr>
                                        <td class="ps-4">{{ $team->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="team-logo me-3 bg-light rounded-circle p-2">
                                                    <i class="bi bi-flag-fill text-primary"></i>
                                                </div>
                                                <span class="fw-medium">{{ $team->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $productCount = $team->products->count();
                                            @endphp
                                            <span class="badge bg-{{ $productCount > 0 ? 'success' : 'secondary' }} rounded-pill">
                                                {{ $productCount }} producto{{ $productCount != 1 ? 's' : '' }}
                                            </span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group">
                                                <a href="{{ route('admin.teams.edit', $team) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-pencil"></i>
                                                    <span class="d-none d-md-inline ms-1">Editar</span>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $team->id }}">
                                                    <i class="bi bi-trash"></i>
                                                    <span class="d-none d-md-inline ms-1">Eliminar</span>
                                                </button>
                                            </div>
                                            
                                            <!-- Modal de confirmación de eliminación -->
                                            <div class="modal fade" id="deleteModal{{ $team->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $team->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-danger text-white">
                                                            <h5 class="modal-title" id="deleteModalLabel{{ $team->id }}">
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
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            
            <div class="card-footer bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted small">Mostrando {{ $teams->count() }} escuderías</span>
                    <div>
                        <!-- Aquí iría la paginación si se implementa -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Estilos para la gestión de escuderías */
    .teams-management {
        background-color: #f8f9fa;
        min-height: 100vh;
    }
    
    .breadcrumb {
        font-size: 0.9rem;
        padding: 0.5rem 0;
    }
    
    .breadcrumb-item a {
        color: #6c757d;
        transition: color 0.3s ease;
    }
    
    .breadcrumb-item a:hover {
        color: #0d6efd;
    }
    
    .breadcrumb-item.active {
        color: #212529;
        font-weight: 500;
    }
    
    .h2 {
        background: linear-gradient(45deg, #0d6efd, #0a58ca);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        font-weight: 700;
    }
    
    .card {
        border-radius: 0.5rem;
        overflow: hidden;
        transition: box-shadow 0.3s ease;
    }
    
    .card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
    
    .table th {
        font-weight: 600;
        color: #495057;
        border-top: none;
    }
    
    .table td {
        vertical-align: middle;
        border-color: rgba(0, 0, 0, 0.05);
    }
    
    .team-logo {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #f8f9fa;
        font-size: 1.2rem;
    }
    
    .modal-content {
        border: none;
        border-radius: 0.5rem;
        overflow: hidden;
    }
    
    .modal-header {
        border-bottom: none;
    }
    
    .modal-footer {
        border-top: none;
    }
    
    /* Efecto de hover para los botones */
    .btn-outline-primary:hover, .btn-outline-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    /* Transición suave para los botones */
    .btn {
        transition: all 0.3s ease;
    }
    
    /* Estilo para los alerts */
    .alert {
        border-radius: 0.5rem;
    }
</style>
@endpush
@endsection