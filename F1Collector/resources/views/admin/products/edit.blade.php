@extends('layouts.app')

@section('title', 'Editar Producto | F1 Collector')

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
                        <li class="breadcrumb-item active" aria-current="page">Editar</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Tarjeta principal -->
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="card-header bg-dark text-white p-4">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-white bg-opacity-25 me-3">
                                <i class="bi bi-pencil-fill text-white fs-4"></i>
                            </div>
                            <div>
                                <h3 class="card-title mb-0 fw-bold">Editar Producto</h3>
                                <p class="card-subtitle mb-0 text-white-50">Modificar información del producto "{{ $product->name }}"</p>
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

                        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Columna izquierda -->
                                <div class="col-md-8 mb-4 mb-md-0">
                                    <div class="mb-4">
                                        <label for="name" class="form-label">Nombre del producto</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name', $product->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="description" class="form-label">Descripción</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                                  id="description" name="description" rows="4" required>{{ old('description', $product->description) }}</textarea>
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
                                                       id="price" name="price" value="{{ old('price', $product->price) }}" required>
                                            </div>
                                            @error('price')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-6 mb-4">
                                            <label for="year" class="form-label">Año</label>
                                            <input type="number" min="1950" max="{{ date('Y') }}" 
                                                   class="form-control @error('year') is-invalid @enderror" 
                                                   id="year" name="year" value="{{ old('year', $product->year) }}" required>
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
                                                    <option value="{{ $team->id }}" {{ old('team_id', $product->team_id) == $team->id ? 'selected' : '' }}>
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
                                                    <option value="{{ $scale->id }}" {{ old('scale_id', $product->scale_id) == $scale->id ? 'selected' : '' }}>
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
                                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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
                                            @if($product->image)
                                                <img id="image-preview" src="{{ asset($product->image) }}" class="img-fluid" 
                                                     style="max-height: 100%; max-width: 100%;" alt="Vista previa">
                                            @else
                                                <div id="image-preview-placeholder" class="text-center p-3">
                                                    <i class="bi bi-image fs-1 text-muted"></i>
                                                    <p class="mb-0 text-muted">No hay imagen</p>
                                                </div>
                                            @endif
                                        </div>
                                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                               id="image" name="image" accept="image/*">
                                        <input type="hidden" name="old_image" value="{{ $product->image }}">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            Deja vacío para mantener la imagen actual. Formatos permitidos: JPG, PNG, GIF, WEBP. Máximo 2MB.
                                        </div>
                                    </div>
                                    
                                    <!-- Información adicional -->
                                    <div class="card border-0 bg-light mb-4">
                                        <div class="card-body">
                                            <h6 class="card-title mb-3">
                                                <i class="bi bi-info-circle-fill text-secondary me-2"></i>
                                                Información del producto
                                            </h6>
                                            
                                            <div class="mb-2">
                                                <div class="text-muted small mb-1">ID del producto</div>
                                                <div class="fw-medium">{{ $product->id }}</div>
                                            </div>
                                            
                                            <div class="mb-2">
                                                <div class="text-muted small mb-1">Fecha de creación</div>
                                                <div class="fw-medium">{{ $product->created_at->format('d/m/Y H:i') }}</div>
                                            </div>
                                            
                                            <div>
                                                <div class="text-muted small mb-1">Última actualización</div>
                                                <div class="fw-medium">{{ $product->updated_at->format('d/m/Y H:i') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Acciones rápidas -->
                                    <div class="card border-0 shadow-sm rounded-3">
                                        <div class="card-body">
                                            <h6 class="card-title mb-3">
                                                <i class="bi bi-lightning-fill text-warning me-2"></i>
                                                Acciones rápidas
                                            </h6>
                                            
                                            <div class="d-grid gap-2">
                                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteProductModal">
                                                    <i class="bi bi-trash me-2"></i>
                                                    Eliminar producto
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-1"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-dark">
                                    <i class="bi bi-check-circle me-1"></i> Guardar Cambios
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación de eliminación -->
<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteProductModalLabel">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar el producto <strong>{{ $product->name }}</strong>?</p>
                
                <div class="alert alert-warning mb-0">
                    <div class="d-flex">
                        <div class="me-3">
                            <i class="bi bi-exclamation-triangle-fill fs-4"></i>
                        </div>
                        <div>
                            <strong>¡Atención!</strong> Esta acción eliminará permanentemente el producto de la base de datos y no se puede deshacer.
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline">
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
        // Vista previa de la imagen
        const imageInput = document.getElementById('image');
        const imagePreviewContainer = document.querySelector('.image-preview-container');
        const imagePreview = document.getElementById('image-preview');
        const imagePlaceholder = document.getElementById('image-preview-placeholder');
        
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (!imagePreview) {
                        // Si no existe aún el elemento de vista previa, crearlo
                        imagePreviewContainer.innerHTML = '';
                        const newImg = document.createElement('img');
                        newImg.id = 'image-preview';
                        newImg.classList.add('img-fluid');
                        newImg.style.maxHeight = '100%';
                        newImg.style.maxWidth = '100%';
                        newImg.alt = 'Vista previa';
                        newImg.src = e.target.result;
                        imagePreviewContainer.appendChild(newImg);
                    } else {
                        // Si ya existe, actualizar su src
                        imagePreview.src = e.target.result;
                        imagePreview.classList.remove('d-none');
                        
                        if (imagePlaceholder) {
                            imagePlaceholder.classList.add('d-none');
                        }
                    }
                }
                reader.readAsDataURL(file);
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
        border-color: #212529;
        box-shadow: 0 0 0 0.25rem rgba(33, 37, 41, 0.25);
    }
    
    .image-preview-container {
        transition: all 0.3s ease;
    }
    
    #image:focus + .image-preview-container {
        border-color: #212529;
    }
</style>
@endpush
@endsection