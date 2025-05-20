@extends('layouts.app')

@section('title', 'Añadir Producto | F1 Collector')

@section('content')
<div class="product-form-page">
    <div class="container py-5">
        <!-- Breadcrumb -->
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.menu') }}" class="text-decoration-none"><i class="bi bi-speedometer2"></i> Panel</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}" class="text-decoration-none">Productos</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Añadir</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Tarjeta principal -->
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="card-header bg-success text-white p-4">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-white bg-opacity-25 me-3">
                                <i class="bi bi-box-seam-fill text-white fs-4"></i>
                            </div>
                            <div>
                                <h3 class="card-title mb-0 fw-bold">Añadir Nuevo Producto</h3>
                                <p class="card-subtitle mb-0 text-white-50">Complete el formulario para registrar un nuevo producto</p>
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

                        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf

                            <div class="row">
                                <!-- Columna izquierda -->
                                <div class="col-md-8 mb-4 mb-md-0">
                                    <div class="mb-4">
                                        <label for="name" class="form-label">Nombre del producto</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="description" class="form-label">Descripción</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                                  id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label for="price" class="form-label">Precio (€)</label>
                                            <div class="input-group">
                                                <span class="input-group-text">€</span>
                                                <input type="number" step="0.01" min="0" 
                                                       class="form-control @error('price') is-invalid @enderror" 
                                                       id="price" name="price" value="{{ old('price') }}" required>
                                            </div>
                                            @error('price')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6 mb-4">
                                            <label for="year" class="form-label">Año</label>
                                            <input type="number" min="1950" max="{{ date('Y') }}" 
                                                   class="form-control @error('year') is-invalid @enderror" 
                                                   id="year" name="year" value="{{ old('year', date('Y')) }}" required>
                                            @error('year')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label for="team_id" class="form-label">Escudería</label>
                                            <select class="form-select @error('team_id') is-invalid @enderror" id="team_id" name="team_id" required>
                                                <option value="">Selecciona una escudería</option>
                                                @foreach($teams as $team)
                                                    <option value="{{ $team->id }}" {{ old('team_id') == $team->id ? 'selected' : '' }}>
                                                        {{ $team->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('team_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6 mb-4">
                                            <label for="scale_id" class="form-label">Escala</label>
                                            <select class="form-select @error('scale_id') is-invalid @enderror" id="scale_id" name="scale_id" required>
                                                <option value="">Selecciona una escala</option>
                                                @foreach($scales as $scale)
                                                    <option value="{{ $scale->id }}" {{ old('scale_id') == $scale->id ? 'selected' : '' }}>
                                                        {{ $scale->value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('scale_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="category_id" class="form-label">Categoría</label>
                                        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                            <option value="">Selecciona una categoría</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <!-- Columna derecha -->
                                <div class="col-md-4">
                                    <div class="mb-4">
                                        <label for="image" class="form-label">Imagen del producto</label>
                                        <div class="image-preview-container mb-2 d-flex justify-content-center align-items-center bg-light rounded" 
                                             style="height: 220px; border: 2px dashed #dee2e6;">
                                            <div id="image-preview-placeholder" class="text-center p-3">
                                                <i class="bi bi-image fs-1 text-muted"></i>
                                                <p class="mb-0 text-muted">Vista previa de la imagen</p>
                                            </div>
                                            <img id="image-preview" class="img-fluid d-none" style="max-height: 100%; max-width: 100%;" alt="Vista previa">
                                        </div>
                                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                               id="image" name="image" accept="image/*" required>
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
                                                <li>Usa imágenes con buena iluminación</li>
                                                <li>Recomendado: formato cuadrado o 4:3</li>
                                                <li>Resolución mínima: 800x600 píxeles</li>
                                                <li>Incluye el nombre del modelo y escudería en el título</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-save me-1"></i> Guardar Producto
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
        // Vista previa de la imagen
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('image-preview');
        const imagePlaceholder = document.getElementById('image-preview-placeholder');
        
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove('d-none');
                    imagePlaceholder.classList.add('d-none');
                }
                reader.readAsDataURL(file);
            } else {
                imagePreview.classList.add('d-none');
                imagePlaceholder.classList.remove('d-none');
            }
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
    
    #image:focus + .image-preview-container {
        border-color: #198754;
    }
</style>
@endpush
@endsection