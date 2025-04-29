@extends('layouts.app')

@section('title', 'Escalas')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-warning">Gestión de Escalas</h1>
        <div class="btn-group">
            <a href="{{ route('admin.scales.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle me-1"></i> Añadir Escala
            </a>
            <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="visually-hidden">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('admin.products.index') }}"><i class="bi bi-box-seam me-2 text-danger"></i>Gestionar productos</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.teams.index') }}"><i class="bi bi-gear-fill me-2 text-primary"></i>Gestionar escuderías</a></li>
            </ul>
        </div>
    </div>    

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
