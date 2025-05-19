@extends('layouts.app')

@section('title', 'Escuderías')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.teams.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i> Añadir Escudería
        </a>

        <h1 class="h3 text-warning text-center flex-grow-1 m-0">Gestión de Escuderías</h1>

        <a href="{{ route('admin.menu') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Volver al Panel
        </a>
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

    @if ($teams->isEmpty())
        <div class="alert alert-info text-center">No hay escuderías registradas.</div>
    @else
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($teams as $team)
                    <tr>
                        <td>{{ $team->id }}</td>
                        <td>{{ $team->name }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.teams.edit', $team) }}" class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                            <form action="{{ route('admin.teams.destroy', $team) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Si eliminas esta escudería tendrás que editar los productos que tengan esta misma escudería, estás de acuerdo?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>


@endsection
