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
                        <a class="nav-link active" href="{{ route('admin.dashboard') }}" data-page="general">
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
                        <a class="nav-link"  href="{{ route('admin.matricula.create') }}" data-page="calificaciones">
                            <i class="fas fa-chart-line"></i>
                            <span class="nav-text">Matricula</span>
                            <div class="tooltip-custom">Matricula</div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.calificaciones.index') }}" data-page="calendario">
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


        <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --info-gradient: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            --dark-gradient: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        }

      

        .main-container {
            padding: 1rem;
            animation: fadeInUp 0.8s ease-out;
        }

        /* Responsive padding */
        @media (min-width: 768px) {
            .main-container {
                padding: 2rem;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.3);
            }
            50% {
                opacity: 1;
                transform: scale(1.05);
            }
            70% {
                transform: scale(0.9);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        .page-title {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
            font-size: 1.8rem;
            text-align: center;
            margin-bottom: 1.5rem;
            animation: slideInLeft 1s ease-out;
            line-height: 1.2;
        }

        /* Responsive title */
        @media (min-width: 768px) {
            .page-title {
                font-size: 2.5rem;
                margin-bottom: 2rem;
            }
        }

        .filter-section {
            background: white;
            padding: 1rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
            animation: fadeInUp 0.8s ease-out 0.2s both;
        }

        @media (min-width: 768px) {
            .filter-section {
                padding: 1.5rem;
                margin-bottom: 2rem;
            }
        }

        .stats-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
            animation: bounceIn 0.8s ease-out;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            margin-bottom: 1rem;
            height: 100%;
        }

        @media (min-width: 768px) {
            .stats-card {
                margin-bottom: 1.5rem;
            }
            
            .stats-card:hover {
                transform: translateY(-10px) scale(1.02);
                box-shadow: 0 25px 50px rgba(0,0,0,0.2);
            }
        }

        .stats-card.primary {
            background: var(--primary-gradient);
        }

        .stats-card.success {
            background: var(--success-gradient);
        }

        .stats-card.warning {
            background: var(--warning-gradient);
        }

        .stats-card.info {
            background: var(--info-gradient);
        }

        .stats-card .card-body {
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        @media (min-width: 768px) {
            .stats-card .card-body {
                padding: 2rem;
            }
        }

        .stats-card .card-body::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        @media (min-width: 768px) {
            .stats-card:hover .card-body::before {
                top: -25%;
                right: -25%;
            }
        }

        .stats-number {
            font-size: 2rem;
            font-weight: 900;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            animation: countUp 1s ease-out 0.5s both;
        }

        @media (min-width: 768px) {
            .stats-number {
                font-size: 3rem;
            }
        }

        @keyframes countUp {
            from {
                opacity: 0;
                transform: scale(0.5);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .stats-icon {
            font-size: 2rem;
            opacity: 0.3;
            position: absolute;
            right: 1rem;
            top: 1rem;
        }

        @media (min-width: 768px) {
            .stats-icon {
                font-size: 3rem;
            }
        }

        .section-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
            overflow: hidden;
            animation: fadeInUp 0.8s ease-out;
            transition: all 0.3s ease;
        }

        @media (min-width: 768px) {
            .section-card {
                margin-bottom: 2rem;
            }
            
            .section-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 25px 50px rgba(0,0,0,0.15);
            }
        }

        .section-header {
            background: var(--dark-gradient);
            color: white;
            padding: 1rem;
            font-weight: 600;
            font-size: 1rem;
        }

        @media (min-width: 768px) {
            .section-header {
                padding: 1.5rem;
                font-size: 1.2rem;
            }
        }

        .gender-distribution {
            padding: 1rem;
        }

        @media (min-width: 768px) {
            .gender-distribution {
                padding: 2rem;
            }
        }

        .gender-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            padding: 1rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 15px;
            transition: all 0.3s ease;
            animation: slideInLeft 0.6s ease-out;
        }

        @media (min-width: 768px) {
            .gender-item:hover {
                transform: translateX(10px);
                box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            }
        }

        .gender-icon {
            font-size: 1.5rem;
            margin-right: 0.75rem;
            width: 50px;
            text-align: center;
            flex-shrink: 0;
        }

        @media (min-width: 768px) {
            .gender-icon {
                font-size: 2rem;
                margin-right: 1rem;
                width: 60px;
            }
        }

        .gender-male { color: #007bff; }
        .gender-female { color: #e91e63; }
        .gender-other { color: #6f42c1; }

        .progress-bar-custom {
            height: 6px;
            border-radius: 10px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            animation: progressFill 1.5s ease-out;
        }

        @media (min-width: 768px) {
            .progress-bar-custom {
                height: 8px;
            }
        }

        @keyframes progressFill {
            from { width: 0%; }
            to { width: var(--progress-width); }
        }

        .top-courses {
            padding: 1rem;
        }

        @media (min-width: 768px) {
            .top-courses {
                padding: 2rem;
            }
        }

        .course-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 15px;
            border-left: 5px solid;
            transition: all 0.3s ease;
            animation: slideInLeft 0.6s ease-out;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        @media (min-width: 768px) {
            .course-item {
                padding: 1.5rem;
                flex-wrap: nowrap;
                gap: 0;
            }
            
            .course-item:hover {
                transform: translateX(10px);
                box-shadow: 0 15px 30px rgba(0,0,0,0.1);
            }
        }

        .course-item:nth-child(1) { border-left-color: #ffd700; }
        .course-item:nth-child(2) { border-left-color: #c0c0c0; }
        .course-item:nth-child(3) { border-left-color: #cd7f32; }
        .course-item:nth-child(4) { border-left-color: #4facfe; }
        .course-item:nth-child(5) { border-left-color: #fa709a; }

        .course-rank {
            font-size: 1.5rem;
            font-weight: 900;
            margin-right: 0.75rem;
            opacity: 0.7;
            flex-shrink: 0;
        }

        @media (min-width: 768px) {
            .course-rank {
                font-size: 2rem;
                margin-right: 1rem;
            }
        }

        .course-info {
            flex-grow: 1;
            min-width: 0;
        }

        .course-info h6 {
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        @media (min-width: 768px) {
            .course-info h6 {
                font-size: 1rem;
                margin-bottom: 0.5rem;
            }
        }

        .course-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.4rem 0.8rem;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.8rem;
            white-space: nowrap;
            flex-shrink: 0;
        }

        @media (min-width: 768px) {
            .course-badge {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
        }

        .faculty-card {
            margin-bottom: 1.5rem;
            animation: fadeInUp 0.8s ease-out;
        }

        @media (min-width: 768px) {
            .faculty-card {
                margin-bottom: 2rem;
            }
        }

        .table-container {
            padding: 1rem;
        }

        @media (min-width: 768px) {
            .table-container {
                padding: 2rem;
            }
        }

        .table-modern {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            font-size: 0.85rem;
        }

        @media (min-width: 768px) {
            .table-modern {
                font-size: 1rem;
            }
        }

        .table-modern thead th {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 0.75rem 0.5rem;
            font-weight: 600;
            font-size: 0.8rem;
        }

        @media (min-width: 768px) {
            .table-modern thead th {
                padding: 1rem;
                font-size: 1rem;
            }
        }

        .table-modern tbody tr {
            transition: all 0.3s ease;
        }

        @media (min-width: 768px) {
            .table-modern tbody tr:hover {
                background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
                transform: scale(1.01);
            }
        }

        .table-modern tbody td {
            padding: 0.75rem 0.5rem;
            border: none;
            border-bottom: 1px solid #dee2e6;
            word-break: break-word;
        }

        @media (min-width: 768px) {
            .table-modern tbody td {
                padding: 1rem;
            }
        }

        .total-row {
            background: var(--success-gradient) !important;
            color: white;
            font-weight: 700;
        }

        .loading-animation {
            display: inline-block;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .select-modern {
            border: 2px solid #e9ecef;
            border-radius: 15px;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            background: white;
            width: 100%;
        }

        @media (min-width: 768px) {
            .select-modern {
                font-size: 1rem;
                width: auto;
            }
        }

        .select-modern:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            outline: none;
        }

        /* Mejoras específicas para móviles */
        @media (max-width: 767px) {
            .stats-card .card-body {
                text-align: center;
            }
            
            .stats-icon {
                position: static;
                display: block;
                margin: 0 auto 0.5rem auto;
                opacity: 0.6;
            }
            
            .gender-item {
                flex-direction: column;
                text-align: center;
                padding: 1.5rem 1rem;
            }
            
            .gender-icon {
                margin-right: 0;
                margin-bottom: 0.5rem;
                width: auto;
            }
            
            .course-item {
                flex-direction: column;
                text-align: center;
            }
            
            .course-rank {
                margin-right: 0;
                margin-bottom: 0.5rem;
            }
            
            .table-responsive {
                border-radius: 15px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            }
            
            .table-modern {
                margin-bottom: 0;
            }
            
            .table-modern thead th {
                white-space: nowrap;
            }
            
            .page-title {
                padding: 0 1rem;
            }
            
            .page-title i {
                display: block;
                margin-bottom: 0.5rem;
            }
        }

        /* Mejoras para tablets */
        @media (min-width: 768px) and (max-width: 991px) {
            .stats-card .card-body {
                padding: 1.5rem;
            }
            
            .stats-number {
                font-size: 2.5rem;
            }
            
            .stats-icon {
                font-size: 2.5rem;
            }
        }

        /* Grid responsivo para las cards de estadísticas */
        .stats-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        @media (min-width: 576px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 992px) {
            .stats-grid {
                grid-template-columns: repeat(4, 1fr);
                gap: 1.5rem;
            }
        }

        /* Animaciones de entrada escalonadas */
        .stats-card:nth-child(1) { animation-delay: 0.1s; }
        .stats-card:nth-child(2) { animation-delay: 0.2s; }
        .stats-card:nth-child(3) { animation-delay: 0.3s; }
        .stats-card:nth-child(4) { animation-delay: 0.4s; }

        .gender-item:nth-child(1) { animation-delay: 0.1s; }
        .gender-item:nth-child(2) { animation-delay: 0.2s; }
        .gender-item:nth-child(3) { animation-delay: 0.3s; }

        .course-item:nth-child(1) { animation-delay: 0.1s; }
        .course-item:nth-child(2) { animation-delay: 0.2s; }
        .course-item:nth-child(3) { animation-delay: 0.3s; }
        .course-item:nth-child(4) { animation-delay: 0.4s; }
        .course-item:nth-child(5) { animation-delay: 0.5s; }

        /* Ocultar efectos hover en dispositivos táctiles */
        @media (hover: none) {
            .stats-card:hover,
            .section-card:hover,
            .gender-item:hover,
            .course-item:hover,
            .table-modern tbody tr:hover {
                transform: none;
                box-shadow: inherit;
            }
        }
    </style>

   <div class="container-fluid main-container">
        <h2 class="page-title">
            <i class="fas fa-chart-line"></i>
            <span>Panel Estadístico del Sistema Académico</span>
        </h2>

        <!-- Filtro de periodo mejorado -->
        <div class="filter-section">
            <form method="GET" action="{{ route('admin.dashboard') }}">
                <div class="row align-items-center g-3">
                    <div class="col-12 col-md-auto">
                        <label for="periodo_id" class="form-label fw-bold mb-2 mb-md-0">
                            <i class="fas fa-calendar-alt me-2"></i>Seleccionar Periodo:
                        </label>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <select name="periodo_id" id="periodo_id" class="form-control select-modern" onchange="this.form.submit()">
                            @foreach($periodos as $periodo)
                                <option value="{{ $periodo->id }}" {{ $periodoId == $periodo->id ? 'selected' : '' }}>
                                    {{ $periodo->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-auto">
                        <i class="fas fa-sync-alt loading-animation text-primary" style="display: none;"></i>
                    </div>
                </div>
            </form>
        </div>

        <!-- Cards de estadísticas con grid responsivo -->
        <div class="stats-grid mb-4">
            <div class="card stats-card primary">
                <div class="card-body text-white">
                    <i class="fas fa-user-graduate stats-icon"></i>
                    <h5 class="mb-3">Total Matriculados</h5>
                    <h3 class="stats-number">{{ $totalMatriculas }}</h3>
                </div>
            </div>
            <div class="card stats-card success">
                <div class="card-body text-white">
                    <i class="fas fa-book stats-icon"></i>
                    <h5 class="mb-3">Total Cursos</h5>
                    <h3 class="stats-number">{{ $totalCursos }}</h3>
                </div>
            </div>
            <div class="card stats-card warning">
                <div class="card-body text-white">
                    <i class="fas fa-chalkboard-teacher stats-icon"></i>
                    <h5 class="mb-3">Total Profesores</h5>
                    <h3 class="stats-number">{{ $totalProfesores }}</h3>
                </div>
            </div>
            <div class="card stats-card info">
                <div class="card-body text-white">
                    <i class="fas fa-university stats-icon"></i>
                    <h5 class="mb-3">Facultades Activas</h5>
                    <h3 class="stats-number">{{ count($facultades) }}</h3>
                </div>
            </div>
        </div>

        <!-- Distribución por género mejorada -->
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-venus-mars me-2"></i>
                Distribución por Género
            </div>
            <div class="gender-distribution">
                @foreach($generos as $genero => $total)
                    <div class="gender-item">
                        <div class="gender-icon gender-{{ strtolower($genero) }}">
                            @if(strtolower($genero) == 'masculino')
                                <i class="fas fa-mars"></i>
                            @elseif(strtolower($genero) == 'femenino')
                                <i class="fas fa-venus"></i>
                            @else
                                <i class="fas fa-genderless"></i>
                            @endif
                        </div>
                        <div class="flex-grow-1 w-100">
                            <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap">
                                <strong class="fs-5">{{ ucfirst($genero) }}</strong>
                                <span class="badge bg-primary fs-6">{{ $total }} estudiantes</span>
                            </div>
                            <div class="progress mb-2" style="height: 6px;">
                                <div class="progress-bar progress-bar-custom" 
                                     style="--progress-width: {{ ($total / $totalMatriculas) * 100 }}%; width: {{ ($total / $totalMatriculas) * 100 }}%;">
                                </div>
                            </div>
                            <small class="text-muted">{{ number_format(($total / $totalMatriculas) * 100, 1) }}% del total</small>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Top cursos mejorado -->
        <div class="section-card">
            <div class="section-header">
                <i class="fas fa-trophy me-2"></i>
                Top 5 Cursos Más Matriculados
            </div>
            <div class="top-courses">
                @foreach($topCursos as $index => $tc)
                    <div class="course-item">
                        <div class="d-flex align-items-center">
                            <div class="course-rank">{{ $index + 1 }}</div>
                            <div class="course-info">
                                <h6 class="mb-1 fw-bold">{{ $tc->curso->nombre }}</h6>
                                <small class="text-muted">Sección {{ $tc->seccion }}</small>
                            </div>
                        </div>
                        <div class="course-badge">
                            {{ $tc->matriculas_count }} estudiantes
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Detalle por Facultad mejorado -->
        @foreach($facultades as $facultad)
            <div class="section-card faculty-card">
                <div class="section-header">
                    <i class="fas fa-building me-2"></i>
                    {{ $facultad->nombre }}
                </div>
                <div class="table-container">
                    @foreach($facultad->carreras as $carrera)
                        <div class="mb-4">
                            <h5 class="mb-3">
                                <i class="fas fa-graduation-cap me-2 text-primary"></i>
                                {{ $carrera->nombre }}
                            </h5>
                            @php $totalCarrera = 0; @endphp
                            <div class="table-responsive">
                                <table class="table table-modern mb-0">
                                    <thead>
                                        <tr>
                                            <th>
                                                <i class="fas fa-book me-1 d-none d-md-inline"></i>
                                                Curso
                                            </th>
                                            <th>
                                                <i class="fas fa-layer-group me-1 d-none d-md-inline"></i>
                                                Sección
                                            </th>
                                            <th>
                                                <i class="fas fa-users me-1 d-none d-md-inline"></i>
                                                Matriculados
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($carrera->cursos as $curso)
                                            @foreach($curso->cursoPeriodos as $cp)
                                                <tr>
                                                    <td class="fw-semibold">{{ $curso->nombre }}</td>
                                                    <td>
                                                        <span class="badge bg-secondary">{{ $cp->seccion }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-primary">{{ $cp->matriculas_count }}</span>
                                                    </td>
                                                    @php $totalCarrera += $cp->matriculas_count; @endphp
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="total-row">
                                            <td colspan="2" class="text-end fw-bold">
                                                <i class="fas fa-calculator me-2 d-none d-md-inline"></i>
                                                Total carrera:
                                            </td>
                                            <td class="fw-bold">{{ $totalCarrera }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

  <script>
        // Animación de números contadores
        function animateNumbers() {
            const numbers = document.querySelectorAll('.stats-number');
            numbers.forEach(number => {
                const target = parseInt(number.textContent);
                let current = 0;
                const increment = target / 50;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }
                    number.textContent = Math.floor(current);
                }, 30);
            });
        }

        // Mostrar loading al cambiar periodo
        document.getElementById('periodo_id').addEventListener('change', function() {
            document.querySelector('.loading-animation').style.display = 'inline-block';
        });

        // Inicializar animaciones cuando la página carga
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(animateNumbers, 500);
        });

        // Detectar dispositivos táctiles y ajustar comportamiento
        function isTouchDevice() {
            return (('ontouchstart' in window) ||
                   (navigator.maxTouchPoints > 0) ||
                   (navigator.msMaxTouchPoints > 0));
        }

        if (isTouchDevice()) {
            document.body.classList.add('touch-device');
        }

        // Optimización para scroll en móviles
        let ticking = false;
        function updateParallax() {
            const scrolled = window.pageYOffset;
            const parallax = document.querySelector('.page-title');
            if (parallax && window.innerWidth > 768) {
                const speed = scrolled * 0.3;
                parallax.style.transform = `translateY(${speed}px)`;
            }
            ticking = false;
        }

        window.addEventListener('scroll', function() {
            if (!ticking) {
                requestAnimationFrame(updateParallax);
                ticking = true;
            }
        });

        // Mejorar rendimiento en dispositivos móviles
        if (window.innerWidth <= 768) {
            // Reducir animaciones en móviles
            const style = document.createElement('style');
            style.textContent = `
                * {
                    animation-duration: 0.3s !important;
                    transition-duration: 0.2s !important;
                }
            `;
            document.head.appendChild(style);
        }
    </script>

            
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