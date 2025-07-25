<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel de Estudiante')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
       <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        .app-container {
            min-height: 100vh;
            width: 100%;
            position: relative;
        }

        /* Sidebar Styles - Azul menos intenso */
        .sidebar {
            background: linear-gradient(120deg, #0249BB 0%, #003bb1 100%);
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .sidebar-expanded {
            width: 250px;
            flex: 0 0 250px;
        }

        .sidebar-collapsed {
            width: 70px;
            flex: 0 0 70px;
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.15);
            position: relative;
            background: rgba(255,255,255,0.05);
        }

        .sidebar-header h4 {
            color: white;
            margin: 0;
            font-weight: 600;
            transition: opacity 0.3s ease;
            font-size: 1.1rem;
        }

        .sidebar-collapsed .sidebar-header {
            padding: 20px 10px;
        }

        .sidebar-collapsed .sidebar-header h4 {
            opacity: 0;
            font-size: 0;
        }

        /* Icono cuando está colapsado */
        .sidebar-header::after {
            content: '\f19c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            color: white;
            font-size: 24px;
            opacity: 0;
            transition: opacity 0.3s ease;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .sidebar-collapsed .sidebar-header::after {
            opacity: 1;
        }

        /* Botón de cerrar para móvil */
        .sidebar-close-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .sidebar-close-btn:hover {
            background: rgba(255,255,255,0.3);
            transform: scale(1.1);
        }

        .sidebar-nav {
            padding: 20px 0;
        }

        .nav-item {
            margin-bottom: 5px;
        }

        .nav-link {
            color: rgba(255,255,255,0.85);
            padding: 15px 20px;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 0 25px 25px 0;
            margin-right: 10px;
            position: relative;
        }

        .nav-link:hover {
            background-color: rgba(255,255,255,0.15);
            color: white;
            transform: translateX(5px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .nav-link.active {
            background-color: rgba(255,255,255,0.25);
            color: white;
            font-weight: 600;
            box-shadow: 0 2px 12px rgba(0,0,0,0.15);
        }

        .nav-link i {
            font-size: 18px;
            width: 20px;
            text-align: center;
            margin-right: 15px;
            transition: all 0.3s ease;
        }

        .nav-text {
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .sidebar-collapsed .nav-text {
            opacity: 0;
            width: 0;
            margin: 0;
        }

        .sidebar-collapsed .nav-link {
            justify-content: center;
            padding: 15px 10px;
            margin-right: 5px;
        }

        .sidebar-collapsed .nav-link i {
            margin-right: 0;
            font-size: 20px;
        }

        /* Main Content */
        .main-content {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin-left: 70px;
            width: calc(100% - 70px);
            transition: all 0.3s ease;
            overflow-x: hidden;
        }

        .sidebar-expanded ~ .main-content {
            margin-left: 250px;
            width: calc(100% - 250px);
        }

        .top-navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 20px;
            flex-shrink: 0;
            width: 100%;
            max-width: 100%;
            overflow-x: hidden;
        }

        .content-area {
            flex: 1;
            padding: 20px;
            width: 100%;
            max-width: 100%;
            overflow-y: auto;
            overflow-x: hidden;
        }

        /* nuevo css para el control de overflow */
        .container-fluid {
            max-width: 100%;
            overflow-x: hidden;
        }

        .row {
            margin-left: 0;
            margin-right: 0;
        }

        .col-12, .col-md-8, .col-md-4 {
            padding-left: 15px;
            padding-right: 15px;
        }
        /* fin de nuevo css para el control de overflow */

        .toggle-btn {
            background: none;
            border: none;
            font-size: 18px;
            color: #003bb1;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 8px;
            border-radius: 4px;
        }

        .toggle-btn:hover {
            color: #003bb1;
            background-color: rgba(74, 144, 226, 0.1);
        }

       .user-info {
    display: flex;
    align-items: center;
    margin-left: auto;
    position: relative;
    z-index: 9999 !important; /* SÚPER ALTO */
}

        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: linear-gradient(120deg, #0249BB 0%, #003bb1 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            margin-right: 10px;
        }

        /* Tooltip para menú colapsado - Mejorado */
        .tooltip-custom {
            position: absolute;
            left: 75px;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0,0,0,0.85);
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 13px;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1001;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .tooltip-custom::before {
            content: '';
            position: absolute;
            top: 50%;
            left: -5px;
            transform: translateY(-50%);
            border: 5px solid transparent;
            border-right-color: rgba(0,0,0,0.85);
        }

        .sidebar-collapsed .nav-link:hover .tooltip-custom {
            opacity: 1;
            visibility: visible;
            left: 80px;
        }

        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        /* Cards y componentes */
        .welcome-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            text-align: center;
            width: 100%;
            max-width: 100%;
            margin-bottom: 30px;
            background: linear-gradient(120deg, #0249BB 0%, #003bb1 100%);
            color: white;
        }

        .news-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            margin-bottom: 25px;
            border-left: 4px solid #28a745;
        }

        .news-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        }

        .student-image {
            max-width: 200px;
            height: auto;
            border-radius: 15px;
            margin: 20px 0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .badge-custom {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            margin: 0 5px;
        }

        .news-date {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .news-title {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .news-excerpt {
            color: #6c757d;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        /* Mejoras en dropdown - MEJORADO */
       .dropdown {
    position: relative;
    z-index: 9999 !important; /* SÚPER ALTO */
}

        .dropdown-menu {
    position: fixed !important; /* FIXED en lugar de absolute */
    z-index: 99999 !important; /* EL MÁS ALTO POSIBLE */
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    border-radius: 10px;
    min-width: 220px;
    padding: 10px 0;
    margin: 0;
    background: white;
    border: 1px solid rgba(0,0,0,0.1);
    top: auto !important;
    left: auto !important;
    right: 20px !important; /* Posición fija desde la derecha */
    transform: none !important;
}

      .dropdown-menu.show {
    display: block !important;
    z-index: 99999 !important;
    position: fixed !important;
    opacity: 1;
    visibility: visible;
}

        .dropdown-toggle {
    position: relative;
    z-index: 9999 !important;
    cursor: pointer;
    transition: all 0.3s ease;
}

        .dropdown-toggle:hover {
            color: #4a90e2 !important;
        }

        .dropdown-toggle::after {
            margin-left: 8px;
            transition: transform 0.3s ease;
        }

        .dropdown-toggle[aria-expanded="true"]::after {
            transform: rotate(180deg);
        }

        .dropdown-item {
            padding: 12px 20px;
            transition: all 0.3s ease;
            color: #333;
            display: flex;
            align-items: center;
            border-radius: 6px;
            margin: 2px 8px;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #4a90e2;
            transform: translateX(5px);
        }

        .dropdown-item i {
            width: 18px;
            text-align: center;
            margin-right: 10px;
        }

        .dropdown-divider {
            margin: 8px 0;
            border-color: #e9ecef;
        }

        /* Indicador de expansión */
        .expand-indicator {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            color: rgba(255,255,255,0.6);
            font-size: 12px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-collapsed .expand-indicator {
            opacity: 1;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .app-container {
                position: relative;
            }
            .dropdown-toggle {
        z-index: 999 !important; /* MENOR que el sidebar (1001) */
    }

            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                width: 280px !important;
                flex: none !important;
                transform: translateX(-100%);
                z-index: 1001;
            }

            .main-content {
                margin-left: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                overflow-x: hidden !important;
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            /* Forzar que el header muestre el texto en móvil */
            .sidebar .sidebar-header {
                padding: 20px !important;
            }

            .sidebar .sidebar-header h4 {
                opacity: 1 !important;
                font-size: 1.1rem !important;
            }

            .sidebar .sidebar-header::after {
                opacity: 0 !important;
            }

            /* Forzar que los textos del menú se muestren en móvil */
            .sidebar .nav-text {
                opacity: 1 !important;
                width: auto !important;
                margin: 0 !important;
            }

            .sidebar .nav-link {
                justify-content: flex-start !important;
                padding: 15px 20px !important;
                margin-right: 10px !important;
            }

            .sidebar .nav-link i {
                margin-right: 15px !important;
                font-size: 18px !important;
            }

            /* Ocultar tooltips en móvil */
            .sidebar .tooltip-custom {
                display: none !important;
            }

            /* Ocultar indicador de expansión en móvil */
            .sidebar .expand-indicator {
                display: none !important;
            }

            .sidebar-close-btn {
                display: flex !important;
            }

            .content-area {
                padding: 15px;
            }

            .welcome-card {
                padding: 20px;
            }

            .top-navbar {
                padding: 12px 15px;
            }

            .student-image {
                max-width: 150px;
            }

            /* Dropdown en móvil */
            .dropdown-menu {
        position: fixed !important;
        z-index: 999 !important; /* MENOR que el sidebar (1001) */
        right: 10px !important;
        left: auto !important;
        top: 60px !important; /* Debajo del navbar */
        min-width: 200px;
    }
    .dropdown-menu.show {
        z-index: 999 !important; /* MENOR que el sidebar (1001) */
    }
    /* Cuando el sidebar está abierto en móvil, ocultar el dropdown */
    .sidebar.mobile-open ~ .main-content .dropdown-menu.show {
        display: none !important;
    }
            
            .user-info {
        z-index: 999 !important; /* MENOR que el sidebar (1001) */
    }
            
           .dropdown {
        z-index: 999 !important; /* MENOR que el sidebar (1001) */
    }
        }

        @media (max-width: 480px) {
            .sidebar {
                width: 100% !important;
            }

            .content-area {
                padding: 10px;
            }

            .welcome-card {
                padding: 15px;
            }

            .student-image {
                max-width: 120px;
            }
        }

        /* Animaciones mejoradas */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <!-- Overlay para móvil -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <div class="app-container">
        <!-- Sidebar - Inicia colapsado -->
        <div class="sidebar sidebar-collapsed" id="sidebar">
            <div class="sidebar-header">
                <h4>Portal Estudiante</h4>
                <button class="sidebar-close-btn" id="sidebarClose">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <nav class="sidebar-nav">
                <ul class="nav flex-column">
                   <li class="nav-item">
                        <a class="nav-link " href="{{ route('admin.dashboard') }}" data-page="general">
                            <i class="fas fa-home"></i>
                            <span class="nav-text">Inicio</span>
                            <div class="tooltip-custom">Inicio</div>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link "  href="{{ route('admin.usuarios.create') }}" data-page="perfil">
                            <i class="fas fa-user"></i>
                            <span class="nav-text">Usuarios y Roles</span>
                            <div class="tooltip-custom">Usuarios y Roles</div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"    href="{{ route('admin.cursos.create') }}" data-page="cursos">
                            <i class="fas fa-book"></i>
                            <span class="nav-text">Crear Curso</span>
                            <div class="tooltip-custom">Crear Curso</div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active"  href="{{ route('admin.matricula.create') }}" data-page="calificaciones">
                            <i class="fas fa-chart-line"></i>
                            <span class="nav-text">Matricula</span>
                            <div class="tooltip-custom">Matricula</div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('admin.calificaciones.index') }}" data-page="calendario">
                            <i class="fas fa-chart-line"></i>
                            <span class="nav-text">Calificaciones</span>
                            <div class="tooltip-custom">Calificaciones</div>
                        </a>
                    </li>
                    <li class="nav-item">
            <a class="nav-link" href="#" data-page="tramites">
                <i class="fas fa-file-alt"></i>
                <span class="nav-text">Trámite Documentario</span>
                <div class="tooltip-custom">Trámite Documentario</div>
            </a>
        </li>
                </ul>
            </nav>
            
            <div class="expand-indicator">
                <i class="fas fa-chevron-right"></i>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content" id="mainContent">
            <!-- Top Navbar -->
            <nav class="top-navbar">
                <div class="d-flex align-items-center w-100">
                    <button class="toggle-btn" id="sidebarToggle" title="Toggle Sidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <div class="user-info">
                        <div class="user-avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="dropdown">
                            <a id="navbarDropdown" class="dropdown-toggle text-decoration-none text-dark" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Bienvenido, {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="">
                                    <i class="fas fa-user me-2"></i>Mi Perfil
                                </a>
                                <a class="dropdown-item" href="">
                                    <i class="fas fa-cog me-2"></i>Configuración
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>{{ __('Logout') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            
            <!-- Content -->
            <div class="content-area">
            <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 CSS y JS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

<style>
.matricula-container {
    background: #ffffff;
    min-height: 100vh;
    padding: 1.5rem 4rem;
}

.card-modern {
    border: none;
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(2, 73, 187, 0.08);
    background: #ffffff;
    margin-bottom: 1.5rem;
    overflow: hidden;
}

.card-header-modern {
    background: linear-gradient(120deg, #0249BB 0%, #003bb1 100%);
    color: white;
    padding: 1.5rem;
    border: none;
    position: relative;
}

.card-header-modern h2, .card-header-modern h3 {
    margin: 0;
    font-weight: 600;
    font-size: 1.4rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-group-modern {
    margin-bottom: 1.5rem;
    position: relative;
}

.form-label-modern {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.6rem;
    display: block;
    font-size: 0.95rem;
}

.form-control-modern {
    border: 2px solid #e8ecef;
    border-radius: 10px;
    padding: 0.75rem 1rem;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background: #ffffff;
    height: auto;
}

.form-control-modern:focus {
    border-color: #0249BB;
    box-shadow: 0 0 0 0.15rem rgba(2, 73, 187, 0.15);
    outline: none;
}

.btn-modern {
    background: linear-gradient(120deg, #0249BB 0%, #003bb1 100%);
    color: white;
    border: none;
    padding: 0.8rem 2rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-modern:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(2, 73, 187, 0.3);
    color: white;
}

.alert-modern {
    border: none;
    border-radius: 10px;
    padding: 1rem;
    margin-bottom: 1.5rem;
    font-weight: 500;
    font-size: 0.9rem;
}

.alert-success-modern {
    background: rgba(40, 167, 69, 0.1);
    color: #155724;
    border-left: 4px solid #28a745;
}

.alert-danger-modern {
    background: rgba(220, 53, 69, 0.1);
    color: #721c24;
    border-left: 4px solid #dc3545;
}

.table-modern {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(2, 73, 187, 0.05);
    border: none;
    font-size: 0.9rem;
}

.table-modern thead {
    background: linear-gradient(120deg, #0249BB 0%, #003bb1 100%);
    color: white;
}

.table-modern thead th {
    border: none;
    padding: 1rem 0.8rem;
    font-weight: 600;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.table-modern tbody td {
    padding: 0.8rem;
    border: none;
    border-bottom: 1px solid #f8f9fa;
    vertical-align: middle;
}

.table-modern tbody tr:hover {
    background: rgba(2, 73, 187, 0.03);
}

.btn-danger-modern {
    background: linear-gradient(120deg, #dc3545 0%, #c82333 100%);
    color: white;
    border: none;
    padding: 0.4rem 0.8rem;
    border-radius: 6px;
    font-size: 0.8rem;
    transition: all 0.3s ease;
}

.btn-danger-modern:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    color: white;
}

.filter-section {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 1.2rem;
    margin-bottom: 1.5rem;
    border: 1px solid #e9ecef;
}

.search-input {
    position: relative;
}

.search-input i {
    position: absolute;
    left: 0.8rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    z-index: 5;
    font-size: 0.9rem;
}

.search-input input {
    padding-left: 2.5rem !important;
}

.badge-modern {
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-weight: 500;
    text-transform: capitalize;
    font-size: 0.75rem;
}

.badge-activo {
    background: rgba(40, 167, 69, 0.15);
    color: #155724;
    border: 1px solid rgba(40, 167, 69, 0.3);
}

.badge-inactivo {
    background: rgba(220, 53, 69, 0.15);
    color: #721c24;
    border: 1px solid rgba(220, 53, 69, 0.3);
}

.stats-card {
    background: linear-gradient(120deg, #0249BB 0%, #003bb1 100%);
    color: white;
    border-radius: 12px;
    padding: 1.2rem;
    text-align: center;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 15px rgba(2, 73, 187, 0.2);
}

.stats-number {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.3rem;
}

.stats-label {
    font-size: 0.9rem;
    opacity: 0.9;
}

.avatar-circle {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: linear-gradient(120deg, #0249BB 0%, #003bb1 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.9rem;
    flex-shrink: 0;
}

/* Select2 Customization */
.select2-container--default .select2-selection--multiple,
.select2-container--default .select2-selection--single {
    border: 2px solid #e8ecef !important;
    border-radius: 10px !important;
    min-height: 45px !important;
    padding: 0.3rem !important;
}

.select2-container--default.select2-container--focus .select2-selection--multiple,
.select2-container--default.select2-container--focus .select2-selection--single {
    border-color: #0249BB !important;
    box-shadow: 0 0 0 0.15rem rgba(2, 73, 187, 0.15) !important;
}

.select2-dropdown {
    border: 2px solid #0249BB !important;
    border-radius: 10px !important;
}

.select2-container--default .select2-search--dropdown .select2-search__field {
    border: 1px solid #e8ecef !important;
    border-radius: 6px !important;
    padding: 0.5rem !important;
}

.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #0249BB !important;
}

/* Responsive */
@media (max-width: 768px) {
    .matricula-container {
        padding: 1rem 0;
    }
    
    .card-header-modern {
        padding: 1rem;
    }
    
    .card-header-modern h2, .card-header-modern h3 {
        font-size: 1.2rem;
    }
    
    .table-modern {
        font-size: 0.8rem;
    }
    
    .table-modern thead th,
    .table-modern tbody td {
        padding: 0.6rem 0.4rem;
    }
    
    .stats-number {
        font-size: 1.5rem;
    }
    
    .btn-modern {
        padding: 0.7rem 1.5rem;
        font-size: 0.9rem;
    }
    
    .filter-section {
        padding: 1rem;
    }
    
    .form-group-modern {
        margin-bottom: 1rem;
    }
}

@media (max-width: 576px) {
    .avatar-circle {
        width: 30px;
        height: 30px;
        font-size: 0.8rem;
    }
    
    .table-modern {
        font-size: 0.75rem;
    }
    
    .btn-danger-modern {
        padding: 0.3rem 0.6rem;
        font-size: 0.75rem;
    }
}

/* Animaciones suaves */
.card-modern {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.no-results {
    text-align: center;
    padding: 3rem 1rem;
    color: #6c757d;
}

.no-results i {
    font-size: 3rem;
    margin-bottom: 1rem;
    color: #dee2e6;
}
</style>

<div class="matricula-container">
    <div class="container-fluid px-3">
        <!-- Estadísticas compactas -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="stats-card">
                    <div class="stats-number" id="total-matriculas">{{ count($matriculas) }}</div>
                    <div class="stats-label">Total de Matrículas Registradas</div>
                </div>
            </div>
        </div>

        <!-- Formulario de Matrícula -->
        <div class="card card-modern">
            <div class="card-header-modern">
                <h2><i class="bi bi-person-plus-fill"></i> Registrar Nueva Matrícula</h2>
            </div>
            <div class="card-body p-3">
                @if(session('success'))
                    <div class="alert alert-success-modern alert-modern">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    </div>
                @elseif(session('error'))
                    <div class="alert alert-danger-modern alert-modern">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('admin.matricula.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label for="user_ids" class="form-label-modern">
                                    <i class="bi bi-people-fill me-2"></i>Seleccionar Alumnos
                                </label>
                                <select name="user_ids[]" class="form-control form-control-modern select-alumnos" multiple required>
                                    @foreach($alumnos as $alumno)
                                        <option value="{{ $alumno->id }}">{{ $alumno->name }} {{ $alumno->apellido_p }} {{ $alumno->apellido_m }} - DNI: {{ $alumno->dni }}</option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted mt-2">
                                    <i class="bi bi-info-circle me-1"></i>Busca y selecciona múltiples alumnos
                                </small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label for="curso_periodo_id" class="form-label-modern">
                                    <i class="bi bi-book-fill me-2"></i>Seleccionar Curso
                                </label>
                                <select name="curso_periodo_id" class="form-control form-control-modern select-curso" required>
                                    <option value="">Seleccionar curso...</option>
                                    @foreach($cursos as $curso)
                                        <option value="{{ $curso->id }}">
                                            {{ $curso->curso->nombre }} ({{ $curso->periodo->nombre }} - Sección {{ $curso->seccion }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-modern">
                            <i class="bi bi-check-lg"></i> Registrar Matrícula
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Filtros -->
        <div class="card card-modern">
            <div class="card-header-modern">
                <h3><i class="bi bi-funnel-fill me-2"></i>Filtros de Búsqueda</h3>
            </div>
            <div class="card-body p-0">
                <div class="filter-section">
                    <div class="row g-3">
                        <div class="col-lg-4 col-md-6">
                            <form method="GET" action="{{ route('admin.matricula.create') }}">
                                <label for="periodo_id" class="form-label-modern">
                                    <i class="bi bi-calendar3 me-2"></i>Periodo:
                                </label>
                                <select name="periodo_id" id="periodo_id" class="form-control form-control-modern" onchange="this.form.submit()">
                                    @foreach($periodos as $periodo)
                                        <option value="{{ $periodo->id }}" {{ $periodo->id == $periodoSeleccionado ? 'selected' : '' }}>
                                            {{ $periodo->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <label class="form-label-modern">
                                <i class="bi bi-search me-2"></i>Buscar Alumno:
                            </label>
                            <div class="search-input">
                                <i class="bi bi-search"></i>
                                <input type="text" id="searchAlumno" class="form-control form-control-modern" placeholder="Nombre o DNI...">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <label class="form-label-modern">
                                <i class="bi bi-book me-2"></i>Buscar Curso:
                            </label>
                            <div class="search-input">
                                <i class="bi bi-search"></i>
                                <input type="text" id="searchCurso" class="form-control form-control-modern" placeholder="Nombre del curso...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Matrículas -->
        <div class="card card-modern">
            <div class="card-header-modern">
                <h3><i class="bi bi-table me-2"></i>Lista de Matrículas</h3>
            </div>
            <div class="card-body p-0">
                @if($matriculas->isEmpty())
                    <div class="no-results">
                        <i class="bi bi-inbox"></i>
                        <p class="mb-0">No hay alumnos matriculados en este periodo.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-modern mb-0" id="matriculasTable">
                            <thead>
                                <tr>
                                    <th><i class="bi bi-person me-1"></i>Alumno</th>
                                    <th><i class="bi bi-book me-1"></i>Curso</th>
                                    <th class="d-none d-md-table-cell"><i class="bi bi-calendar3 me-1"></i>Periodo</th>
                                    <th class="d-none d-lg-table-cell"><i class="bi bi-grid-3x3-gap me-1"></i>Sección</th>
                                    <th class="d-none d-lg-table-cell"><i class="bi bi-calendar-date me-1"></i>Fecha</th>
                                    <th><i class="bi bi-info-circle me-1"></i>Estado</th>
                                    <th><i class="bi bi-gear me-1"></i>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($matriculas as $m)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle me-2">
                                                    <i class="bi bi-person-fill"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">{{ $m->name }} {{ $m->apellido_p }}</div>
                                                    <small class="text-muted d-block d-md-none">{{ $m->curso }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            <strong>{{ $m->curso }}</strong>
                                        </td>
                                        <td class="d-none d-md-table-cell">{{ $m->periodo }}</td>
                                        <td class="d-none d-lg-table-cell">
                                            <span class="badge bg-primary">{{ $m->seccion }}</span>
                                        </td>
                                        <td class="d-none d-lg-table-cell">{{ $m->fecha_matricula }}</td>
                                        <td>
                                            <span class="badge-modern {{ $m->estado == 'activo' ? 'badge-activo' : 'badge-inactivo' }}">
                                                {{ ucfirst($m->estado) }}
                                            </span>
                                        </td>
                                        <td>
                                            <form method="POST" action="{{ route('admin.matricula.destroy', $m->id) }}" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger-modern btn-sm" onclick="return confirm('¿Confirmar retiro de matrícula?')" title="Retirar">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Inicializar Select2 con búsqueda mejorada
        $('.select-alumnos').select2({
            placeholder: "🔍 Buscar alumnos por nombre o DNI...",
            allowClear: true,
            width: '100%',
            theme: 'default',
            dropdownAutoWidth: true,
            matcher: function(params, data) {
                if ($.trim(params.term) === '') {
                    return data;
                }
                
                if (typeof data.text === 'undefined') {
                    return null;
                }
                
                var searchText = data.text.toLowerCase();
                var searchTerm = params.term.toLowerCase();
                
                if (searchText.indexOf(searchTerm) > -1) {
                    return data;
                }
                
                return null;
            }
        });
        
        $('.select-curso').select2({
            placeholder: "🔍 Seleccionar curso...",
            allowClear: true,
            width: '100%',
            theme: 'default',
            dropdownAutoWidth: true,
            matcher: function(params, data) {
                if ($.trim(params.term) === '') {
                    return data;
                }
                
                if (typeof data.text === 'undefined') {
                    return null;
                }
                
                var searchText = data.text.toLowerCase();
                var searchTerm = params.term.toLowerCase();
                
                if (searchText.indexOf(searchTerm) > -1) {
                    return data;
                }
                
                return null;
            }
        });

        // Mejorar la búsqueda del select de cursos - abrir automáticamente
       $(document).on('select2:open', function(e) {
    const openedSelect = e.target;

    // Asegura que solo aplique al select-curso
    if ($(openedSelect).hasClass('select-curso')) {
        const searchField = document.querySelector('.select2-container--open .select2-search__field');
        if (searchField) {
            searchField.focus();
        }
    }
});

        // Filtro de búsqueda por alumno en tiempo real
        let searchTimeout;
        $('#searchAlumno').on('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                var value = $(this).val().toLowerCase();
                $('#matriculasTable tbody tr').each(function() {
                    var alumnoText = $(this).find('td:first-child').text().toLowerCase();
                    $(this).toggle(alumnoText.indexOf(value) > -1);
                });
                updateStats();
            }, 300);
        });

        // Filtro de búsqueda por curso en tiempo real
        $('#searchCurso').on('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                var value = $(this).val().toLowerCase();
                $('#matriculasTable tbody tr').each(function() {
                    var cursoText = $(this).find('td:nth-child(2)').text().toLowerCase();
                    $(this).toggle(cursoText.indexOf(value) > -1);
                });
                updateStats();
            }, 300);
        });

        // Función para actualizar estadísticas
        function updateStats() {
            var visibleRows = $('#matriculasTable tbody tr:visible').length;
            $('#total-matriculas').text(visibleRows);
        }

        // Limpiar filtros al cambiar período
        $('#periodo_id').on('change', function() {
            $('#searchAlumno, #searchCurso').val('');
        });

        // Mejorar responsividad de Select2 en móviles
        if (window.innerWidth < 768) {
            $('.select2-container').css('font-size', '14px');
        }

        // Auto-focus en campo de búsqueda cuando se abre el dropdown
        
    });

    // Mejorar Select2 para móviles
    $(window).on('resize', function() {
        if (window.innerWidth < 768) {
            $('.select2-container').css('font-size', '14px');
        } else {
            $('.select2-container').css('font-size', '16px');
        }
    });
</script>



<hr>


</div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarClose = document.getElementById('sidebarClose');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const navLinks = document.querySelectorAll('.nav-link');
            
            // Toggle sidebar
            function toggleSidebar() {
                if (window.innerWidth <= 768) {
                    // Mobile behavior
                    sidebar.classList.toggle('mobile-open');
                    sidebarOverlay.classList.toggle('active');
                    document.body.style.overflow = sidebar.classList.contains('mobile-open') ? 'hidden' : '';
                } else {
                    // Desktop behavior
                    sidebar.classList.toggle('sidebar-collapsed');
                    sidebar.classList.toggle('sidebar-expanded');
                }
            }
            
            // Close sidebar
            function closeSidebar() {
                sidebar.classList.remove('mobile-open');
                sidebarOverlay.classList.remove('active');
                document.body.style.overflow = '';
            }
            
            // Event listeners
            sidebarToggle.addEventListener('click', toggleSidebar);
            sidebarClose.addEventListener('click', closeSidebar);
            sidebarOverlay.addEventListener('click', closeSidebar);
            
            // Handle navigation
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Skip navigation logic for external links or logout
                    if (this.href && !this.href.includes('#')) {
                        return; // Let the browser handle the navigation
                    }
                    e.preventDefault();
                    
                    // Update active state
                    navLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Close mobile sidebar
                    if (window.innerWidth <= 768) {
                        closeSidebar();
                    }
                    
                    const page = this.getAttribute('data-page');
                    console.log('Navigating to:', page);
                });
            });
            
            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    closeSidebar();
                }
            });
            
            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // ESC key to close sidebar on mobile
                if (e.key === 'Escape' && window.innerWidth <= 768) {
                    closeSidebar();
                }
                
                // Ctrl/Cmd + B to toggle sidebar
                if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
                    e.preventDefault();
                    toggleSidebar();
                }
            });
            
            // Add fade-in animation to content
            const contentArea = document.querySelector('.content-area');
            if (contentArea) {
                contentArea.classList.add('fade-in');
            }

            // Mejorar comportamiento del dropdown
            const dropdown = document.querySelector('.dropdown-toggle');
            const dropdownMenu = document.querySelector('.dropdown-menu');
            
            if (dropdown && dropdownMenu) {
                dropdown.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                });
                
                // Cerrar dropdown al hacer clic fuera
                document.addEventListener('click', function(e) {
                    if (!dropdown.contains(e.target) && !dropdownMenu.contains(e.target)) {
                        const bsDropdown = bootstrap.Dropdown.getInstance(dropdown);
                        if (bsDropdown) {
                            bsDropdown.hide();
                        }
                    }
                });
            }
        });
    </script>
    
    <!-- Formulario de logout (mantener al final del body) -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</body>
</html>
