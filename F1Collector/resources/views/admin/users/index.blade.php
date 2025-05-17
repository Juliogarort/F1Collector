@extends('layouts.app')

@section('title', 'Administración de Usuarios')

@section('content')
<div class="container py-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <h1 class="h3 text-primary mb-3 mb-md-0">Gestión de Usuarios</h1>
        <div class="btn-group">
            <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-gear me-1"></i> Opciones
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('admin.products.index') }}"><i class="bi bi-box-seam me-2 text-danger"></i>Gestionar productos</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.teams.index') }}"><i class="bi bi-flag me-2 text-primary"></i>Gestionar escuderías</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.scales.index') }}"><i class="bi bi-rulers me-2 text-warning"></i>Gestionar escalas</a></li>
            </ul>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
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
        <div class="alert alert-info text-center">No hay usuarios registrados.</div>
    @else
        <div class="card shadow-sm mb-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="d-none d-md-table-cell">ID</th>
                                <th>Usuario</th>
                                <th class="d-none d-lg-table-cell">Email</th>
                                <th class="d-none d-xl-table-cell">Teléfono</th>
                                <th>Tipo</th>
                                <th class="d-none d-md-table-cell">Registro</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td class="d-none d-md-table-cell">{{ $user->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($user->avatar)
                                            <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" class="rounded-circle me-2" width="32" height="32" style="object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-light text-secondary d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                                <i class="bi bi-person-fill"></i>
                                            </div>
                                        @endif
                                        <span>{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="d-none d-lg-table-cell">{{ $user->email }}</td>
                                <td class="d-none d-xl-table-cell">{{ $user->phone ?? 'No disponible' }}</td>
                                <td>
                                    <span class="badge {{ $user->user_type === 'Admin' ? 'bg-primary' : 'bg-secondary' }}">
                                        {{ $user->user_type }}
                                    </span>
                                </td>
                                <td class="d-none d-md-table-cell">{{ $user->created_at->format('d/m/Y') }}</td>
                                <td class="text-end">
                                    <div class="btn-group">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i><span class="d-none d-md-inline"> Editar</span>
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar este usuario? Esta acción no se puede deshacer.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i><span class="d-none d-md-inline"> Eliminar</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection