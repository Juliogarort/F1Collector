@extends('layouts.app')

@section('title', 'F1 Collector - Catálogo de Modelos')

@section('head')
<!-- Fonts para el catálogo -->
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    /* Variables CSS para F1 Catálogo - Siguiendo el diseño de welcome */
    :root {
        --f1-red: #FF1801;
        --f1-dark: #0C0C0C;
        --f1-silver: #C5C5C5;
        --f1-gold: #FFD700;
        --f1-carbon: #1A1A1A;
        --gradient-primary: linear-gradient(135deg, #FF1801 0%, #000000 100%);
        --gradient-secondary: linear-gradient(45deg, #FFD700 0%, #FF1801 100%);
        --shadow-light: rgba(255, 24, 1, 0.1);
        --shadow-medium: rgba(255, 24, 1, 0.2);
        --shadow-strong: rgba(255, 24, 1, 0.3);
    }

    body {
        background: linear-gradient(180deg, var(--f1-dark) 0%, var(--f1-carbon) 100%);
        color: var(--f1-silver);
        min-height: 100vh;
    }

    /* Hero Header del Catálogo - Siguiendo el estilo de welcome */
    .catalog-header {
        height: 60vh;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background: var(--gradient-primary);
    }

    .catalog-header::before {
        content: '';
        position: absolute;
        top: -20%;
        left: 0;
        width: 100%;
        height: 120%;
        background-image: url('/images/contacto/spa.webp');
        background-size: cover;
        background-attachment: fixed;
        z-index: -1;
        opacity: 0.3;
    }

    .catalog-header::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255, 24, 1, 0.2), rgba(0, 0, 0, 0.4));
        animation: pulse 6s ease-in-out infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 0.3;
        }

        50% {
            opacity: 0.6;
        }
    }

    .catalog-title {
        font-family: 'Orbitron', monospace;
        font-weight: 900;
        font-size: clamp(3rem, 8vw, 5rem);
        background: var(--gradient-secondary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-transform: uppercase;
        letter-spacing: 3px;
        margin-bottom: 1rem;
        position: relative;
        z-index: 10;
        animation: glow 2s ease-in-out infinite alternate;
    }

    @keyframes glow {
        from {
            filter: drop-shadow(0 0 20px rgba(255, 24, 1, 0.5));
        }

        to {
            filter: drop-shadow(0 0 40px rgba(255, 24, 1, 0.8));
        }
    }

    .catalog-subtitle {
        font-size: 1.3rem;
        color: rgba(255, 255, 255, 0.9);
        position: relative;
        z-index: 10;
        font-weight: 300;
    }

    /* Floating Elements - Como en welcome */
    .floating-element {
        position: absolute;
        font-size: 3rem;
        color: var(--f1-red);
        opacity: 0.1;
        animation: float 6s ease-in-out infinite;
        z-index: 1;
    }

    .floating-element:nth-child(1) {
        top: 20%;
        left: 10%;
        animation-delay: 0s;
    }

    .floating-element:nth-child(2) {
        top: 60%;
        right: 15%;
        animation-delay: 2s;
    }

    .floating-element:nth-child(3) {
        bottom: 20%;
        left: 20%;
        animation-delay: 4s;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0px) rotate(0deg);
        }

        50% {
            transform: translateY(-20px) rotate(5deg);
        }
    }

    /* Filtros con estilo F1 */
    .filters-section {
        background: linear-gradient(145deg, rgba(255, 24, 1, 0.05), rgba(0, 0, 0, 0.8));
        border: 1px solid rgba(255, 24, 1, 0.2);
        border-radius: 20px;
        box-shadow: 0 20px 40px var(--shadow-medium);
        position: sticky;
        top: 100px;
        z-index: 10;
        overflow: hidden;
    }

    .filters-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.05), transparent);
        transition: left 0.6s;
    }

    .filters-section:hover::before {
        left: 100%;
    }

    .filters-header {
        background: var(--gradient-primary);
        border-radius: 20px 20px 0 0;
        padding: 25px;
        border-bottom: none;
    }

    .filters-title {
        font-family: 'Orbitron', monospace;
        font-weight: 700;
        margin: 0;
        color: white;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 1.1rem;
    }

    .filter-group {
        padding: 25px;
        border-bottom: 1px solid rgba(255, 24, 1, 0.1);
        position: relative;
    }

    .filter-group:last-child {
        border-bottom: none;
    }

    .filter-toggle {
        background: linear-gradient(145deg, rgba(255, 24, 1, 0.1), rgba(0, 0, 0, 0.3));
        border: 1px solid rgba(255, 24, 1, 0.3);
        color: white;
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.4s ease;
        font-size: 0.9rem;
        border-radius: 12px;
    }

    .filter-toggle:hover {
        background: var(--gradient-primary);
        border-color: var(--f1-red);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px var(--shadow-medium);
    }

    .filter-toggle[aria-expanded="true"] {
        background: var(--gradient-primary);
        color: white;
        border-color: var(--f1-red);
        box-shadow: 0 4px 15px var(--shadow-medium);
    }

    .filter-toggle[aria-expanded="false"] {
        color: white;

    }

    .filter-content {
        background: rgba(26, 26, 26, 0.9);
        border: 1px solid rgba(255, 24, 1, 0.2);
        border-radius: 12px;
        max-height: 300px;
        overflow-y: auto;
        backdrop-filter: blur(10px);
    }

    .filter-content::-webkit-scrollbar {
        width: 8px;
    }

    .filter-content::-webkit-scrollbar-track {
        background: rgba(26, 26, 26, 0.5);
        border-radius: 4px;
    }

    .filter-content::-webkit-scrollbar-thumb {
        background: var(--f1-red);
        border-radius: 4px;
    }

    .form-check-input:checked {
        background-color: var(--f1-red);
        border-color: var(--f1-red);
        box-shadow: 0 0 10px rgba(255, 24, 1, 0.5);
    }

    .form-check-input:focus {
        border-color: var(--f1-red);
        box-shadow: 0 0 0 0.25rem rgba(255, 24, 1, 0.25);
    }

    .form-check-label {
        color: var(--f1-silver);
        font-weight: 500;
        font-size: 0.9rem;
        transition: color 0.3s ease;
    }

    .form-check-label:hover {
        color: white;
    }

    .search-box input {
        background: rgba(26, 26, 26, 0.8);
        border: 1px solid rgba(255, 24, 1, 0.3);
        color: white;
        border-radius: 10px;
        font-size: 0.9rem;
        backdrop-filter: blur(5px);
    }

    .search-box input:focus {
        background: rgba(26, 26, 26, 0.9);
        border-color: var(--f1-red);
        color: white;
        box-shadow: 0 0 15px rgba(255, 24, 1, 0.3);
    }

    .search-box input::placeholder {
        color: var(--f1-silver);
    }

    /* Botones con estilo F1 */
    .btn-f1-primary {
        background: var(--gradient-primary);
        border: none;
        color: white;
        padding: 12px 25px;
        border-radius: 25px;
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.4s ease;
        font-size: 0.9rem;
        box-shadow: 0 4px 15px var(--shadow-medium);
    }

    .btn-f1-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px var(--shadow-strong);
        color: white;
    }

    .btn-f1-outline {
        background: transparent;
        border: 2px solid var(--f1-red);
        color: var(--f1-red);
        padding: 8px 20px;
        border-radius: 20px;
        font-weight: 600;
        transition: all 0.3s ease;
        font-size: 0.8rem;
    }

    .btn-f1-outline:hover {
        background: var(--f1-red);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px var(--shadow-medium);
    }

    .filter-label {
        color: white;
        font-family: 'Orbitron', monospace;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.85rem;
        margin-bottom: 0;
    }

    /* Barra de ordenamiento */
    .sort-bar {
        background: linear-gradient(145deg, rgba(255, 24, 1, 0.05), rgba(0, 0, 0, 0.8));
        border: 1px solid rgba(255, 24, 1, 0.2);
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px var(--shadow-light);
        backdrop-filter: blur(10px);
    }

    .sort-bar select {
        background: rgba(26, 26, 26, 0.8);
        border: 1px solid rgba(255, 24, 1, 0.3);
        color: white;
        border-radius: 10px;
        font-size: 0.9rem;
        backdrop-filter: blur(5px);
    }

    .sort-bar select:focus {
        background: rgba(26, 26, 26, 0.9);
        border-color: var(--f1-red);
        color: white;
        box-shadow: 0 0 15px rgba(255, 24, 1, 0.3);
    }

    .sort-bar select option {
        background: var(--f1-carbon);
        color: white;
    }

    /* Cards de Productos - Estilo F1 Premium */
    .product-card {
        background: linear-gradient(145deg, rgba(255, 24, 1, 0.05), rgba(0, 0, 0, 0.8));
        border: 1px solid rgba(255, 24, 1, 0.2);
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.5s ease;
        position: relative;
        height: 100%;
        box-shadow: 0 10px 30px var(--shadow-light);
        display: flex;
        flex-direction: column;
        backdrop-filter: blur(10px);
    }

    .product-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transition: left 0.6s;
        z-index: 1;
    }

    .product-card:hover::before {
        left: 100%;
    }

    .product-card:hover {
        transform: translateY(-10px) scale(1.02);
        border-color: var(--f1-red);
        box-shadow: 0 25px 50px var(--shadow-strong);
    }

    .product-img-container {
        position: relative;
        height: 250px;
        overflow: hidden;
        background: var(--f1-carbon);
    }

    .product-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .product-card:hover .product-img {
        transform: scale(1.1);
    }

    .product-overlay {
        position: absolute;
        bottom: -80px;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(255, 24, 1, 0.9), transparent);
        padding: 20px;
        transition: bottom 0.5s ease;
        text-align: center;
    }

    .product-card:hover .product-overlay {
        bottom: 0;
    }

    .year-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: var(--gradient-secondary);
        color: var(--f1-dark);
        padding: 8px 15px;
        border-radius: 20px;
        font-family: 'Orbitron', monospace;
        font-weight: 700;
        font-size: 0.8rem;
        z-index: 2;
        box-shadow: 0 4px 15px rgba(255, 215, 0, 0.4);
    }

    .card-body {
        padding: 30px;
        position: relative;
        z-index: 2;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .team-name {
        color: var(--f1-gold);
        font-family: 'Orbitron', monospace;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
    }

    .product-title {
        font-family: 'Orbitron', monospace;
        font-weight: 700;
        color: white;
        font-size: 1.2rem;
        margin-bottom: 15px;
        line-height: 1.3;
    }

    .scale-info {
        color: var(--f1-silver);
        font-size: 0.9rem;
        margin-bottom: 15px;
        font-weight: 500;
    }

    .product-rating {
        margin-bottom: 15px;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .product-rating:hover {
        transform: scale(1.05);
    }

    .stars {
        color: var(--f1-gold);
        filter: drop-shadow(0 0 5px rgba(255, 215, 0, 0.5));
    }

    .rating-info {
        color: var(--f1-silver);
        font-size: 0.8rem;
        font-weight: 500;
    }

    .product-description {
        color: var(--f1-silver);
        font-size: 0.9rem;
        line-height: 1.6;
        margin-bottom: 20px;
        flex-grow: 1;
    }

    .product-price {
        font-family: 'Orbitron', monospace;
        font-weight: 700;
        font-size: 1.4rem;
        background: var(--gradient-secondary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 25px;
    }

    .product-actions {
        margin-top: auto;
        padding-top: 20px;
    }

    /* Botones de Acción F1 */
    .btn-wishlist {
        background: rgba(26, 26, 26, 0.8);
        border: 2px solid rgba(255, 24, 1, 0.3);
        color: var(--f1-silver);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.4s ease;
        backdrop-filter: blur(10px);
    }

    .btn-wishlist:hover {
        background: rgba(255, 24, 1, 0.1);
        border-color: var(--f1-red);
        color: var(--f1-red);
        transform: scale(1.1);
        box-shadow: 0 0 20px rgba(255, 24, 1, 0.4);
    }

    .btn-wishlist.active {
        background: var(--gradient-primary);
        border-color: var(--f1-red);
        color: white;
        box-shadow: 0 0 20px var(--shadow-medium);
    }

    .btn-add-cart {
        background: var(--gradient-primary);
        border: none;
        color: white;
        padding: 15px 25px;
        border-radius: 25px;
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.4s ease;
        font-size: 0.9rem;
        box-shadow: 0 4px 15px var(--shadow-medium);
    }

    .btn-add-cart:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px var(--shadow-strong);
        color: white;
    }

    .btn-details {
        background: rgba(52, 152, 219, 0.2);
        border: 1px solid rgba(52, 152, 219, 0.5);
        color: #3498db;
        padding: 10px 20px;
        border-radius: 20px;
        font-weight: 600;
        transition: all 0.3s ease;
        font-size: 0.85rem;
        backdrop-filter: blur(5px);
    }

    .btn-details:hover {
        background: #3498db;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(52, 152, 219, 0.4);
    }

    /* Login Alert F1 Style */
    .login-required {
        background: rgba(26, 26, 26, 0.8);
        border: 1px solid rgba(255, 24, 1, 0.2);
        border-radius: 15px;
        padding: 25px;
        text-align: center;
        box-shadow: 0 10px 30px var(--shadow-light);
        backdrop-filter: blur(10px);
    }

    .login-required p {
        color: var(--f1-silver) !important;
        margin-bottom: 20px;
        font-weight: 500;
    }

    .btn-login {
        background: var(--gradient-primary);
        border: none;
        color: white;
        padding: 12px 30px;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.4s ease;
        font-size: 0.9rem;
        box-shadow: 0 4px 15px var(--shadow-medium);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-login:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px var(--shadow-strong);
        color: white;
    }

    /* Paginación F1 Style */
    .pagination-container {
        background: linear-gradient(145deg, rgba(255, 24, 1, 0.05), rgba(0, 0, 0, 0.8));
        border: 1px solid rgba(255, 24, 1, 0.2);
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 10px 30px var(--shadow-light);
        backdrop-filter: blur(10px);
    }

    .pagination .page-link {
        color: var(--f1-silver);
        border-color: rgba(255, 24, 1, 0.3);
        background: rgba(26, 26, 26, 0.8);
        margin: 0 5px;
        border-radius: 10px;
        backdrop-filter: blur(5px);
    }

    .pagination .page-link:hover {
        color: white;
        border-color: var(--f1-red);
        background: rgba(255, 24, 1, 0.2);
        box-shadow: 0 0 15px rgba(255, 24, 1, 0.3);
    }

    .pagination .page-item.active .page-link {
        background: var(--gradient-primary);
        border-color: var(--f1-red);
        color: white;
        box-shadow: 0 0 15px var(--shadow-medium);
    }

    /* Animaciones de entrada */
    .fade-in {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s ease;
    }

    .fade-in.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .product-card {
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 0.8s ease forwards;
    }

    .product-card:nth-child(1) {
        animation-delay: 0.1s;
    }

    .product-card:nth-child(2) {
        animation-delay: 0.2s;
    }

    .product-card:nth-child(3) {
        animation-delay: 0.3s;
    }

    .product-card:nth-child(4) {
        animation-delay: 0.4s;
    }

    .product-card:nth-child(5) {
        animation-delay: 0.5s;
    }

    .product-card:nth-child(6) {
        animation-delay: 0.6s;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive F1 Style */
    @media (max-width: 991.98px) {
        .filters-section {
            position: relative;
            top: 0;
            margin-bottom: 30px;
        }

        .catalog-title {
            font-size: 3rem;
        }

        .product-card {
            margin-bottom: 30px;
        }
    }

    @media (max-width: 768px) {
        .catalog-title {
            font-size: 2.5rem;
        }

        .catalog-header {
            height: 50vh;
            padding: 40px 0;
        }

        .btn-add-cart,
        .btn-login {
            font-size: 0.8rem;
            padding: 12px 20px;
        }

        .btn-wishlist {
            width: 45px;
            height: 45px;
        }
    }

    /* Modal F1 Style */
    .modal-rating .modal-content {
        background: linear-gradient(145deg, rgba(0, 0, 0, 0.95), rgba(26, 26, 26, 0.95));
        border: 1px solid rgba(255, 24, 1, 0.3);
        border-radius: 20px;
        backdrop-filter: blur(20px);
    }

    .modal-rating .modal-header {
        background: var(--gradient-primary);
        border-radius: 20px 20px 0 0;
        border-bottom: 1px solid rgba(255, 24, 1, 0.3);
    }

    .modal-rating .modal-body {
        background: rgba(0, 0, 0, 0.8);
        color: var(--f1-silver);
    }

    .modal-rating .modal-footer {
        background: rgba(26, 26, 26, 0.9);
        border-top: 1px solid rgba(255, 24, 1, 0.2);
        border-radius: 0 0 20px 20px;
    }

    .valoraciones-lista {
        max-height: 350px;
        overflow-y: auto;
    }

    .valoraciones-lista::-webkit-scrollbar {
        width: 8px;
    }

    .valoraciones-lista::-webkit-scrollbar-track {
        background: rgba(26, 26, 26, 0.5);
        border-radius: 4px;
    }

    .valoraciones-lista::-webkit-scrollbar-thumb {
        background: var(--f1-red);
        border-radius: 4px;
    }

    .valoraciones-lista .card {
        background: rgba(26, 26, 26, 0.8);
        border: 1px solid rgba(255, 24, 1, 0.1);
        backdrop-filter: blur(10px);
    }
</style>
@endsection

@section('content')
<div class="container-fluid p-0">
    {{-- Cabecera del Catálogo - Estilo F1 --}}
    <header class="catalog-header">
        <div class="floating-element"><i class="fas fa-racing-flag"></i></div>
        <div class="floating-element"><i class="fas fa-trophy"></i></div>
        <div class="floating-element"><i class="fas fa-stopwatch"></i></div>

        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 text-center">
                    <h1 class="catalog-title">Catálogo Premium</h1>
                    <p class="catalog-subtitle">Explora nuestra exclusiva colección de modelos a escala de F1</p>
                </div>
            </div>
        </div>
    </header>

    {{-- Sección de Filtros y Productos --}}
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                {{-- Columna izquierda con el formulario --}}
                <div class="col-lg-3 mb-4 mb-lg-0">
                    <form method="GET" action="{{ route('catalogo') }}" id="filter-form">
                        <div class="filters-section">
                            <div class="filters-header">
                                <h5 class="filters-title">
                                    <i class="fas fa-filter me-2"></i>Filtros Avanzados
                                </h5>
                            </div>

                            {{-- Filtro por Escudería --}}
                            <div class="filter-group">
                                <button class="btn filter-toggle w-100 d-flex justify-content-between align-items-center"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapseTeams"
                                    aria-expanded="false"
                                    aria-controls="collapseTeams">
                                    <span><i class="fas fa-flag me-2 "></i>Escudería</span>
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                                <div class="collapse mt-3" id="collapseTeams">
                                    <div class="filter-content p-3">
                                        <div class="search-box mb-3">
                                            <input type="text" id="teamSearch" class="form-control form-control-sm" placeholder="Buscar escudería...">
                                        </div>
                                        @foreach ($teams as $team)
                                        <div class="form-check mb-2 team-check-item">
                                            <input class="form-check-input" type="checkbox" name="teams[]" value="{{ $team->id }}"
                                                id="team-{{ $team->id }}" {{ in_array($team->id, request('teams', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="team-{{ $team->id }}">{{ $team->name }}</label>
                                        </div>
                                        @endforeach
                                        @if(count(request('teams', [])) > 0)
                                        <div class="mt-3 text-end">
                                            <button type="button" class="btn btn-f1-outline" id="clearTeamFilters">
                                                <i class="fas fa-times me-1"></i>Limpiar
                                            </button>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Filtro por Escala --}}
                            <div class="filter-group">
                                <div class="d-flex justify-content-between align-items-center mb-3 text-white">
                                    <h6 class="filter-label">
                                        <i class="fas fa-expand-arrows-alt me-2"></i>Escala
                                    </h6>
                                    @if(count(request('scales', [])) > 0)
                                    <button type="button" class="btn btn-f1-outline text-white" id="clearScaleFilters">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    @endif
                                </div>
                                @foreach ($scales as $scale)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="scales[]" value="{{ $scale->id }}"
                                        id="scale-{{ $scale->id }}" {{ in_array($scale->id, request('scales', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="scale-{{ $scale->id }}">{{ $scale->value }}</label>
                                </div>
                                @endforeach
                            </div>

                            {{-- Filtro por Precio --}}
                            <div class="filter-group">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="filter-label">
                                        <i class="fas fa-euro-sign me-2"></i>Precio
                                    </h6>
                                    @if(request('min_price') || request('max_price'))
                                    <button type="button" class="btn btn-f1-outline" id="clearPriceFilters">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    @endif
                                </div>
                                <div class="price-inputs d-flex align-items-center">
                                    <span class="me-2 fw-bold" style="color: var(--f1-gold);">€</span>
                                    <input type="number" name="min_price" class="form-control form-control-sm me-2" style="max-width: 80px;"
                                        value="{{ request('min_price') }}" min="0" placeholder="Mín.">
                                    <span class="mx-2">-</span>
                                    <input type="number" name="max_price" class="form-control form-control-sm ms-2" style="max-width: 80px;"
                                        value="{{ request('max_price') }}" min="0" placeholder="Máx.">
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-f1-primary w-100">
                                        <i class="fas fa-search me-2"></i>Aplicar Filtros
                                    </button>
                                </div>
                                @if(request('teams') || request('scales') || request('min_price') || request('max_price'))
                                <div class="mt-2">
                                    <button type="button" id="clearAllFilters" class="btn btn-f1-outline w-100">
                                        <i class="fas fa-times me-1"></i>Limpiar Todo
                                    </button>
                                </div>
                                @endif
                                <input type="hidden" name="ordenar" id="orden-actual" value="{{ request('ordenar', 'Relevancia') }}">
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Cuadrícula de productos --}}
                <div class="col-lg-9">
                    <div class="sort-bar d-flex justify-content-between align-items-center flex-wrap">
                        <div class="mb-2 mb-md-0">
                            <span class="text-white">Mostrando <strong style="color: var(--f1-gold);">{{ $products->count() }}</strong> productos</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <label for="ordenar" class="me-3 text-nowrap text-white">Ordenar por:</label>
                            <select class="form-select form-select-sm" id="ordenar" onchange="cambiarOrdenamiento(this.value)" style="min-width: 200px;">
                                <option value="Relevancia" {{ request('ordenar') == 'Relevancia' ? 'selected' : '' }}>Relevancia</option>
                                <option value="Precio: Menor a Mayor" {{ request('ordenar') == 'Precio: Menor a Mayor' ? 'selected' : '' }}>Precio: Menor a Mayor</option>
                                <option value="Precio: Mayor a Menor" {{ request('ordenar') == 'Precio: Mayor a Menor' ? 'selected' : '' }}>Precio: Mayor a Menor</option>
                                <option value="Más Recientes" {{ request('ordenar') == 'Más Recientes' ? 'selected' : '' }}>Más Recientes</option>
                                <option value="Más Populares" {{ request('ordenar') == 'Más Populares' ? 'selected' : '' }}>Más Populares</option>
                            </select>
                        </div>
                    </div>

                    {{-- Cartas de productos --}}
                    <div class="row g-4">
                        @foreach($products as $product)
                        <div class="col-md-6 col-xl-4">
                            <div class="product-card">
                                <div class="product-img-container">
                                    <img src="{{ asset($product->image) }}" class="product-img" alt="{{ $product->name }}">
                                    <div class="product-overlay">
                                        <button class="btn btn-details"
                                            data-bs-toggle="modal"
                                            data-bs-target="#ratingsModal-{{ $product->id }}">
                                            <i class="fas fa-eye me-2"></i>Ver Detalles
                                        </button>
                                    </div>
                                    <span class="year-badge">{{ $product->year }}</span>
                                </div>
                                <div class="card-body p-3">
                                    <p class="team-name">{{ $product->team ? $product->team->name : 'Sin escudería' }}</p>
                                    <h3 class="product-title">{{ $product->name }}</h3>
                                    <div class="scale-info">
                                        <i class="fas fa-ruler me-1"></i>Escala: {{ $product->scale ? $product->scale->value : 'Sin escala' }}
                                    </div>

                                    {{-- Sistema de valoraciones --}}
                                    <div class="product-rating"
                                        data-bs-toggle="modal"
                                        data-bs-target="#ratingsModal-{{ $product->id }}"
                                        title="Ver valoraciones">
                                        <div class="d-flex align-items-center">
                                            <div class="stars">
                                                @php
                                                $valoracionesAprobadas = $product->valoraciones->where('aprobada', true);
                                                $totalValoraciones = $valoracionesAprobadas->count();
                                                $valoracionMedia = $totalValoraciones > 0 ? $valoracionesAprobadas->avg('puntuacion') : 0;
                                                @endphp
                                                @if($totalValoraciones > 0)
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <=round($valoracionMedia))
                                                    <i class="fas fa-star"></i>
                                                    @elseif ($i - 0.5 <= $valoracionMedia)
                                                        <i class="fas fa-star-half-alt"></i>
                                                        @else
                                                        <i class="far fa-star"></i>
                                                        @endif
                                                        @endfor
                                                        @else
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i class="far fa-star"></i>
                                                            @endfor
                                                            @endif
                                            </div>
                                            <span class="ms-2 rating-info">
                                                @if($totalValoraciones > 0)
                                                {{ number_format($valoracionMedia, 1) }}/5 ({{ $totalValoraciones }})
                                                @else
                                                Sin valoraciones
                                                @endif
                                            </span>
                                        </div>
                                    </div>

                                    <p class="product-description">{{ $product->description }}</p>

                                    <div class="product-price">€{{ number_format($product->price, 2) }}</div>

                                    <div class="product-actions">
                                        @auth
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                @php
                                                $isInWishlist = Auth::user()->wishlist &&
                                                Auth::user()->wishlist->products->contains($product->id);
                                                @endphp
                                                <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-wishlist text-white {{ $isInWishlist ? 'active' : '' }}" title="Agregar a favoritos">
                                                        <i class="{{ $isInWishlist ? 'fas fa-heart' : 'far fa-heart' }}"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn btn-add-cart text-white">
                                                    <i class="fas fa-shopping-cart me-2"></i>Añadir
                                                </button>
                                            </form>
                                        </div>
                                        @else
                                        <div class="login-required">
                                            <p class="small mb-3">Para comprar, inicia sesión o regístrate</p>
                                            <button type="button" class="btn btn-login open-login-modal text-white">
                                                <i class="fas fa-user-lock me-2"></i>Iniciar Sesión
                                            </button>
                                        </div>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Paginación --}}
                    @if($products->hasPages())
                    <div class="pagination-container mt-5">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div class="pagination-info mb-3 mb-md-0">
                                <span class="text-white">
                                    Mostrando {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} de <strong style="color: var(--f1-gold);">{{ $products->total() }}</strong> productos
                                </span>
                            </div>
                            <nav aria-label="Navegación de páginas">
                                <ul class="pagination mb-0">
                                    @if ($products->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">‹</span></li>
                                    @else
                                    <li class="page-item"><a class="page-link" href="{{ $products->previousPageUrl() }}">‹</a></li>
                                    @endif

                                    @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                    @if ($page == $products->currentPage())
                                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                    @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                    @endforeach

                                    @if ($products->hasMorePages())
                                    <li class="page-item"><a class="page-link" href="{{ $products->nextPageUrl() }}">›</a></li>
                                    @else
                                    <li class="page-item disabled"><span class="page-link">›</span></li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>

{{-- Modales de valoraciones F1 Style --}}
@foreach($products as $product)
<div class="modal fade modal-rating" id="ratingsModal-{{ $product->id }}" tabindex="-1" aria-labelledby="ratingsModalLabel-{{ $product->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white" id="ratingsModalLabel-{{ $product->id }}" style="font-family: 'Orbitron', monospace; font-weight: 700;">
                    <i class="fas fa-star me-2"></i>{{ $product->name }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Información básica del producto -->
                    <div class="col-md-4 mb-4">
                        <img src="{{ asset($product->image) }}" class="img-fluid rounded mb-3" alt="{{ $product->name }}" style="border: 1px solid rgba(255, 24, 1, 0.3);">
                        <h5 class="h6 mb-2 text-white">{{ $product->name }}</h5>
                        <p class="text-uppercase small mb-1" style="color: var(--f1-gold);">{{ $product->team ? $product->team->name : 'Sin escudería' }}</p>
                        <div class="mb-2">
                            <span class="small ">Escala: {{ $product->scale ? $product->scale->value : 'Sin escala' }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="h5 fw-bold mb-0" style="color: var(--f1-red);">€{{ number_format($product->price, 2) }}</span>
                        </div>
                    </div>

                    <!-- Sección de valoraciones -->
                    <div class="col-md-8">
                        <h5 class="border-bottom pb-2 mb-3 text-white" style="border-color: rgba(255, 24, 1, 0.3) !important;">Valoraciones y Comentarios</h5>

                        @php
                        $valoracionesAprobadas = $product->valoraciones->where('aprobada', true);
                        $totalValoraciones = $valoracionesAprobadas->count();
                        $valoracionMedia = $totalValoraciones > 0 ? $valoracionesAprobadas->avg('puntuacion') : 0;
                        @endphp

                        <!-- Resumen de valoraciones -->
                        <div class="d-flex align-items-center mb-4">
                            <div class="d-flex flex-column align-items-center me-4">
                                <span class="display-4 fw-bold" style="color: var(--f1-gold);">{{ $totalValoraciones > 0 ? number_format($valoracionMedia, 1) : '0.0' }}</span>
                                <div class="stars tex" style="color: var(--f1-gold); font-size: 1.2rem;">
                                    @if($totalValoraciones > 0)
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <=round($valoracionMedia))
                                        <i class="fas fa-star"></i>
                                        @elseif ($i - 0.5 <= $valoracionMedia)
                                            <i class="fas fa-star-half-alt"></i>
                                            @else
                                            <i class="far fa-star"></i>
                                            @endif
                                            @endfor
                                            @else
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="far fa-star"></i>
                                                @endfor
                                                @endif
                                </div>
                                <span class="small text-white">{{ $totalValoraciones }} {{ $totalValoraciones == 1 ? 'valoración' : 'valoraciones' }}</span>
                            </div>
                            <div class="flex-grow-1">
                                @if($totalValoraciones > 0)
                                @php
                                $distribucion = [];
                                for($i = 1; $i <= 5; $i++) {
                                    $distribucion[$i]=$valoracionesAprobadas->where('puntuacion', $i)->count();
                                    }
                                    @endphp

                                    @for ($i = 5; $i >= 1; $i--)
                                    @php
                                    $cantidad = $distribucion[$i] ?? 0;
                                    $porcentaje = $totalValoraciones > 0 ? ($cantidad / $totalValoraciones) * 100 : 0;
                                    @endphp
                                    <div class="d-flex align-items-center small mb-2">
                                        <span class="me-2" style="color: var(--f1-gold); min-width: 30px;">{{ $i }}★</span>
                                        <div class="progress flex-grow-1 me-2" style="height: 8px; background: rgba(26, 26, 26, 0.8);">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $porcentaje }}%; background: var(--f1-gold);"></div>
                                        </div>
                                        <span class="small" style="min-width: 30px;">{{ $cantidad }}</span>
                                    </div>
                                    @endfor
                                    @else
                                    <div class="text-center py-3">
                                        <p class="text-muted small mb-0">No hay valoraciones disponibles.</p>
                                    </div>
                                    @endif
                            </div>
                        </div>

                        <!-- Lista de valoraciones -->
                        <div class="valoraciones-lista">
                            @if($product->valoraciones->where('aprobada', true)->count() > 0)
                            @foreach($product->valoraciones->where('aprobada', true) as $valoracion)
                            <div class="card mb-3">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="mb-1 text-white">{{ $valoracion->user->name ?? 'Usuario' }}</h6>
                                            <div class="d-flex align-items-center">
                                                <div class="small me-2" style="color: var(--f1-gold);">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <=$valoracion->puntuacion)
                                                        <i class="fas fa-star"></i>
                                                        @else
                                                        <i class="far fa-star"></i>
                                                        @endif
                                                        @endfor
                                                </div>
                                                @if($valoracion->compra_verificada)
                                                <span class="badge small" style="background: var(--f1-red);">Compra verificada</span>
                                                @endif
                                            </div>
                                        </div>
                                        <small class="text-white">{{ \Carbon\Carbon::parse($valoracion->created_at)->format('d/m/Y') }}</small>
                                    </div>
                                    <p class="small mb-0 text-white">{{ $valoracion->comentario }}</p>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="text-center py-4">
                                <i class="far fa-comment-dots fa-3x mb-3"></i>
                                <p class="">Este producto aún no tiene valoraciones.</p>
                                <p class="small">Sé el primero en valorar este producto.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                @auth
                @if($product->valoraciones->where('user_id', Auth::id())->count() == 0)
                <button type="button" class="btn btn-f1-primary"
                    onclick="window.location.href='{{ route("valoraciones.create", $product->id) }}'">
                    <i class="fas fa-star me-2"></i>Valorar Producto
                </button>
                @else
                <span class="text-muted small">Ya has valorado este producto</span>
                @endif
                @else
                <button type="button" class="btn btn-f1-primary text-white"
                    onclick="document.querySelector('.open-login-modal').click()">
                    <i class="fas fa-sign-in-alt me-2"></i>Inicia sesión para valorar
                </button>
                @endauth
            </div>
        </div>
    </div>
</div>
@endforeach

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Función para cambiar ordenamiento
        window.cambiarOrdenamiento = function(valor) {
            document.getElementById('orden-actual').value = valor;
            document.getElementById('filter-form').submit();
        }

        // Filtro de búsqueda de equipos
        const teamSearch = document.getElementById('teamSearch');
        if (teamSearch) {
            teamSearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                document.querySelectorAll('.team-check-item').forEach(item => {
                    const teamName = item.querySelector('label').textContent.toLowerCase();
                    if (teamName.includes(searchTerm)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }

        // Botones de limpiar filtros
        document.getElementById('clearTeamFilters')?.addEventListener('click', function() {
            document.querySelectorAll('input[name="teams[]"]').forEach(input => {
                input.checked = false;
            });
            document.getElementById('filter-form').submit();
        });

        document.getElementById('clearScaleFilters')?.addEventListener('click', function() {
            document.querySelectorAll('input[name="scales[]"]').forEach(input => {
                input.checked = false;
            });
            document.getElementById('filter-form').submit();
        });

        document.getElementById('clearPriceFilters')?.addEventListener('click', function() {
            document.querySelector('input[name="min_price"]').value = '';
            document.querySelector('input[name="max_price"]').value = '';
            document.getElementById('filter-form').submit();
        });

        document.getElementById('clearAllFilters')?.addEventListener('click', function() {
            document.querySelectorAll('input[name="teams[]"]').forEach(input => {
                input.checked = false;
            });
            document.querySelectorAll('input[name="scales[]"]').forEach(input => {
                input.checked = false;
            });
            document.querySelector('input[name="min_price"]').value = '';
            document.querySelector('input[name="max_price"]').value = '';
            const ordenActual = document.getElementById('orden-actual').value;
            if (ordenActual && ordenActual !== 'Relevancia') {
                window.location.href = '{{ route("catalogo") }}?ordenar=' + ordenActual;
            } else {
                window.location.href = '{{ route("catalogo") }}';
            }
        });

        // Scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-in').forEach(el => {
            observer.observe(el);
        });

        // Función para mostrar alerta de login F1 Style
        function showLoginAlert() {
            const existing = document.getElementById('loginAlert');
            if (existing) existing.remove();

            const alert = document.createElement('div');
            alert.id = 'loginAlert';
            alert.className = 'alert position-fixed top-0 start-50 translate-middle-x mt-3 shadow-lg text-center';
            alert.style.cssText = `
                z-index: 1055;
                min-width: 350px;
                max-width: 90%;
                background: linear-gradient(145deg, rgba(255, 24, 1, 0.1), rgba(0, 0, 0, 0.9));
                border: 2px solid var(--f1-red);
                color: white;
                border-radius: 15px;
                box-shadow: 0 15px 35px rgba(255, 24, 1, 0.4);
                backdrop-filter: blur(20px);
            `;
            alert.innerHTML = `
                <div class="d-flex align-items-center justify-content-center">
                    <i class="fas fa-exclamation-triangle me-2" style="color: var(--f1-gold);"></i>
                    <span><strong>Debes iniciar sesión</strong> para añadir productos al carrito.</span>
                </div>
                <div class="progress mt-2" style="height: 4px; background: rgba(26, 26, 26, 0.5);">
                    <div class="progress-bar" role="progressbar" style="width: 100%; background: var(--f1-red);"></div>
                </div>
            `;
            document.body.appendChild(alert);

            let progress = alert.querySelector('.progress-bar');
            let width = 100;
            const interval = setInterval(() => {
                width -= 2;
                progress.style.width = width + '%';
                if (width <= 0) {
                    clearInterval(interval);
                    alert.remove();
                }
            }, 100);
        }

        // Efectos hover para las cards
        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px) scale(1.02)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Manejo de productos sin autenticación
        document.querySelectorAll('.add-to-cart').forEach(button => {
            const isInsideForm = button.closest('form') !== null;
            if (!isInsideForm) {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    showLoginAlert();
                });
            }
        });
    });
</script>
@endsection