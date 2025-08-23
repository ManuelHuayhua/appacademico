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
                <h4>Portal Profesor</h4>
                <button class="sidebar-close-btn" id="sidebarClose">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
              <nav class="sidebar-nav">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('profesor.dashboard') }}" data-page="general">
                            <i class="fas fa-home"></i>
                            <span class="nav-text">Inicio</span>
                            <div class="tooltip-custom">Inicio</div>
                        </a>
                    </li>
                    <!-- Nuevo: Perfil -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('profesor.perfil') }}" data-page="perfil">
                <i class="fas fa-user"></i>
                <span class="nav-text">Perfil</span>
                <div class="tooltip-custom">Perfil</div>
            </a>
        </li>
        <!-- Fin Perfil -->
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('profesor.cursos') }}" data-page="Cursos">
                            <i class="fas fa-book"></i>
                            <span class="nav-text">Cursos</span>
                            <div class="tooltip-custom">Cursos</div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"   href="{{ route('profesor.calificaciones') }}" data-page="Calificaciones">
                            <i class="fas fa-chart-line"></i>
                            <span class="nav-text">Calificaciones</span>
                            <div class="tooltip-custom">Calificaciones</div>
                        </a>
                    </li>
                  
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('calendario') }}"data-page="calendario">
                            <i class="fas fa-calendar-alt"></i>
                            <span class="nav-text">Calendario</span>
                            <div class="tooltip-custom">Calendario</div>
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

            <style>
    /* Estilos mejorados para el diseño */
    .curso-card {
        border: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        transition: all 0.3s ease;
        overflow: hidden;
    }
    
    .curso-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .curso-header {
        background: linear-gradient(120deg, #0249BB 0%, #003bb1 100%);
        color: white;
        padding: 1.5rem;
        border: none;
    }
    
    .curso-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0;
    }
    
    .btn-toggle {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        transition: all 0.3s ease;
    }
    
    .btn-toggle:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        transform: scale(1.05);
    }
    
    .fecha-section {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        margin-bottom: 1rem;
        overflow: hidden;
    }
    
    .fecha-header {
        background: white;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e9ecef;
    }
    
    .fecha-title {
        color: #495057;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-asistencia {
        background: #6c757d;
        border: none;
        color: white;
        border-radius: 6px;
        padding: 0.4rem 0.8rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
    }
    
    .btn-asistencia:hover {
        background: #5a6268;
        color: white;
        transform: scale(1.05);
    }
    
    .asistencia-form {
        padding: 1.5rem;
    }
    
    .table-asistencia {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .table-asistencia thead {
        background: linear-gradient(120deg, #0249BB 0%, #003bb1 100%);
        color: white;
    }
    
    .table-asistencia th {
        border: none;
        padding: 1rem;
        font-weight: 600;
    }
    
    .table-asistencia td {
        padding: 1rem;
        vertical-align: middle;
        border-color: #e9ecef;
    }
    
    .btn-group-asistencia .btn {
        border-radius: 6px;
        margin: 0 2px;
        font-size: 0.875rem;
        padding: 0.5rem 0.8rem;
        transition: all 0.3s ease;
    }
    
    .btn-group-asistencia .btn:hover {
        transform: scale(1.05);
    }
    
    .btn-guardar {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
        border-radius: 8px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
    }
    
    .btn-guardar:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4);
        color: white;
    }
    
    .filtro-section {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }
    
    .form-select {
        border-radius: 8px;
        border: 2px solid #e9ecef;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }
    
    .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    /* Sistema de notificaciones flotantes */
    .toast-container {
        position: fixed;
        top: 20px;
        left: 20px;
        z-index: 1055;
        max-width: 350px;
    }
    
    .toast-custom {
        border: none;
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        backdrop-filter: blur(10px);
    }
    
    .toast-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
    }
    
    .toast-error {
        background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
        color: white;
    }
    
    .toast-header-custom {
        background: rgba(255, 255, 255, 0.1);
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
    }
    
    .toast-body-custom {
        color: white;
        font-weight: 500;
    }
    
    /* Animaciones */
    @keyframes slideInLeft {
        from {
            transform: translateX(-100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    .slide-in-left {
        animation: slideInLeft 0.5s ease-out;
    }
    
    /* Responsive improvements */
    @media (max-width: 768px) {
        .curso-header {
            padding: 1rem;
        }
        
        .curso-header .d-flex {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start !important;
        }
        
        .btn-toggle {
            align-self: stretch;
            text-align: center;
        }
        
        .fecha-header .d-flex {
            flex-direction: column;
            gap: 0.5rem;
            align-items: flex-start !important;
        }
        
        .btn-asistencia {
            align-self: stretch;
        }
        
        .table-responsive {
            border-radius: 8px;
        }
        
        .btn-group-asistencia {
            flex-direction: column;
            width: 100%;
        }
        
        .btn-group-asistencia .btn {
            margin: 2px 0;
            border-radius: 6px !important;
        }
        
        .toast-container {
            left: 10px;
            right: 10px;
            max-width: none;
        }
    }
    
    @media (max-width: 576px) {
        .asistencia-form {
            padding: 1rem;
        }
        
        .filtro-section {
            padding: 1rem;
        }
    }
</style>

          <div class="content-area">
    <div class="d-flex align-items-center mb-4">
        <i class="fas fa-chalkboard-teacher me-3" style="font-size: 2rem; color: #667eea;"></i>
        <h2 class="mb-0" style="color: #495057; font-weight: 700;">Cursos Asignados</h2>
    </div>

    {{-- Filtro por periodo --}}
    <div class="filtro-section">
        <form method="GET" action="{{ route('profesor.cursos') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label for="periodo_id" class="form-label fw-semibold">
                        <i class="fas fa-calendar-alt me-2"></i>Seleccionar periodo:
                    </label>
                    <select class="form-select" name="periodo_id" id="periodo_id" onchange="this.form.submit()">
                        @foreach($periodos as $periodo)
                            <option value="{{ $periodo->id }}" {{ $periodo->id == $periodoSeleccionado ? 'selected' : '' }}>
                                {{ $periodo->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    </div>

    @foreach($cursos as $curso)
    <div class="card curso-card mb-4">
        <div class="card-header curso-header">
            <div class="d-flex justify-content-between align-items-center">
                <div class="curso-title">
                    <i class="fas fa-book me-2"></i>
                    {{ $curso->curso }} - {{ $curso->periodo }} 
                    <span class="badge bg-light text-dark ms-2">Sección {{ $curso->seccion }}</span>
                </div>
                <button class="btn btn-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#detallesCurso{{ $curso->curso_periodo_id }}">
                    <i class="fas fa-folder-open me-2"></i>Ver detalles
                </button>
            </div>
        </div>
        <div class="card-body collapse" id="detallesCurso{{ $curso->curso_periodo_id }}">
            @php
                $fechas = collect($fechasPorSemana[$curso->curso_periodo_id] ?? [])->flatten();
            @endphp
            @if($fechas->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-calendar-times" style="font-size: 3rem; color: #6c757d; opacity: 0.5;"></i>
                    <p class="mt-3 text-muted">No hay fechas registradas para este curso.</p>
                </div>
            @else
                @foreach($fechas->sort()->values() as $index => $fecha)
                    <div class="fecha-section">
                        <div class="fecha-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="fecha-title">
                                    <i class="fas fa-calendar-day"></i>
                                    {{ \Carbon\Carbon::parse($fecha)->translatedFormat('l d/m/Y') }}
                                </h5>
                                <button class="btn btn-asistencia" type="button" data-bs-toggle="collapse" data-bs-target="#fecha{{ $curso->curso_periodo_id }}_{{ $index }}">
                                    <i class="fas fa-users me-2"></i>Ver asistencia
                                </button>
                            </div>
                        </div>
                        <div class="collapse" id="fecha{{ $curso->curso_periodo_id }}_{{ $index }}">
                            <div class="asistencia-form">
                                <form action="{{ route('profesor.asistencia.guardar') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="curso_periodo_id" value="{{ $curso->curso_periodo_id }}">
                                    <input type="hidden" name="fecha" value="{{ $fecha }}">
                                    
                                    <div class="table-responsive">
                                        <table class="table table-asistencia mb-0">
                                            <thead>
                                                <tr>
                                                    <th><i class="fas fa-user me-2"></i>Alumno</th>
                                                    <th><i class="fas fa-check-circle me-2"></i>Asistencia</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($alumnosPorCurso[$curso->curso_periodo_id] as $alumno)
                                                    @php
                                                        $registro = DB::table('asistencias')
                                                            ->where('user_id', $alumno->id)
                                                            ->where('curso_periodo_id', $curso->curso_periodo_id)
                                                            ->where('fecha', $fecha)
                                                            ->first();
                                                    @endphp
                                                    <tr>
                                                        <td class="fw-semibold">{{ $alumno->name }}</td>
                                                        <td>
                                                            <div class="btn-group btn-group-asistencia" role="group">
                                                               <input type="radio" class="btn-check"
    name="asistencias[{{ $alumno->id }}]"
    id="asistio_{{ $alumno->id }}_{{ $curso->curso_periodo_id }}_{{ $index }}"
    value="1"
    {{ optional($registro)->asistio === 1 ? 'checked' : '' }}>
<label class="btn btn-outline-success"
    for="asistio_{{ $alumno->id }}_{{ $curso->curso_periodo_id }}_{{ $index }}">
    <i class="fas fa-check me-1"></i>Asistió
</label>

<input type="radio" class="btn-check"
    name="asistencias[{{ $alumno->id }}]"
    id="falto_{{ $alumno->id }}_{{ $curso->curso_periodo_id }}_{{ $index }}"
    value="0"
    {{ optional($registro)->asistio === 0 ? 'checked' : '' }}>
<label class="btn btn-outline-danger"
    for="falto_{{ $alumno->id }}_{{ $curso->curso_periodo_id }}_{{ $index }}">
    <i class="fas fa-times me-1"></i>Faltó
</label>

<input type="radio" class="btn-check"
    name="asistencias[{{ $alumno->id }}]"
    id="pendiente_{{ $alumno->id }}_{{ $curso->curso_periodo_id }}_{{ $index }}"
    value=""
    {{ is_null(optional($registro)->asistio) ? 'checked' : '' }}>
<label class="btn btn-outline-secondary"
    for="pendiente_{{ $alumno->id }}_{{ $curso->curso_periodo_id }}_{{ $index }}">
    <i class="fas fa-clock me-1"></i>Pendiente
</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-end mt-3">
                                        <button class="btn btn-guardar">
                                            <i class="fas fa-save me-2"></i>Guardar asistencia
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    @endforeach
            
</div>

<!-- Toast Container para notificaciones -->
<div class="toast-container">
    @if(session('success'))
        <div class="toast toast-custom toast-success slide-in-left" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="5000">
            <div class="toast-header toast-header-custom">
                <i class="fas fa-check-circle me-2"></i>
                <strong class="me-auto">Éxito</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body toast-body-custom">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="toast toast-custom toast-error slide-in-left" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="5000">
            <div class="toast-header toast-header-custom">
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong class="me-auto">Error</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body toast-body-custom">
                {{ session('error') }}
            </div>
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var toastElList = [].slice.call(document.querySelectorAll('.toast'))
        toastElList.map(function (toastEl) {
            var toast = new bootstrap.Toast(toastEl)
            toast.show()
        });
    });
</script>



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


