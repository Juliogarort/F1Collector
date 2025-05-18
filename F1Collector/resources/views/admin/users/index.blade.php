@extends('layouts.app')

@section('title', 'Administración de Usuarios')

@section('content')
<div class="container py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <h1 class="h3 text-primary mb-3 mb-md-0">
            <i class="bi bi-people-fill me-2"></i>Gestión de Usuarios
        </h1>
        <a href="{{ route('admin.menu') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Volver al Panel
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {!! session('success') !!}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {!! session('error') !!}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    @if ($users->isEmpty())
        <div class="alert alert-info text-center p-4">
            <i class="bi bi-info-circle display-6 d-block mb-3"></i>
            <h5>No hay usuarios registrados</h5>
            <p class="mb-0">Todavía no se han registrado usuarios en el sistema.</p>
        </div>
    @else
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Listado de Usuarios</h5>
                    <span class="badge bg-primary rounded-pill">{{ $users->count() }} usuarios</span>
                </div>
            </div>
            <div class="card-body">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
                    @foreach ($users as $user)
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm user-card">
                            <!-- Badge de tipo de usuario -->
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge {{ $user->user_type === 'Admin' ? 'bg-danger' : 'bg-secondary' }}">
                                    {{ $user->user_type }}
                                </span>
                            </div>
                            
                            <!-- Contenido de la tarjeta -->
                            <div class="card-body text-center">
                                <!-- Avatar pequeño y circular usando img con dimensiones fijas -->
                                <div class="avatar-small mx-auto mb-3">
                                    <img src="{{ $user->avatar ? asset($user->avatar) : asset('images/default-avatar.webp') }}" 
                                         alt="{{ $user->name }}" width="40" height="40"
                                         class="img-fluid rounded-circle border"
                                         data-default-avatar="{{ asset('images/default-avatar.webp') }}"
                                         onerror="this.src=this.getAttribute('data-default-avatar')"
                                         >
                                </div>
                                
                                <!-- Información del usuario -->
                                <h5 class="card-title">{{ $user->name }}</h5>
                                <p class="card-text text-muted mb-1 small">{{ $user->email }}</p>
                                <p class="card-text small mb-1">
                                    <i class="bi bi-telephone me-1"></i>
                                    {{ $user->phone ?? 'No disponible' }}
                                </p>
                                <p class="card-text small text-muted">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    Registrado: {{ $user->created_at->format('d/m/Y') }}
                                </p>
                            </div>
                            
                            <!-- Acciones -->
                            <div class="card-footer bg-white border-top-0 p-3">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary flex-grow-1">
                                        <i class="bi bi-pencil-fill me-1"></i>Editar
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="flex-grow-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger w-100" 
                                            onclick="return confirm('¿Estás seguro de eliminar a {{ $user->name }}?')">
                                            <i class="bi bi-trash-fill me-1"></i>Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>

<style>
    /* Contenedor de avatar pequeño */
    .avatar-small {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    /* Asegurarse de que la imagen tiene tamaño y forma correctos */
    .avatar-small img {
        width: 40px !important;
        height: 40px !important;
        object-fit: cover !important;
        border-radius: 50% !important;
        border: 1px solid #f8f9fa !important;
    }
    
    /* Estilos para las tarjetas */
    .user-card {
        border-radius: 10px;
        transition: all 0.2s ease;
    }
    
    .user-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    
    /* Asegurar que el texto se recorte si es demasiado largo */
    .card-title, .card-text {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
    }
    
    /* Mejoras para botones */
    .btn {
        border-radius: 6px;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Forzar dimensiones correctas para las imágenes de avatar
    const avatarImgs = document.querySelectorAll('.avatar-small img');
    
    avatarImgs.forEach(function(img) {
        // Establecer dimensiones exactas
        img.width = 40;
        img.height = 40;
        img.style.width = '40px';
        img.style.height = '40px';
        img.style.objectFit = 'cover';
        img.style.borderRadius = '50%';
        
        // Manejar errores
        img.onerror = function() {
            this.src = "{{ asset('images/default-avatar.webp') }}";
        };
    });
});
</script>
@endsection