@extends('layouts.app')

@section('title', 'Escalas')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.scales.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i> Añadir Escala
        </a>

        <h1 class="h3 text-warning text-center flex-grow-1 m-0">Gestión de Escalas</h1>

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

    @if ($scales->isEmpty())
        <div class="alert alert-info text-center">No hay escalas registradas.</div>
    @else
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Valor</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($scales as $scale)
                    <tr>
                        <td>{{ $scale->id }}</td>
                        <td>{{ $scale->value }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.scales.edit', $scale) }}" class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                            <form action="{{ route('admin.scales.destroy', $scale) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar esta escala?')">
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
