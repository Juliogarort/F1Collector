@extends('layouts.app')

@section('title', 'Panel de Control')

@section('head')
<!-- Estilos específicos para el panel de administración -->
<style>
    /* Paleta de colores elegante */
    :root {
        --primary: #2c3e50;
        --primary-light: #34495e;
        --secondary: #e74c3c;
        --secondary-light: #f64d3b;
        --accent: #3498db;
        --accent-light: #59a9e7;
        --neutral-dark: #2c3e50;
        --neutral-medium: #7f8c8d;
        --neutral-light: #ecf0f1;
        --success: #27ae60;
        --warning: #f39c12;
        --inactive: #95a5a6;
        --text-dark: #2c3e50;
        --text-medium: #5d6d7e;
        --text-light: #ecf0f1;
        --shadow: rgba(0, 0, 0, 0.1);
    }

    /* Estilos generales */
    .admin-workspace {
        padding: 2rem;
        max-width: 1320px;
        margin: 0 auto;
        background-color: #f5f7fa;
    }

    /* Encabezado */
    .workspace-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid rgba(44, 62, 80, 0.1);
    }

    .header-content h1 {
        font-weight: 700;
        font-size: 2.2rem;
        margin: 0;
        color: var(--primary);
        letter-spacing: -0.5px;
    }

    .header-content p {
        color: var(--neutral-medium);
        margin: 0.5rem 0 0;
        font-size: 1rem;
    }

    .system-status {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .status-indicator {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .pulse {
        display: inline-block;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: var(--success);
        box-shadow: 0 0 0 rgba(39, 174, 96, 0.4);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(39, 174, 96, 0.4);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(39, 174, 96, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(39, 174, 96, 0);
        }
    }

    .status-text {
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--neutral-medium);
    }

    .date-time {
        font-size: 0.85rem;
        color: var(--neutral-medium);
        font-weight: 500;
    }

    /* Grid de módulos */
    .modules-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 1.75rem;
    }

    /* Tarjetas de módulos */
    .module-card {
        position: relative;
        display: flex;
        background-color: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 20px var(--shadow);
        transition: all 0.3s ease;
    }

    .module-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }

    .module-card.active:hover {
        box-shadow: 0 10px 30px rgba(231, 76, 60, 0.15);
    }

    .card-accent {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(135deg, var(--secondary), var(--secondary-light));
    }

    .card-accent.inactive {
        background: linear-gradient(135deg, var(--inactive), var(--neutral-medium));
    }

    .card-icon {
        padding: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .icon-wrapper {
        width: 54px;
        height: 54px;
        border-radius: 12px;
        background-color: rgba(231, 76, 60, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--secondary);
        font-size: 1.5rem;
        transition: all 0.3s ease;
    }

    .icon-wrapper.inactive {
        background-color: rgba(149, 165, 166, 0.1);
        color: var(--inactive);
    }

    .card-content {
        flex: 1;
        padding: 1.5rem 1.5rem 1.5rem 0;
        display: flex;
        flex-direction: column;
    }

    .content-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .content-header h2 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--primary);
    }

    .module-status {
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        background-color: rgba(231, 76, 60, 0.1);
        color: var(--secondary);
        letter-spacing: 0.5px;
    }

    .module-status.inactive {
        background-color: rgba(149, 165, 166, 0.1);
        color: var(--inactive);
    }

    .card-content p {
        margin: 0 0 1.5rem;
        font-size: 0.9rem;
        color: var(--text-medium);
        line-height: 1.5;
        flex-grow: 1;
    }

    .module-actions {
        margin-top: auto;
    }

    .btn-action {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 1.25rem;
        background-color: var(--secondary);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        cursor: pointer;
        font-size: 0.9rem;
    }

    .btn-action:hover {
        background-color: var(--secondary-light);
        color: white;
    }

    .btn-action.inactive {
        background-color: var(--inactive);
        opacity: 0.7;
        cursor: not-allowed;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .modules-grid {
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .workspace-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .system-status {
            width: 100%;
            margin-top: 1rem;
            justify-content: space-between;
        }

        .modules-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="admin-workspace">
    <!-- Encabezado del panel -->
    <div class="workspace-header">
        <div class="header-content">
            <h1>Panel de Control</h1>
            <p>Administración central de F1 Collector</p>
        </div>
        <div class="system-status">
            <div class="status-indicator">
                <span class="pulse"></span>
                <span class="status-text">Sistema operativo</span>
            </div>
            <div class="date-time">
                <span id="current-date">Viernes, 16 Mayo</span>
            </div>
        </div>
    </div>

    <!-- Grid de módulos -->
    <div class="modules-grid">
        <!-- Módulo de Productos -->
        <div class="module-card active">
            <div class="card-accent"></div>
            <div class="card-icon">
                <div class="icon-wrapper">
                    <i class="bi bi-box-seam-fill"></i>
                </div>
            </div>
            <div class="card-content">
                <div class="content-header">
                    <h2>Productos</h2>
                    <span class="module-status">Activo</span>
                </div>
                <p>Gestión del catálogo completo de modelos y productos de colección.</p>
                <div class="module-actions">
                    <a href="/admin/products" class="btn-action">
                        <span>Gestionar</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Módulo de Escuderías -->
        <div class="module-card active">
            <div class="card-accent"></div>
            <div class="card-icon">
                <div class="icon-wrapper">
                    <i class="bi bi-flag-fill"></i>
                </div>
            </div>
            <div class="card-content">
                <div class="content-header">
                    <h2>Escuderías</h2>
                    <span class="module-status">Activo</span>
                </div>
                <p>Configuración y administración de equipos y escuderías de Fórmula 1.</p>
                <div class="module-actions">
                    <a href="/admin/teams" class="btn-action">
                        <span>Gestionar</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Módulo de Escalas -->
        <div class="module-card active">
            <div class="card-accent"></div>
            <div class="card-icon">
                <div class="icon-wrapper">
                    <i class="bi bi-rulers"></i>
                </div>
            </div>
            <div class="card-content">
                <div class="content-header">
                    <h2>Escalas</h2>
                    <span class="module-status">Activo</span>
                </div>
                <p>Administración de escalas y tamaños para los modelos de colección.</p>
                <div class="module-actions">
                    <a href="/admin/scales" class="btn-action">
                        <span>Gestionar</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Módulo de Pedidos -->
        <div class="module-card inactive">
            <div class="card-accent inactive"></div>
            <div class="card-icon">
                <div class="icon-wrapper inactive">
                    <i class="bi bi-cart-check-fill"></i>
                </div>
            </div>
            <div class="card-content">
                <div class="content-header">
                    <h2>Pedidos</h2>
                    <span class="module-status inactive">En desarrollo</span>
                </div>
                <p>Gestión de órdenes, envíos y seguimiento de pedidos de clientes.</p>
                <div class="module-actions">
                    <button class="btn-action inactive" disabled>
                        <span>Próximamente</span>
                        <i class="bi bi-hourglass-split"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Módulo de Usuarios -->
        <div class="module-card inactive">
            <div class="card-accent inactive"></div>
            <div class="card-icon">
                <div class="icon-wrapper inactive">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
            <div class="card-content">
                <div class="content-header">
                    <h2>Usuarios</h2>
                    <span class="module-status inactive">En desarrollo</span>
                </div>
                <p>Administración de cuentas, permisos y roles dentro del sistema.</p>
                <div class="module-actions">
                    <button class="btn-action inactive" disabled>
                        <span>Próximamente</span>
                        <i class="bi bi-hourglass-split"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Módulo de Estadísticas -->
        <div class="module-card inactive">
            <div class="card-accent inactive"></div>
            <div class="card-icon">
                <div class="icon-wrapper inactive">
                    <i class="bi bi-bar-chart-fill"></i>
                </div>
            </div>
            <div class="card-content">
                <div class="content-header">
                    <h2>Analítica</h2>
                    <span class="module-status inactive">En desarrollo</span>
                </div>
                <p>Visualización de datos, métricas de ventas y análisis de rendimiento.</p>
                <div class="module-actions">
                    <button class="btn-action inactive" disabled>
                        <span>Próximamente</span>
                        <i class="bi bi-hourglass-split"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Formatear fecha actual
        const options = { weekday: 'long', month: 'long', day: 'numeric' };
        const today = new Date();
        document.getElementById('current-date').textContent = today.toLocaleDateString('es-ES', options);
    });
</script>
@endsection