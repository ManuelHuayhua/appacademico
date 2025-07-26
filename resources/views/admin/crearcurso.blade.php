<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


     <title>Gestión de Cursos</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
                        <a class="nav-link active"    href="{{ route('admin.cursos.create') }}" data-page="cursos">
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
            --primary-gradient: linear-gradient(120deg, #0249BB 0%, #003bb1 100%);
            --primary-color: #0249BB;
            --secondary-color: #003bb1;
            --light-bg: #f8f9fa;
            --border-radius: 8px;
            --shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            --shadow-hover: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .main-curs{
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        .main-container {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            margin: 15px auto;
            max-width: 1400px;
            overflow: hidden;
        }

        .header-section {
            background: var(--primary-gradient);
            color: white;
            padding: 1.5rem;
            text-align: center;
        }

        .header-section h1 {
            margin: 0;
            font-size: 2rem;
            font-weight: 300;
        }

        .content-section {
            padding: 1.5rem;
        }

        .create-button-container {
            text-align: center;
            margin-bottom: 2rem;
        }

        .btn-create-main {
            background: var(--primary-gradient);
            border: none;
            border-radius: var(--border-radius);
            padding: 1rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            box-shadow: var(--shadow);
        }

        .btn-create-main:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
            color: white;
        }

        .form-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .card-header {
            background: var(--primary-gradient);
            color: white;
            padding: 0.75rem 1rem;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .card-body {
            padding: 1rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.3rem;
            display: block;
            font-size: 0.9rem;
        }

        .form-control, .form-select {
            border: 1px solid #e9ecef;
            border-radius: 6px;
            padding: 0.5rem;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.15rem rgba(2, 73, 187, 0.25);
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            border-radius: 6px;
            padding: 0.5rem 1rem;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .btn-success {
            background: linear-gradient(120deg, #28a745 0%, #20c997 100%);
            border: none;
            border-radius: 6px;
            padding: 0.5rem 1rem;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .btn-danger {
            background: linear-gradient(120deg, #dc3545 0%, #c82333 100%);
            border: none;
            border-radius: 6px;
            padding: 0.4rem 0.8rem;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .btn-outline-primary {
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            border-radius: 6px;
            padding: 0.5rem 1rem;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .curso-item {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: var(--border-radius);
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .horario-item {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            align-items: center;
        }

        .horario-item .form-control,
        .horario-item .form-select {
            flex: 1;
            min-width: 100px;
        }

        .alert {
            border-radius: var(--border-radius);
            border: none;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        /* Filtros compactos */
        .filters-container {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .filter-row {
            display: flex;
            gap: 1rem;
            align-items: end;
            flex-wrap: wrap;
        }

        .filter-group {
            flex: 1;
            min-width: 200px;
        }

        .filter-group label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.25rem;
        }

        .filter-group input,
        .filter-group select {
            font-size: 0.85rem;
            padding: 0.4rem;
        }

        /* Cursos existentes compactos */
        .curso-existente {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: var(--border-radius);
            margin-bottom: 0.75rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .curso-existente:hover {
            border-color: var(--primary-color);
            box-shadow: var(--shadow);
        }

        .curso-existente-header {
            background: linear-gradient(90deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 0.75rem 1rem;
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            justify-content: between;
            align-items: center;
        }

        .curso-existente-body {
            padding: 1rem;
        }

        .info-compact {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 0.5rem;
            font-size: 0.85rem;
        }

        .info-compact-item {
            background: #f8f9fa;
            padding: 0.5rem;
            border-radius: 4px;
            border-left: 3px solid var(--primary-color);
        }

        .info-compact-item strong {
            color: var(--primary-color);
            font-size: 0.8rem;
        }

        .section-title {
            color: var(--primary-color);
            font-size: 1.4rem;
            font-weight: 600;
            margin: 1.5rem 0 1rem 0;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--primary-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .facultad-title {
            color: var(--primary-color);
            font-size: 1.2rem;
            font-weight: 600;
            margin: 1rem 0 0.5rem 0;
        }

        .carrera-title {
            color: #20c997;
            font-size: 1rem;
            font-weight: 600;
            margin: 0.75rem 0 0.5rem 1rem;
        }

        .no-results {
            text-align: center;
            padding: 2rem;
            color: #6c757d;
            font-style: italic;
        }

        .select2-container--default .select2-selection--single {
            border: 1px solid #e9ecef;
            border-radius: 6px;
            height: 38px;
        }

        @media (max-width: 768px) {
            .main-container {
                margin: 10px;
                border-radius: 0;
            }

            .header-section {
                padding: 1rem;
            }

            .header-section h1 {
                font-size: 1.5rem;
            }

            .content-section {
                padding: 1rem;
            }

            .filter-row {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-group {
                min-width: auto;
            }

            .horario-item {
                flex-direction: column;
                align-items: stretch;
            }

            .info-compact {
                grid-template-columns: 1fr;
            }
        }

        .facultad-section {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .facultad-header {
            background: var(--primary-gradient);
            color: white;
            padding: 1rem 1.5rem;
            font-weight: 600;
            font-size: 1.1rem;
            display: flex;
            justify-content: between;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .facultad-header:hover {
            background: linear-gradient(120deg, #003bb1 0%, #0249BB 100%);
        }

        .facultad-content {
            padding: 1.5rem;
            background: #fafbfc;
        }

        .carrera-section {
            background: white;
            border-radius: 8px;
            margin-bottom: 1rem;
            border: 1px solid #e9ecef;
            overflow: hidden;
        }

        .carrera-header {
            background: linear-gradient(90deg, #20c997 0%, #17a2b8 100%);
            color: white;
            padding: 0.75rem 1rem;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
        }

        .carrera-content {
            padding: 1rem;
        }

        .facultad-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            margin-left: auto;
        }
    </style>

<section class="main-curs">
              <div class="main-container">
        <div class="header-section">
            <h1><i class="fas fa-graduation-cap"></i> Gestión de Cursos Académicos</h1>
            <p class="mb-0">Sistema de administración de cursos y horarios</p>
        </div>

        <div class="content-section">
            {{-- Mensajes de alerta --}}
            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    <ul class="mb-0">
                        @foreach (session('success') as $msg)
                            <li>{{ $msg }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('warning'))
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <ul class="mb-0">
                        @foreach (session('warning') as $msg)
                            <li>{{ $msg }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-times-circle me-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Botón principal para crear --}}
            <div class="create-button-container">
                <button class="btn btn-create-main" type="button" data-bs-toggle="collapse" data-bs-target="#formCrearCurso" aria-expanded="false">
                    <i class="fas fa-plus me-2"></i>Crear o Agregar Curso
                </button>
            </div>

            {{-- Formulario colapsable --}}
            <div class="collapse" id="formCrearCurso">
                <form action="{{ route('admin.cursos.store') }}" method="POST">
                    @csrf
                    
                    {{-- Información Académica --}}
                    <div class="form-card">
                        <div class="card-header">
                            <i class="fas fa-university me-2"></i>Información Académica
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-building me-1"></i>Facultad
                                        </label>
                                        <select class="facultad-select form-control" name="facultad_nombre" style="width: 100%;">
                                            <option value="">-- Escribe o selecciona una facultad --</option>
                                            @foreach($facultades as $facultad)
                                                <option value="{{ $facultad->nombre }}">{{ $facultad->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-graduation-cap me-1"></i>Carrera
                                        </label>
                                        <select class="carrera-select form-control" name="carrera_nombre" style="width: 100%;">
                                            <option value="">-- Escribe o selecciona una carrera --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Período Académico --}}
                    <div class="form-card">
                        <div class="card-header">
                            <i class="fas fa-calendar-alt me-2"></i>Período Académico
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <select class="form-select" name="periodo_id" required>
                                    @if ($periodoActual)
                                        <option value="{{ $periodoActual->id }}">
                                            {{ $periodoActual->nombre }} ({{ $periodoActual->fecha_inicio }} al {{ $periodoActual->fecha_fin }})
                                        </option>
                                    @else
                                        <option value="">No hay periodo académico activo</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Configuración de Cursos --}}
                    <div class="form-card">
                        <div class="card-header">
                            <i class="fas fa-book me-2"></i>Configuración de Cursos
                        </div>
                        <div class="card-body">
                            <div id="cursos-container">
                                <div class="curso curso-item">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <i class="fas fa-book-open me-1"></i>Curso
                                                </label>
                                                <select class="curso-select form-control" name="cursos[0][nombre]" required style="width: 100%;">
                                                    <option value="">-- Escribe o selecciona un curso --</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <i class="fas fa-tag me-1"></i>Sección
                                                </label>
                                                <input type="text" class="form-control" name="cursos[0][seccion]" required placeholder="Ej: A">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <i class="fas fa-users me-1"></i>Vacantes
                                                </label>
                                                <input type="number" class="form-control" name="cursos[0][vacantes]" required min="1">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-align-left me-1"></i>Descripción
                                        </label>
                                        <textarea class="form-control" name="cursos[0][descripcion]" rows="2" placeholder="Descripción del curso"></textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <i class="fas fa-user-tie me-1"></i>Profesor
                                                </label>
                                                <select class="profesor-select form-control" name="cursos[0][profesor_id]" required style="width: 100%;">
                                                    <option value="">-- Selecciona un profesor --</option>
                                                    @foreach ($profesores as $profesor)
                                                        <option value="{{ $profesor->id }}">{{ $profesor->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    <i class="fas fa-clock me-1"></i>Turno
                                                </label>
                                                <select class="form-select" name="cursos[0][turno]" required>
                                                    <option value="">-- Selecciona un turno --</option>
                                                    <option value="mañana">Mañana</option>
                                                    <option value="tarde">Tarde</option>
                                                    <option value="noche">Noche</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="text-primary mb-2">
                                                <i class="fas fa-calendar-check me-1"></i>Fechas de Matrícula
                                            </h6>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Apertura</label>
                                                        <input type="date" class="form-control" name="cursos[0][fecha_apertura_matricula]" required>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Cierre</label>
                                                        <input type="date" class="form-control" name="cursos[0][fecha_cierre_matricula]" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="text-primary mb-2">
                                                <i class="fas fa-calendar-alt me-1"></i>Fechas de Clases
                                            </h6>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Inicio</label>
                                                        <input type="date" class="form-control" name="cursos[0][fecha_inicio_clases]" required>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Fin</label>
                                                        <input type="date" class="form-control" name="cursos[0][fecha_fin_clases]" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <h6 class="text-primary mb-2">
                                        <i class="fas fa-clock me-1"></i>Horarios
                                    </h6>
                                    <div class="horarios-container">
                                        <div class="horario horario-item">
                                            <select class="form-select" name="cursos[0][horarios][0][dia_semana]">
                                                <option value="1">Lunes</option>
                                                <option value="2">Martes</option>
                                                <option value="3">Miércoles</option>
                                                <option value="4">Jueves</option>
                                                <option value="5">Viernes</option>
                                                <option value="6">Sábado</option>
                                                <option value="7">Domingo</option>
                                            </select>
                                            <input type="time" class="form-control" name="cursos[0][horarios][0][hora_inicio]" required>
                                            <input type="time" class="form-control" name="cursos[0][horarios][0][hora_fin]" required>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="agregarHorario(this)">
                                        <i class="fas fa-plus me-1"></i>Agregar horario
                                    </button>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2 mt-3">
                                <button type="button" class="btn btn-success btn-sm" onclick="agregarCurso()">
                                    <i class="fas fa-plus me-1"></i>Agregar curso
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Guardar todo
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Filtros compactos --}}
            <div class="filters-container">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0 text-primary">
                        <i class="fas fa-filter me-2"></i>Filtros de Búsqueda
                    </h6>
                    <button class="btn btn-outline-primary btn-sm" onclick="limpiarFiltros()">
                        <i class="fas fa-times me-1"></i>Limpiar
                    </button>
                </div>
                
                <div class="filter-row">
                    <div class="filter-group">
                        <label>Período</label>
                        <form method="GET" action="{{ route('admin.cursos.create') }}" style="margin: 0;">
                            <select class="form-select" name="periodo_id" onchange="this.form.submit()">
                                @foreach($periodos as $periodo)
                                    <option value="{{ $periodo->id }}"
                                        {{ $periodo->id == $periodoSeleccionado ? 'selected' : '' }}>
                                        {{ $periodo->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                    <div class="filter-group">
                        <label>Facultad</label>
                        <input type="text" class="form-control" id="filtroFacultad" placeholder="Buscar facultad...">
                    </div>
                    <div class="filter-group">
                        <label>Carrera</label>
                        <input type="text" class="form-control" id="filtroCarrera" placeholder="Buscar carrera...">
                    </div>
                    <div class="filter-group">
                        <label>Curso</label>
                        <input type="text" class="form-control" id="filtroCurso" placeholder="Buscar curso...">
                    </div>
                    <div class="filter-group">
                        <label>Sección</label>
                        <input type="text" class="form-control" id="filtroSeccion" placeholder="Ej: A">
                    </div>
                </div>
            </div>

            {{-- Lista de cursos existentes --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="section-title mb-0">
                    <i class="fas fa-list"></i>Cursos Registrados
                    <span class="badge bg-primary ms-2" id="contadorCursos">{{ $cursos->count() }}</span>
                </h2>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="expandirTodo()">
                        <i class="fas fa-expand-alt me-1"></i>Expandir Todo
                    </button>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="contraerTodo()">
                        <i class="fas fa-compress-alt me-1"></i>Contraer Todo
                    </button>
                </div>
            </div>

            <div id="cursosContainer">
                @if ($cursos->isEmpty())
                    <div class="no-results">
                        <i class="fas fa-inbox fa-2x mb-3"></i>
                        <p>No hay cursos registrados aún.</p>
                    </div>
                @else
                    @php
                        $agrupadoPorFacultad = $cursos->groupBy(function($curso) {
                            return $curso->carrera->facultad->nombre;
                        });
                    @endphp
                    
                    @foreach ($agrupadoPorFacultad as $nombreFacultad => $cursosFacultad)
                        <div class="facultad-section facultad-group" data-facultad="{{ strtolower($nombreFacultad) }}">
                            <div class="facultad-header" data-bs-toggle="collapse" data-bs-target="#facultad-{{ $loop->index }}" aria-expanded="true">
                                <span>
                                    <i class="fas fa-university me-2"></i>{{ $nombreFacultad }}
                                </span>
                                <div class="facultad-badge">
                                    {{ $cursosFacultad->sum(function($cursos) { return $cursos->cursoPeriodos->count(); }) }} cursos
                                </div>
                            </div>
                            
                            <div class="collapse" id="facultad-{{ $loop->index }}">
                                <div class="facultad-content">
                                    @php
                                        $agrupadoPorCarrera = $cursosFacultad->groupBy(function($curso) {
                                            return $curso->carrera->nombre;
                                        });
                                    @endphp
                                    
                                    @foreach ($agrupadoPorCarrera as $nombreCarrera => $cursosCarrera)
                                        <div class="carrera-section carrera-group" data-carrera="{{ strtolower($nombreCarrera) }}">
                                            <div class="carrera-header" data-bs-toggle="collapse" data-bs-target="#carrera-{{ $loop->parent->index }}-{{ $loop->index }}" aria-expanded="true">
                                                <i class="fas fa-graduation-cap me-2"></i>{{ $nombreCarrera }}
                                                <span class="badge bg-light text-dark ms-auto">
                                                    {{ $cursosCarrera->sum(function($curso) { return $curso->cursoPeriodos->count(); }) }}
                                                </span>
                                            </div>
                                            
                                            <div class="collapse" id="carrera-{{ $loop->parent->index }}-{{ $loop->index }}">
                                                <div class="carrera-content">
                                                    @foreach ($cursosCarrera as $curso)
                                                        @foreach ($curso->cursoPeriodos as $cursoPeriodo)
                                                            <div class="curso-existente curso-item-filtrable" 
                                                                 data-curso="{{ strtolower($curso->nombre) }}" 
                                                                 data-seccion="{{ strtolower($cursoPeriodo->seccion) }}"
                                                                 data-facultad="{{ strtolower($nombreFacultad) }}"
                                                                 data-carrera="{{ strtolower($nombreCarrera) }}">
                                                                <div class="curso-existente-header">
                                                                    <div class="d-flex justify-content-between align-items-center w-100">
                                                                        <span>
                                                                            <i class="fas fa-book me-2"></i>
                                                                            {{ $curso->nombre }} - Sección {{ $cursoPeriodo->seccion }}
                                                                        </span>
                                                                        <form action="{{ route('admin.cursos.destroy', $curso->id) }}" method="POST" style="display:inline;">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este curso?')">
                                                                                <i class="fas fa-trash"></i>
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                                <div class="curso-existente-body">
                                                                    <div class="info-compact">
                                                                        <div class="info-compact-item">
                                                                            <strong>Turno:</strong> {{ ucfirst($cursoPeriodo->turno) }}
                                                                        </div>
                                                                        <div class="info-compact-item">
                                                                            <strong>Vacantes:</strong> {{ $cursoPeriodo->vacantes }}
                                                                        </div>
                                                                        <div class="info-compact-item">
                                                                            <strong>Matrícula:</strong> {{ $cursoPeriodo->fecha_apertura_matricula }} - {{ $cursoPeriodo->fecha_cierre_matricula }}
                                                                        </div>
                                                                        <div class="info-compact-item">
                                                                            <strong>Clases:</strong> {{ $cursoPeriodo->fecha_inicio_clases }} - {{ $cursoPeriodo->fecha_fin_clases }}
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    @if($curso->descripcion)
                                                                        <div class="info-compact-item mt-2">
                                                                            <strong>Descripción:</strong> {{ $curso->descripcion }}
                                                                        </div>
                                                                    @endif
                                                                    
                                                                    <div class="info-compact-item mt-2">
                                                                        <strong>Horarios:</strong>
                                                                        <div class="mt-1">
                                                                            @forelse ($cursoPeriodo->horarios as $horario)
                                                                                <span class="badge bg-primary me-1 mb-1">
                                                                                    {{ ['Lun','Mar','Mié','Jue','Vie','Sáb','Dom'][$horario->dia_semana - 1] }}
                                                                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $horario->hora_inicio)->format('H:i') }}-{{ \Carbon\Carbon::createFromFormat('H:i:s', $horario->hora_fin)->format('H:i') }}
                                                                                    ({{ $horario->profesor->name ?? 'Sin profesor' }})
                                                                                </span>
                                                                            @empty
                                                                                <span class="text-muted">Sin horarios</span>
                                                                            @endforelse
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <div id="noResultsMessage" class="no-results" style="display: none;">
                <i class="fas fa-search fa-2x mb-3"></i>
                <p>No se encontraron cursos que coincidan con los filtros aplicados.</p>
            </div>
        </div>
    </div>

    {{-- Scripts originales mantenidos --}}
    <script>
        $(document).ready(function () {     
            $('.curso-select').select2({
                tags: true,
                placeholder: 'Escribe o selecciona un curso',
                allowClear: true
            });
            
            $('.carrera-select').on('change', function () {
                const carreraNombre = $(this).val();
                const $cursoSelect = $('#cursos-container .curso').first().find('.curso-select');
                $cursoSelect.empty().append('<option value="">-- Escribe o selecciona un curso --</option>');
                if (carreraNombre) {
                    fetch(`/admin/cursos-por-nombre-carrera/${carreraNombre}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(curso => {
                                const option = new Option(curso.nombre, curso.nombre, false, false);
                                $cursoSelect.append(option);
                            });
                            $cursoSelect.val(null).trigger('change');
                        });
                }
            });

            $('.facultad-select').select2({
                tags: true,
                placeholder: 'Escribe o selecciona una facultad',
                allowClear: true
            });
            $('.carrera-select').select2({
                tags: true,
                placeholder: 'Escribe o selecciona una carrera',
                allowClear: true
            });
                    
            $('.facultad-select').on('change', function () {
                const facultadNombre = $(this).val();
                const $carreraSelect = $('.carrera-select');
                $carreraSelect.empty().append('<option value="">-- Escribe o selecciona una carrera --</option>');
                if (facultadNombre) {
                    fetch(`/admin/carreras-por-nombre-facultad/${facultadNombre}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(carrera => {
                                const option = new Option(carrera.nombre, carrera.nombre, false, false);
                                $carreraSelect.append(option);
                            });
                        });
                }                
                $carreraSelect.val(null).trigger('change');
            });

            // Filtros en tiempo real
            $('#filtroFacultad, #filtroCarrera, #filtroCurso, #filtroSeccion').on('input', function() {
                filtrarCursos();
            });
        });

        $('.profesor-select').select2({
            placeholder: 'Selecciona un profesor',
            allowClear: true
        });

        // Función de filtrado mejorada
        function filtrarCursos() {
            const filtroFacultad = $('#filtroFacultad').val().toLowerCase().trim();
            const filtroCarrera = $('#filtroCarrera').val().toLowerCase().trim();
            const filtroCurso = $('#filtroCurso').val().toLowerCase().trim();
            const filtroSeccion = $('#filtroSeccion').val().toLowerCase().trim();
            
            let cursosVisibles = 0;
            let facultadesConCursos = new Set();
            let carrerasConCursos = new Set();
            
            // Primero mostrar todos los elementos
            $('.curso-item-filtrable, .facultad-group, .carrera-group').show();
            
            $('.curso-item-filtrable').each(function() {
                const facultad = $(this).data('facultad') || '';
                const carrera = $(this).data('carrera') || '';
                const curso = $(this).data('curso') || '';
                const seccion = $(this).data('seccion') || '';
                
                let mostrar = true;
                
                // Aplicar filtros solo si tienen contenido
                if (filtroFacultad && !facultad.includes(filtroFacultad)) {
                    mostrar = false;
                }
                if (filtroCarrera && !carrera.includes(filtroCarrera)) {
                    mostrar = false;
                }
                if (filtroCurso && !curso.includes(filtroCurso)) {
                    mostrar = false;
                }
                if (filtroSeccion && !seccion.includes(filtroSeccion)) {
                    mostrar = false;
                }
                
                if (mostrar) {
                    $(this).show();
                    cursosVisibles++;
                    facultadesConCursos.add(facultad);
                    carrerasConCursos.add(carrera);
                } else {
                    $(this).hide();
                }
            });
            
            // Mostrar/ocultar grupos basado en si tienen cursos visibles
            $('.facultad-group').each(function() {
                const facultadNombre = $(this).data('facultad');
                if (facultadesConCursos.has(facultadNombre) || cursosVisibles === 0) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
            
            $('.carrera-group').each(function() {
                const carreraNombre = $(this).data('carrera');
                if (carrerasConCursos.has(carreraNombre) || cursosVisibles === 0) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
            
            // Actualizar contador
            $('#contadorCursos').text(cursosVisibles);
            
            // Mostrar mensaje de sin resultados solo si hay filtros activos y no hay resultados
            const hayFiltrosActivos = filtroFacultad || filtroCarrera || filtroCurso || filtroSeccion;
            
            if (cursosVisibles === 0 && hayFiltrosActivos) {
                $('#noResultsMessage').show();
                $('#cursosContainer').hide();
            } else {
                $('#noResultsMessage').hide();
                $('#cursosContainer').show();
            }
        }

        function limpiarFiltros() {
            $('#filtroFacultad, #filtroCarrera, #filtroCurso, #filtroSeccion').val('');
            filtrarCursos();
        }

        function expandirTodo() {
            $('.collapse').collapse('show');
        }

        function contraerTodo() {
            $('.collapse').collapse('hide');
        }
    </script>

    {{-- Variables JS generadas desde Blade --}}
    <script>
        const diasSemanaOptions = `
            <option value="1">Lunes</option>
            <option value="2">Martes</option>
            <option value="3">Miércoles</option>
            <option value="4">Jueves</option>
            <option value="5">Viernes</option>
            <option value="6">Sábado</option>
            <option value="7">Domingo</option>
        `;
        const profesoresOptions = `
            @foreach ($profesores as $profesor)
                <option value="{{ $profesor->id }}">{{ $profesor->name }}</option>
            @endforeach
        `;
    </script>

    <script>
        let cursoIndex = 1;
        function agregarCurso() {
            const container = document.getElementById('cursos-container');
            const cursoHtml = `
                <div class="curso curso-item">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="text-primary mb-0">
                            <i class="fas fa-book me-1"></i>Curso ${cursoIndex + 1}
                        </h6>
                        <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.curso').remove()">
                            <i class="fas fa-times me-1"></i>Quitar
                        </button>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-book-open me-1"></i>Curso
                                </label>
                                <select class="curso-select form-control" name="cursos[${cursoIndex}][nombre]" required style="width: 100%;">
                                    <option value="">-- Escribe o selecciona un curso --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-tag me-1"></i>Sección
                                </label>
                                <input type="text" class="form-control" name="cursos[${cursoIndex}][seccion]" required placeholder="Ej: A">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-users me-1"></i>Vacantes
                                </label>
                                <input type="number" class="form-control" name="cursos[${cursoIndex}][vacantes]" required min="1">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-align-left me-1"></i>Descripción
                        </label>
                        <textarea class="form-control" name="cursos[${cursoIndex}][descripcion]" rows="2" placeholder="Descripción del curso"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-user-tie me-1"></i>Profesor
                                </label>
                                <select class="profesor-select form-control" name="cursos[${cursoIndex}][profesor_id]" required style="width: 100%;">
                                    <option value="">-- Selecciona un profesor --</option>
                                    ${profesoresOptions}
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-clock me-1"></i>Turno
                                </label>
                                <select class="form-select" name="cursos[${cursoIndex}][turno]" required>
                                    <option value="">-- Selecciona un turno --</option>
                                    <option value="mañana">Mañana</option>
                                    <option value="tarde">Tarde</option>
                                    <option value="noche">Noche</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary mb-2">
                                <i class="fas fa-calendar-check me-1"></i>Fechas de Matrícula
                            </h6>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">Apertura</label>
                                        <input type="date" class="form-control" name="cursos[${cursoIndex}][fecha_apertura_matricula]" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">Cierre</label>
                                        <input type="date" class="form-control" name="cursos[${cursoIndex}][fecha_cierre_matricula]" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary mb-2">
                                <i class="fas fa-calendar-alt me-1"></i>Fechas de Clases
                            </h6>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">Inicio</label>
                                        <input type="date" class="form-control" name="cursos[${cursoIndex}][fecha_inicio_clases]" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">Fin</label>
                                        <input type="date" class="form-control" name="cursos[${cursoIndex}][fecha_fin_clases]" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h6 class="text-primary mb-2">
                        <i class="fas fa-clock me-1"></i>Horarios
                    </h6>
                    <div class="horarios-container">
                        <div class="horario horario-item">
                            <select class="form-select" name="cursos[${cursoIndex}][horarios][0][dia_semana]">
                                ${diasSemanaOptions}
                            </select>
                            <input type="time" class="form-control" name="cursos[${cursoIndex}][horarios][0][hora_inicio]" required>
                            <input type="time" class="form-control" name="cursos[${cursoIndex}][horarios][0][hora_fin]" required>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="agregarHorario(this)">
                        <i class="fas fa-plus me-1"></i>Agregar horario
                    </button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', cursoHtml);
            
            const carreraNombre = $('.carrera-select').val();
            if (carreraNombre) {
                const $nuevoCursoSelect = $('#cursos-container .curso').last().find('.curso-select');
                fetch(`/admin/cursos-por-nombre-carrera/${carreraNombre}`)
                    .then(response => response.json())
                    .then(data => {
                        $nuevoCursoSelect.empty().append('<option value="">-- Escribe o selecciona un curso --</option>');
                        data.forEach(curso => {
                            const option = new Option(curso.nombre, curso.nombre, false, false);
                            $nuevoCursoSelect.append(option);
                        });
                        $nuevoCursoSelect.val(null).trigger('change');
                    });
            }
            
            $('.curso-select').last().select2({
                tags: true,
                placeholder: 'Escribe o selecciona un curso',
                allowClear: true
            });
            $('.profesor-select').last().select2({
                placeholder: 'Selecciona un profesor',
                allowClear: true
            });
            
            cursoIndex++;
        }

        function agregarHorario(button) {
            const cursoDiv = button.closest('.curso');
            const horariosContainer = cursoDiv.querySelector('.horarios-container');
            const indexCurso = Array.from(document.querySelectorAll('.curso')).indexOf(cursoDiv);
            const indexHorario = horariosContainer.querySelectorAll('.horario').length;
            
            const horarioHtml = `
                <div class="horario horario-item">
                    <select class="form-select" name="cursos[${indexCurso}][horarios][${indexHorario}][dia_semana]">
                        ${diasSemanaOptions}
                    </select>
                    <input type="time" class="form-control" name="cursos[${indexCurso}][horarios][${indexHorario}][hora_inicio]" required>
                    <input type="time" class="form-control" name="cursos[${indexCurso}][horarios][${indexHorario}][hora_fin]" required>
                    <button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            horariosContainer.insertAdjacentHTML('beforeend', horarioHtml);
        }
    </script>


</section>
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



