<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel de Estudiante')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

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
                        <a class="nav-link " href="{{ route('home') }}" data-page="general">
                            <i class="fas fa-home"></i>
                            <span class="nav-text">General</span>
                            <div class="tooltip-custom">General</div>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('alumno.perfil') }}" data-page="perfil">
                            <i class="fas fa-user"></i>
                            <span class="nav-text">Perfil</span>
                            <div class="tooltip-custom">Perfil</div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="" data-page="cursos">
                            <i class="fas fa-book"></i>
                            <span class="nav-text">Cursos</span>
                            <div class="tooltip-custom">Cursos</div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="" data-page="calificaciones">
                            <i class="fas fa-chart-line"></i>
                            <span class="nav-text">Calificaciones</span>
                            <div class="tooltip-custom">Calificaciones</div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="" data-page="calendario">
                            <i class="fas fa-calendar-alt"></i>
                            <span class="nav-text">Calendario</span>
                            <div class="tooltip-custom">Calendario</div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="" data-page="mensajes">
                            <i class="fas fa-envelope"></i>
                            <span class="nav-text">Mensajes</span>
                            <div class="tooltip-custom">Mensajes</div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="" data-page="comprobantes">
                            <i class="fas fa-file-invoice"></i>
                            <span class="nav-text">Comprobantes</span>
                            <div class="tooltip-custom">Comprobantes</div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="" data-page="tutorial">
                            <i class="fas fa-play-circle"></i>
                            <span class="nav-text">Tutorial Aula Virtual</span>
                            <div class="tooltip-custom">Tutorial Aula Virtual</div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="" data-page="biblioteca">
                            <i class="fas fa-book-open"></i>
                            <span class="nav-text">Biblioteca</span>
                            <div class="tooltip-custom">Biblioteca</div>
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
            
             <style>
        :root {
            --primary-gradient: linear-gradient(120deg, #0249BB 0%, #003bb1 100%);
            --primary-color: #0249BB;
            --secondary-color: #003bb1;
        }

    

        .main-header {
            background: var(--primary-gradient);
            color: white;
            padding: 1.5rem 0;
            margin-bottom: 1.5rem;
            border-radius: 0 0 20px 20px;
            box-shadow: 0 4px 15px rgba(2, 73, 187, 0.3);
        }

        .main-header h2 {
            margin: 0;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
        }

        .header-actions {
            display: flex;
            gap: 10px;
        }

        .btn-toggle-form {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            border-radius: 10px;
            padding: 0.5rem 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-toggle-form:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            color: white;
            transform: translateY(-1px);
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .card-header {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 1rem 1.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.9rem;
        }

        .form-control, .form-select {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            padding: 0.5rem 0.75rem;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(2, 73, 187, 0.25);
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            border-radius: 8px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(2, 73, 187, 0.4);
        }

        .alert {
            border: none;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
        }

        .alert-info {
            background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
            color: #0c5460;
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
        }

        .compact-form .row {
            margin-bottom: 0.75rem;
        }

        .compact-form .mb-3 {
            margin-bottom: 0.75rem !important;
        }

        .table-container {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 1.5rem;
        }

        .table {
            margin: 0;
            font-size: 0.85rem;
        }

        .table thead th {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 0.75rem;
            font-weight: 600;
            text-align: center;
            font-size: 0.8rem;
        }

        .table tbody td {
            padding: 0.75rem;
            vertical-align: middle;
            border-color: #f8f9fa;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .btn-warning {
            background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
            border: none;
            border-radius: 6px;
            color: #212529;
            font-weight: 600;
            padding: 0.4rem 0.8rem;
            transition: all 0.3s ease;
            font-size: 0.8rem;
        }

        .btn-warning:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(255, 193, 7, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            padding: 0.6rem 1.2rem;
        }

        .modal-content {
            border: none;
            border-radius: 15px;
            overflow: hidden;
        }

        .modal-header {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 1rem 1.5rem;
        }

        .modal-title {
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title {
            color: var(--primary-color);
            font-weight: 700;
            margin: 1.5rem 0 1rem 0;
            display: flex;
            align-items: center;
            gap: 12px;
            padding-bottom: 0.5rem;
            border-bottom: 3px solid var(--primary-color);
            font-size: 1.1rem;
        }

        .select2-container--bootstrap-5 .select2-selection {
            border-radius: 8px !important;
            border: 2px solid #e9ecef !important;
            min-height: calc(1.5em + 1rem + 2px) !important;
        }

        .select2-container--bootstrap-5.select2-container--focus .select2-selection {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 0.2rem rgba(2, 73, 187, 0.25) !important;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
            color: #495057;
            line-height: 1.5;
        }

        .select2-dropdown {
            border-radius: 8px !important;
            border: 2px solid var(--primary-color) !important;
        }

        .form-collapse {
            transition: all 0.3s ease;
        }

        @media (max-width: 768px) {
            .main-header {
                padding: 1rem 0;
                margin-bottom: 1rem;
            }
            
            .main-header h2 {
                font-size: 1.3rem;
                flex-direction: column;
                gap: 10px;
            }
            
            .header-actions {
                width: 100%;
                justify-content: center;
            }
            
            .table-responsive {
                border-radius: 15px;
            }
            
            .card-body {
                padding: 1rem;
            }
        }
    </style>

    
    <div class="main-header">
        <div class="container">
            <h2>
                <div class="d-flex align-items-center gap-3">
                    <i class="fas fa-paper-plane"></i>
                    Gestión de Mensajes
                </div>
                <div class="header-actions">
                    <button class="btn btn-toggle-form" type="button" data-bs-toggle="collapse" data-bs-target="#formEnviarMensaje" aria-expanded="false" aria-controls="formEnviarMensaje">
                        <i class="fas fa-plus"></i>
                        Enviar Mensaje
                    </button>
                </div>
            </h2>
        </div>
    </div>

    <div class="container">
        @if(isset($periodoActual))
        <div class="alert alert-info">
            <i class="fas fa-calendar-alt"></i>
            <div>
                <strong>Período actual:</strong> {{ $periodoActual->nombre }} ({{ $periodoActual->fecha_inicio }} - {{ $periodoActual->fecha_fin }})
            </div>
        </div>
        @endif

        @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
        @endif

        <!-- Formulario Colapsable -->
        <div class="collapse form-collapse" id="formEnviarMensaje">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-edit"></i>
                    Nuevo Mensaje
                </div>
                <div class="card-body compact-form">
                    <form method="POST" action="{{ route('admin.mensajes.enviar') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="tipo_envio" class="form-label">
                                    <i class="fas fa-list"></i>
                                    Tipo de envío
                                </label>
                                <select class="form-select" name="tipo_envio" id="tipo_envio" onchange="toggleCampos()">
                                    <option value="individual">Individual</option>
                                    <option value="curso">Por Curso</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3" id="campoAlumno">
                                <label class="form-label">
                                    <i class="fas fa-user-graduate"></i>
                                    Alumno
                                </label>
                                <select name="alumno_id" class="form-select select2-alumno" style="width: 100%">
                                    <option value="">Seleccionar alumno...</option>
                                    @foreach($alumnos as $alumno)
                                        <option value="{{ $alumno->id }}">{{ $alumno->name }} {{ $alumno->apellido_p }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3 d-none" id="campoCurso">
                                <label class="form-label">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                    Curso
                                </label>
                                <select name="curso_periodo_id" class="form-select select2-curso" style="width: 100%">
                                    <option value="">Seleccionar curso...</option>
                                    @foreach($cursos as $curso)
                                        <option value="{{ $curso->id }}">
                                            {{ $curso->curso->nombre }} ({{ $curso->seccion }}) - {{ $curso->periodo->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-heading"></i>
                                    Título
                                </label>
                                <input type="text" class="form-control" name="titulo" placeholder="Título del mensaje" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-align-left"></i>
                                    Contenido
                                </label>
                                <textarea name="contenido" class="form-control" rows="3" placeholder="Contenido del mensaje..." required></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-calendar-plus"></i>
                                    Fecha de inicio
                                </label>
                                <input type="date" class="form-control" name="fecha_inicio" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-calendar-minus"></i>
                                    Fecha de fin
                                </label>
                                <input type="date" class="form-control" name="fecha_fin" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="collapse" data-bs-target="#formEnviarMensaje">
                                <i class="fas fa-times"></i>
                                Cancelar
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i>
                                Enviar Mensaje
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <h4 class="section-title">
            <i class="fas fa-inbox"></i>
            Mensajes Enviados
        </h4>

        {{-- ================= MENSAJES POR CURSO ================= --}}
        @if(isset($mensajes['curso']) && $mensajes['curso']->count())
            <h5 class="section-title">
                <i class="fas fa-chalkboard-teacher"></i>
                Mensajes por Curso
            </h5>
            @php
    $agrupados = $mensajes['curso']->groupBy(function ($mensaje) {
        return $mensaje->curso_periodo_id . '|' . $mensaje->created_at;
    });
@endphp
            <div class="table-container">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th><i class="fas fa-chalkboard-teacher me-1"></i>Curso</th>
                                <th><i class="fas fa-heading me-1"></i>Título</th>
                                <th><i class="fas fa-align-left me-1"></i>Contenido</th>
                                <th><i class="fas fa-calendar-plus me-1"></i>F. Inicio</th>
                                <th><i class="fas fa-calendar-minus me-1"></i>F. Fin</th>
                                <th><i class="fas fa-clock me-1"></i>Enviado</th>
                                <th><i class="fas fa-users me-1"></i>Alumnos</th>
                                <th><i class="fas fa-cogs me-1"></i>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($agrupados as $grupo)
                                @php
                                    $mensaje = $grupo->first();
                                    $curso = $mensaje->cursoPeriodo;
                                @endphp
                                <tr>
                                    <td>
                                        <strong>{{ $curso->curso->nombre }}</strong><br>
                                        <small class="text-muted">({{ $curso->seccion }}) - {{ $curso->periodo->nombre }}</small>
                                    </td>
                                    <td>{{ $mensaje->titulo }}</td>
                                    <td>{{ Str::limit($mensaje->contenido, 40) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($mensaje->fecha_inicio)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($mensaje->fecha_fin)->format('d/m/Y') }}</td>
                                    <td>{{ $mensaje->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $curso->matriculas->count() }}</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditarCurso{{ $mensaje->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal edición curso -->
                                <div class="modal fade" id="modalEditarCurso{{ $mensaje->id }}" tabindex="-1" aria-labelledby="modalLabelCurso{{ $mensaje->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <form action="{{ route('admin.mensajes.update', $mensaje->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">
                                                        <i class="fas fa-edit"></i>
                                                        Editar Mensaje por Curso
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            <i class="fas fa-heading"></i>
                                                            Título
                                                        </label>
                                                        <input type="text" name="titulo" class="form-control" value="{{ $mensaje->titulo }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            <i class="fas fa-align-left"></i>
                                                            Contenido
                                                        </label>
                                                        <textarea name="contenido" class="form-control" rows="4" required>{{ $mensaje->contenido }}</textarea>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">
                                                                <i class="fas fa-calendar-plus"></i>
                                                                Fecha Inicio
                                                            </label>
                                                            <input type="date" name="fecha_inicio" class="form-control" value="{{ \Carbon\Carbon::parse($mensaje->fecha_inicio)->format('Y-m-d') }}" required>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">
                                                                <i class="fas fa-calendar-minus"></i>
                                                                Fecha Fin
                                                            </label>
                                                            <input type="date" name="fecha_fin" class="form-control" value="{{ \Carbon\Carbon::parse($mensaje->fecha_fin)->format('Y-m-d') }}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fas fa-save"></i>
                                                        Guardar cambios
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{-- ================= MENSAJES INDIVIDUALES ================= --}}
        @if(isset($mensajes['individual']) && $mensajes['individual']->count())
            <h5 class="section-title">
                <i class="fas fa-user"></i>
                Mensajes Individuales
            </h5>
            <div class="table-container">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th><i class="fas fa-user-graduate me-1"></i>Alumno</th>
                                <th><i class="fas fa-heading me-1"></i>Título</th>
                                <th><i class="fas fa-align-left me-1"></i>Contenido</th>
                                <th><i class="fas fa-calendar-plus me-1"></i>F. Inicio</th>
                                <th><i class="fas fa-calendar-minus me-1"></i>F. Fin</th>
                                <th><i class="fas fa-clock me-1"></i>Enviado</th>
                                <th><i class="fas fa-cogs me-1"></i>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mensajes['individual'] as $mensaje)
                                <tr>
                                    <td>
                                        @if($mensaje->destinatario)
                                            <strong>{{ $mensaje->destinatario->name }}</strong><br>
                                            <small class="text-muted">{{ $mensaje->destinatario->apellido_p }}</small>
                                        @else
                                            <span class="text-muted">Sin alumno asignado</span>
                                        @endif
                                    </td>
                                    <td>{{ $mensaje->titulo }}</td>
                                    <td>{{ Str::limit($mensaje->contenido, 40) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($mensaje->fecha_inicio)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($mensaje->fecha_fin)->format('d/m/Y') }}</td>
                                    <td>{{ $mensaje->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditarIndividual{{ $mensaje->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal edición individual -->
                                <div class="modal fade" id="modalEditarIndividual{{ $mensaje->id }}" tabindex="-1" aria-labelledby="modalLabelIndividual{{ $mensaje->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <form action="{{ route('admin.mensajes.update', $mensaje->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">
                                                        <i class="fas fa-edit"></i>
                                                        Editar Mensaje Individual
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            <i class="fas fa-heading"></i>
                                                            Título
                                                        </label>
                                                        <input type="text" name="titulo" class="form-control" value="{{ $mensaje->titulo }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            <i class="fas fa-align-left"></i>
                                                            Contenido
                                                        </label>
                                                        <textarea name="contenido" class="form-control" rows="4" required>{{ $mensaje->contenido }}</textarea>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">
                                                                <i class="fas fa-calendar-plus"></i>
                                                                Fecha Inicio
                                                            </label>
                                                            <input type="date" name="fecha_inicio" class="form-control" value="{{ \Carbon\Carbon::parse($mensaje->fecha_inicio)->format('Y-m-d') }}" required>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">
                                                                <i class="fas fa-calendar-minus"></i>
                                                                Fecha Fin
                                                            </label>
                                                            <input type="date" name="fecha_fin" class="form-control" value="{{ \Carbon\Carbon::parse($mensaje->fecha_fin)->format('Y-m-d') }}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fas fa-save"></i>
                                                        Guardar cambios
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Configuración mejorada de Select2
            $('.select2-alumno').select2({
                theme: 'bootstrap-5',
                placeholder: 'Buscar alumno...',
                allowClear: true,
                width: '100%',
                dropdownAutoWidth: true,
                language: {
                    noResults: function() {
                        return "No se encontraron resultados";
                    },
                    searching: function() {
                        return "Buscando...";
                    },
                    inputTooShort: function() {
                        return "Escribe para buscar...";
                    }
                },
                // Configuración para búsqueda inmediata
                minimumInputLength: 0,
                escapeMarkup: function(markup) {
                    return markup;
                }
            });

            $('.select2-curso').select2({
                theme: 'bootstrap-5',
                placeholder: 'Buscar curso...',
                allowClear: true,
                width: '100%',
                dropdownAutoWidth: true,
                language: {
                    noResults: function() {
                        return "No se encontraron resultados";
                    },
                    searching: function() {
                        return "Buscando...";
                    },
                    inputTooShort: function() {
                        return "Escribe para buscar...";
                    }
                },
                // Configuración para búsqueda inmediata
                minimumInputLength: 0,
                escapeMarkup: function(markup) {
                    return markup;
                }
            });

            // Auto-abrir el dropdown al hacer focus
            $('.select2-alumno, .select2-curso').on('select2:open', function() {
                // Enfocar automáticamente en el campo de búsqueda
                setTimeout(function() {
                    $('.select2-search__field').focus();
                }, 100);
            });

            // Mejorar la experiencia de búsqueda
            $('.select2-alumno, .select2-curso').on('select2:select', function() {
                $(this).blur(); // Quitar el focus después de seleccionar
            });
        });

        function toggleCampos() {
            const tipo = document.getElementById('tipo_envio').value;
            const campoAlumno = document.getElementById('campoAlumno');
            const selectAlumno = campoAlumno.querySelector('select');
            
            campoAlumno.classList.toggle('d-none', tipo !== 'individual');
            selectAlumno.disabled = tipo !== 'individual';

            const campoCurso = document.getElementById('campoCurso');
            const selectCurso = campoCurso.querySelector('select');
            
            campoCurso.classList.toggle('d-none', tipo !== 'curso');
            selectCurso.disabled = tipo !== 'curso';

            // Limpiar selecciones cuando se cambia el tipo
            if (tipo === 'individual') {
                $('.select2-curso').val(null).trigger('change');
            } else {
                $('.select2-alumno').val(null).trigger('change');
            }
        }

        // Inicializar el toggle al cargar la página
       document.addEventListener('DOMContentLoaded', function() {
    toggleCampos();
    
    const toggleBtn = document.querySelector('[data-bs-toggle="collapse"][data-bs-target="#formEnviarMensaje"]');
    const formCollapse = document.getElementById('formEnviarMensaje');
    
    if (toggleBtn && formCollapse) {
        formCollapse.addEventListener('shown.bs.collapse', function() {
            toggleBtn.innerHTML = '<i class="fas fa-minus"></i> Ocultar Formulario';
        });
        
        formCollapse.addEventListener('hidden.bs.collapse', function() {
            toggleBtn.innerHTML = '<i class="fas fa-plus"></i> Enviar Mensaje';
        });
    }
});
    </script>

    
            <!-- aqui agrega -->
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



   
    
   

