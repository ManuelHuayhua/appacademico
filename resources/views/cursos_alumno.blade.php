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
                        <a class="nav-link " href="{{ route('home') }}" data-page="general">
                            <i class="fas fa-home"></i>
                            <span class="nav-text">General</span>
                            <div class="tooltip-custom">General</div>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('alumno.perfil') }}" data-page="perfil">
                            <i class="fas fa-user"></i>
                            <span class="nav-text">Perfil</span>
                            <div class="tooltip-custom">Perfil</div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('alumno.cursos') }}"  data-page="cursos">
                            <i class="fas fa-book"></i>
                            <span class="nav-text">Cursos</span>
                            <div class="tooltip-custom">Cursos</div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('alumno.calificaciones.index') }}"  data-page="calificaciones">
                            <i class="fas fa-chart-line"></i>
                            <span class="nav-text">Calificaciones</span>
                            <div class="tooltip-custom">Calificaciones</div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('alumno.calendario') }}" data-page="calendario">
                            <i class="fas fa-calendar-alt"></i>
                            <span class="nav-text">Calendario</span>
                            <div class="tooltip-custom">Calendario</div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('alumno.silabus') }}" data-page="silabus">
                           <i class="fas fa-book-open"></i>
                            <span class="nav-text">Sílabo</span>
                            <div class="tooltip-custom">Sílabo</div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('alumno.comprobante') }}" data-page="comprobantes">

                            <i class="fas fa-file-invoice"></i>
                            <span class="nav-text">Comprobantes</span>
                            <div class="tooltip-custom">Comprobantes</div>
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
        --primary-light: rgba(2, 73, 187, 0.1);
        --primary-color: #0249BB;
        --success-gradient: linear-gradient(120deg, #10b981 0%, #059669 100%);
        --danger-gradient: linear-gradient(120deg, #ef4444 0%, #dc2626 100%);
        --warning-gradient: linear-gradient(120deg, #f59e0b 0%, #d97706 100%);
        --secondary-gradient: linear-gradient(120deg, #6b7280 0%, #4b5563 100%);
        --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --card-shadow-hover: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --border-radius: 12px;
        --border-radius-sm: 8px;
        --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

   

    .main-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        border: 1px solid rgba(255, 255, 255, 0.2);
        max-width: 1400px;
        margin: 0 auto;
    }

    .page-header {
        background: var(--primary-gradient);
        color: white;
        padding: 1.5rem 2rem;
        border-radius: var(--border-radius) var(--border-radius) 0 0;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }

    .page-header .content {
        position: relative;
        z-index: 1;
    }

    .page-title {
        font-weight: 700;
        font-size: 1.75rem;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .page-subtitle {
        opacity: 0.9;
        font-weight: 400;
        font-size: 0.9rem;
        margin-top: 0.25rem;
    }

    .filter-card {
        background: white;
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        margin: 1.5rem;
        margin-bottom: 1rem;
        padding: 1.25rem;
    }

    .filter-card:hover {
        transform: translateY(-1px);
        box-shadow: var(--card-shadow-hover);
    }

    .form-select {
        border: 1px solid #e2e8f0;
        border-radius: var(--border-radius-sm);
        padding: 0.625rem 0.875rem;
        font-weight: 500;
        font-size: 0.875rem;
        transition: var(--transition);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%230249BB' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 7 7 7-7'/%3e%3c/svg%3e");
    }

    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px var(--primary-light);
        outline: none;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    .alert-modern {
        background: linear-gradient(120deg, #dbeafe 0%, #e0e7ff 100%);
        border: none;
        border-radius: var(--border-radius);
        border-left: 4px solid var(--primary-color);
        box-shadow: var(--card-shadow);
        margin: 1.5rem;
        padding: 1.25rem;
    }

    .table-container {
        margin: 1.5rem;
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--card-shadow);
        background: white;
    }

    .table {
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.875rem;
    }

    .table thead th {
        background: var(--primary-gradient);
        color: white;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 1rem 0.875rem;
        border: none;
        position: relative;
    }

    .table tbody tr {
        transition: var(--transition);
        border: none;
    }

    .table tbody tr:hover {
        background: linear-gradient(120deg, #f8fafc 0%, #f1f5f9 100%);
        transform: translateX(2px);
    }

    .table tbody td {
        padding: 1rem 0.875rem;
        border-top: 1px solid #f1f5f9;
        vertical-align: middle;
        font-weight: 500;
    }

    .course-name {
        font-weight: 700;
        color: #1f2937;
        font-size: 0.95rem;
    }

    .badge-modern {
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        border: none;
        position: relative;
        overflow: hidden;
    }

    .badge-success {
        background: var(--success-gradient);
        color: white;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
    }

    .badge-danger {
        background: var(--danger-gradient);
        color: white;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
    }

    .badge-secondary {
        background: var(--secondary-gradient);
        color: white;
        box-shadow: 0 2px 8px rgba(107, 114, 128, 0.3);
    }

    .btn-modern {
        border-radius: var(--border-radius-sm);
        font-weight: 600;
        padding: 0.5rem 1rem;
        font-size: 0.8rem;
        transition: var(--transition);
        border: none;
        position: relative;
        overflow: hidden;
    }

    .btn-primary-modern {
        background: var(--primary-gradient);
        color: white;
        box-shadow: 0 2px 8px rgba(2, 73, 187, 0.3);
    }

    .btn-primary-modern:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(2, 73, 187, 0.4);
        color: white;
    }

    .btn-outline-modern {
        background: transparent;
        border: 1.5px solid var(--primary-color);
        color: var(--primary-color);
    }

    .btn-outline-modern:hover {
        background: var(--primary-gradient);
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(2, 73, 187, 0.3);
    }

    .modal-content {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }

    .modal-header {
        background: var(--primary-gradient);
        color: white;
        border: none;
        padding: 1.25rem 1.5rem;
    }

    .modal-title {
        font-weight: 700;
        font-size: 1.1rem;
    }

    .btn-close {
        filter: brightness(0) invert(1);
        opacity: 0.8;
    }

    .modal-body {
        padding: 1.5rem;
        background: #fafbfc;
    }

    .modal-footer {
        background: white;
        border: none;
        padding: 1rem 1.5rem;
    }

    .attendance-table {
        background: white;
        border-radius: var(--border-radius-sm);
        overflow: hidden;
        box-shadow: var(--card-shadow);
    }

    .attendance-table .table {
        font-size: 0.8rem;
    }

    .attendance-table .table thead th {
        background: linear-gradient(120deg, #f8fafc 0%, #e2e8f0 100%);
        color: #374151;
        font-weight: 600;
        padding: 0.875rem;
    }

    .attendance-table .table tbody td {
        padding: 0.75rem 0.875rem;
    }

    /* Responsive Design Optimizado */
    @media (max-width: 1200px) {
        .main-container {
            margin: 1rem;
        }
    }

    @media (max-width: 992px) {
        .page-title {
            font-size: 1.5rem;
        }
        
        .table thead th {
            padding: 0.75rem 0.5rem;
            font-size: 0.7rem;
        }
        
        .table tbody td {
            padding: 0.875rem 0.5rem;
        }
    }

    @media (max-width: 767.98px) {
        body {
            font-size: 13px;
        }
        
        .page-title {
            font-size: 1.4rem;
        }
        
        .page-subtitle {
            font-size: 0.8rem;
        }
        
        .main-container {
            margin: 0.5rem;
            border-radius: var(--border-radius-sm);
        }
        
        .page-header {
            padding: 1.25rem 1.5rem;
            border-radius: var(--border-radius-sm) var(--border-radius-sm) 0 0;
        }
        
        .filter-card,
        .table-container,
        .alert-modern {
            margin: 1rem;
        }

        .filter-card {
            padding: 1rem;
        }

        .table-container {
            border-radius: var(--border-radius-sm);
            box-shadow: none;
            background: transparent;
        }

        .table,
        .table thead,
        .table tbody,
        .table th,
        .table td,
        .table tr {
            display: block;
        }

        .table thead tr {
            position: absolute;
            top: -9999px;
            left: -9999px;
        }

        .table tbody tr {
            background: white;
            border-radius: var(--border-radius-sm);
            box-shadow: var(--card-shadow);
            margin-bottom: 0.875rem;
            padding: 1.25rem;
            position: relative;
            border-left: 3px solid var(--primary-color);
        }

        .table tbody tr:hover {
            transform: none;
            background: white;
        }

        .table tbody td {
            border: none;
            padding: 0.5rem 0;
            text-align: right;
            padding-left: 45%;
            position: relative;
            font-size: 0.8rem;
        }

        .table tbody td:before {
            content: attr(data-label);
            position: absolute;
            left: 0;
            width: 40%;
            padding-right: 10px;
            white-space: nowrap;
            font-weight: 700;
            color: var(--primary-color);
            text-align: left;
            font-size: 0.75rem;
        }

        .table tbody td:last-child {
            text-align: center;
            padding-left: 0;
            padding-top: 0.875rem;
            border-top: 1px solid #f1f5f9;
            margin-top: 0.875rem;
        }

        .table tbody td:last-child:before {
            display: none;
        }

        .btn-modern {
            width: 100%;
            padding: 0.75rem;
            font-size: 0.8rem;
        }

        .course-name {
            font-size: 0.9rem;
        }

        .badge-modern {
            font-size: 0.65rem;
            padding: 0.3rem 0.6rem;
        }

        .modal-dialog {
            margin: 1rem;
        }

        .modal-body {
            padding: 1.25rem;
        }

        .attendance-table .table {
            font-size: 0.75rem;
        }
    }

    @media (max-width: 576px) {
        .main-container {
            margin: 0.25rem;
        }
        
        .page-header {
            padding: 1rem;
        }
        
        .page-title {
            font-size: 1.25rem;
        }
        
        .filter-card,
        .table-container,
        .alert-modern {
            margin: 0.75rem;
        }

        .table tbody tr {
            padding: 1rem;
        }

        .table tbody td {
            padding-left: 50%;
        }

        .table tbody td:before {
            width: 45%;
        }
    }

    /* Animaciones optimizadas */
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .table tbody tr {
        animation: slideInUp 0.3s ease-out;
    }

    .table tbody tr:nth-child(2n) {
        animation-delay: 0.05s;
    }

    .table tbody tr:nth-child(3n) {
        animation-delay: 0.1s;
    }

    /* Mejoras adicionales para UX */
    .icon-text {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
    }

    .text-truncate-custom {
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    @media (max-width: 767.98px) {
        .text-truncate-custom {
            max-width: none;
            white-space: normal;
        }
    }

    /* Loading states */
    .btn-modern:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none !important;
    }

    /* Focus states mejorados */
    .btn-modern:focus,
    .form-select:focus {
        outline: 2px solid var(--primary-color);
        outline-offset: 2px;
    }
</style>
<div class="container-fluid py-3">
    <div class="main-container">
        <!-- Header compacto -->
        <div class="page-header">
            <div class="content">
                <div class="d-flex align-items-center">
                    <i class="fas fa-graduation-cap fa-2x me-3"></i>
                    <div>
                        <h1 class="page-title">Mis Cursos</h1>
                        <p class="page-subtitle mb-0">Gestiona tus cursos matriculados y revisa tu asistencia</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filtro por periodo compacto --}}
        <div class="filter-card">
            <form method="GET">
                <div class="mb-0">
                    <label for="periodo_id" class="form-label icon-text">
                        <i class="fas fa-filter"></i>
                        <span>Filtrar por periodo académico</span>
                    </label>
                    <select name="periodo_id" id="periodo_id" class="form-select" onchange="this.form.submit()">
                        @foreach($periodos as $periodo)
                            <option value="{{ $periodo->id }}" {{ $periodo->id == $periodoSeleccionadoId ? 'selected' : '' }}>
                                {{ $periodo->nombre }} ({{ \Carbon\Carbon::parse($periodo->fecha_inicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($periodo->fecha_fin)->format('d/m/Y') }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        @if($cursos->isEmpty())
            <div class="alert alert-modern text-center" role="alert">
                <div class="icon-text justify-content-center mb-2">
                    <i class="fas fa-info-circle fa-2x" style="color: var(--primary-color);"></i>
                </div>
                <h6 class="fw-bold mb-1">No hay cursos matriculados</h6>
                <p class="mb-0 small">No estás matriculado en ningún curso para este periodo académico.</p>
            </div>
        @else
           <div class="table-responsive">
    <table class="table mb-0">
        <thead>
            <tr>
                <th scope="col"><i class="fas fa-book"></i><span>Curso</span></th>
                <th scope="col"><i class="fas fa-align-left"></i><span>Descripción</span></th>
                <th scope="col"><i class="fas fa-calendar"></i><span>Periodo</span></th>
                <th scope="col"><i class="fas fa-users"></i><span>Sección</span></th>
                <th scope="col"><i class="fas fa-calendar-plus"></i><span>Matrícula</span></th>
                <th scope="col"><i class="fas fa-check-circle"></i><span>Estado</span></th>
                <th scope="col"><i class="fas fa-eye"></i><span>Asistencias</span></th>
            </tr>
        </thead>
        <tbody>
            @foreach($cursos as $curso)
                <tr>
                    <td data-label="Curso" class="course-name">
                        <div class="icon-text">
                            <i class="fas fa-book-open text-primary"></i>
                            <span class="text-truncate-custom">{{ $curso->curso }}</span>
                        </div>
                    </td>
                    <td data-label="Descripción">
                        <span class="text-truncate-custom">{{ $curso->descripcion ?? '—' }}</span>
                    </td>
                    <td data-label="Periodo">
                        <div class="icon-text">
                            <i class="fas fa-calendar-alt text-muted"></i>
                            <span>{{ $curso->periodo }}</span>
                        </div>
                    </td>
                    <td data-label="Sección">
                        <div class="icon-text">
                            <i class="fas fa-layer-group text-muted"></i>
                            <span>{{ $curso->seccion }}</span>
                        </div>
                    </td>
                    <td data-label="Fecha de matrícula">
                        <div class="icon-text">
                            <i class="fas fa-calendar-check text-muted"></i>
                            <span>{{ \Carbon\Carbon::parse($curso->fecha_matricula)->format('d/m/Y') }}</span>
                        </div>
                    </td>
                    <td data-label="Estado">
                        @php
                            $estadoClass = '';
                            $icon = '';
                            if ($curso->estado === 'activo') {
                                $estadoClass = 'badge-success';
                                $icon = 'fas fa-check';
                            } elseif ($curso->estado === 'inactivo') {
                                $estadoClass = 'badge-danger';
                                $icon = 'fas fa-times';
                            } else {
                                $estadoClass = 'badge-secondary';
                                $icon = 'fas fa-pause';
                            }
                        @endphp
                        <span class="badge badge-modern {{ $estadoClass }}">
                            <i class="{{ $icon }} me-1"></i>{{ ucfirst($curso->estado) }}
                        </span>
                    </td>
                    <td data-label="Acciones">
                        <button class="btn btn-modern btn-outline-modern" data-bs-toggle="modal" data-bs-target="#modalAsistencia{{ $curso->curso_periodo_id }}">
                            <i class="fas fa-chart-line me-1"></i>Ver Asistencias
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
        @endif
    </div>
</div>

{{-- MODALES DE ASISTENCIA COMPACTOS --}}
@foreach($cursos as $curso)
<div class="modal fade" id="modalAsistencia{{ $curso->curso_periodo_id }}" tabindex="-1" aria-labelledby="label{{ $curso->curso_periodo_id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="label{{ $curso->curso_periodo_id }}">
                    <div class="icon-text">
                        <i class="fas fa-chart-bar"></i>
                        <span>Asistencias - {{ $curso->curso }}</span>
                    </div>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <small class="text-muted icon-text">
                        <i class="fas fa-info-circle"></i>
                        <span>Sección {{ $curso->seccion }} - Periodo {{ $curso->periodo }}</span>
                    </small>
                </div>
                
                @php
                    $asistencias = DB::table('asistencias')
                        ->where('user_id', auth()->id())
                        ->where('curso_periodo_id', $curso->curso_periodo_id)
                        ->orderBy('fecha')
                        ->get();
                @endphp
                
                @if($asistencias->isEmpty())
                    <div class="text-center py-4">
                        <i class="fas fa-calendar-times fa-2x text-muted mb-2"></i>
                        <h6 class="text-muted mb-1">Sin registros de asistencia</h6>
                        <small class="text-muted">No hay asistencias registradas para este curso.</small>
                    </div>
                @else
                    <div class="attendance-table">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th scope="col" class="icon-text">
                                        <i class="fas fa-calendar"></i><span>Fecha</span>
                                    </th>
                                    <th scope="col" class="icon-text">
                                        <i class="fas fa-user-check"></i><span>Estado</span>
                                    </th>
                                    <th scope="col" class="icon-text text-center">
            <i class="fas fa-file-alt"></i><span>Material</span>
        </th>
        <th scope="col" class="icon-text text-center">
            <i class="fas fa-video"></i><span>Grabada</span>
        </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($asistencias as $asistencia)
                                    <tr>
                                        <td>
                                            <div class="icon-text">
                                                <i class="fas fa-calendar-day text-primary"></i>
                                                <span>{{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}</span>
                                            </div>
                                          

                                        </td>
                                        <td>
                                            @php
                                                $asistenciaClass = '';
                                                $icon = '';
                                                $text = '';
                                                if (is_null($asistencia->asistio)) {
                                                    $asistenciaClass = 'badge-secondary';
                                                    $icon = 'fas fa-clock';
                                                    $text = 'Pendiente';
                                                } elseif ($asistencia->asistio) {
                                                    $asistenciaClass = 'badge-success';
                                                    $icon = 'fas fa-check';
                                                    $text = 'Presente';
                                                } else {
                                                    $asistenciaClass = 'badge-danger';
                                                    $icon = 'fas fa-times';
                                                    $text = 'Ausente';
                                                }
                                            @endphp
                                            <span class="badge badge-modern {{ $asistenciaClass }}">
                                                <i class="{{ $icon }} me-1"></i>{{ $text }}
                                            </span>
                                        </td>

                                         </td>
            <td class="text-center">
                @if($asistencia->url_material)
                    <a href="{{ $asistencia->url_material }}" target="_blank" title="Ver material">
                        <i class="fas fa-file-alt fa-lg text-primary"></i>
                    </a>
                @else
                    <i class="fas fa-file-alt fa-lg text-muted"></i>
                @endif
            </td>
            <td class="text-center">
                @if($asistencia->url_grabada)
                    <a href="{{ $asistencia->url_grabada }}" target="_blank" title="Ver clase grabada">
                        <i class="fas fa-video fa-lg text-primary"></i>
                    </a>
                @else
                    <i class="fas fa-video fa-lg text-muted"></i>
                @endif
            </td>
            
                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-modern btn-outline-modern" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
@endforeach






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




