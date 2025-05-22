@extends('layouts.app')

@section('title', 'Añadir Usuario | F1 Collector')

@section('content')
<div class="product-form-page">
    <div class="container py-5">
        <!-- Header con breadcrumb -->
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.menu') }}" class="text-decoration-none"><i class="bi bi-speedometer2"></i> Panel</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Header principal -->
        <div class="row align-items-center mb-4">
            <div class="col-lg-6">
                <h1 class="h2 fw-bold mb-0 text-primary">
                    <i class="bi bi-people-fill me-2"></i>Gestión de Usuarios
                </h1>
                <p class="text-muted mt-2 mb-0">Administración de todos los usuarios registrados en la plataforma</p>
            </div>
            <div class="col-lg-6 mt-3 mt-lg-0 text-lg-end">
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Añadir Usuario
                </a>
                <a href="{{ route('admin.menu') }}" class="btn btn-outline-secondary ms-2">
                    <i class="bi bi-arrow-left me-1"></i> Volver al Panel
                </a>
            </div>
        </div>

        <!-- Resto del formulario -->
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="card-header bg-success text-white p-4">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-white bg-opacity-25 me-3">
                                <i class="bi bi-person-fill-add text-white fs-4"></i>
                            </div>
                            <div>
                                <h3 class="card-title mb-0 fw-bold">Añadir Nuevo Usuario</h3>
                                <p class="card-subtitle mb-0 text-white-50">Complete el formulario para registrar un nuevo usuario</p>
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
                                        <h5 class="alert-heading mb-1">Corrige los siguientes errores:</h5>
                                        <ul class="mb-0 ps-3">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf

                            <div class="row">
                                <!-- Columna izquierda -->
                                <div class="col-md-8 mb-4 mb-md-0">
                                    <div class="mb-4">
                                        <label for="name" class="form-label">Nombre completo</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="email" class="form-label">Correo electrónico</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="password" class="form-label">Contraseña</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="phone" class="form-label">Teléfono</label>
                                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                                    </div>

                                    <div class="mb-4">
                                        <label for="user_type" class="form-label">Tipo de usuario</label>
                                        <select class="form-select" id="user_type" name="user_type" required>
                                            <option value="">Selecciona tipo</option>
                                            <option value="Admin" {{ old('user_type') == 'Admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="Customer" {{ old('user_type') == 'Customer' ? 'selected' : '' }}>Cliente</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Dirección (opcional)</label>
                                        <input type="text" class="form-control mb-2" name="street" placeholder="Calle" value="{{ old('street') }}">
                                        <input type="text" class="form-control mb-2" name="city" placeholder="Ciudad" value="{{ old('city') }}">
                                        <input type="text" class="form-control mb-2" name="state" placeholder="Provincia" value="{{ old('state') }}">
                                        <input type="text" class="form-control mb-2" name="postal_code" placeholder="Código postal" value="{{ old('postal_code') }}">
                                        <input type="text" class="form-control" name="country" placeholder="País" value="{{ old('country') }}">
                                    </div>
                                </div>

                                <!-- Columna derecha -->
                                <div class="col-md-4">
                                    <div class="mb-4">
                                        <label for="avatar" class="form-label">Avatar del usuario</label>
                                        <div class="image-preview-container mb-2 d-flex justify-content-center align-items-center bg-light rounded" style="height: 220px; border: 2px dashed #dee2e6;">
                                            <div id="image-preview-placeholder" class="text-center p-3">
                                                <i class="bi bi-person-circle fs-1 text-muted"></i>
                                                <p class="mb-0 text-muted">Vista previa del avatar</p>
                                            </div>
                                            <img id="image-preview" class="img-fluid d-none" style="max-height: 100%; max-width: 100%;" alt="Vista previa">
                                        </div>
                                        <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
                                        <div class="form-text">
                                            Formatos permitidos: JPG, PNG, GIF, WEBP. Máximo 2MB.
                                        </div>
                                    </div>

                                    <div class="card bg-light border-0 mb-4">
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                <i class="bi bi-info-circle-fill text-primary me-2"></i>
                                                Sugerencias
                                            </h6>
                                            <ul class="mb-0 ps-3 small text-muted">
                                                <li>Usa una imagen clara y centrada</li>
                                                <li>Formato cuadrado o circular</li>
                                                <li>Tamaño mínimo sugerido: 200x200 píxeles</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-save me-1"></i> Guardar Usuario
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const avatarInput = document.getElementById('avatar');
        const avatarPreview = document.getElementById('image-preview');
        const placeholder = document.getElementById('image-preview-placeholder');

        avatarInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    avatarPreview.src = e.target.result;
                    avatarPreview.classList.remove('d-none');
                    placeholder.classList.add('d-none');
                }
                reader.readAsDataURL(file);
            } else {
                avatarPreview.classList.add('d-none');
                placeholder.classList.remove('d-none');
            }
        });
    });
</script>
@endpush

@push('styles')
<style>
    .icon-circle {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .form-control:focus, .form-select:focus {
        border-color: #198754;
        box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
    }

    .image-preview-container {
        transition: all 0.3s ease;
    }
</style>
@endpush
@endsection
