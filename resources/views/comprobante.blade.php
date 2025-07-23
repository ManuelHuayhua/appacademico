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
                        <a class="nav-link" href="{{ route('alumno.cursos') }}"  data-page="cursos">
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
                        <a class="nav-link active" href="{{ route('alumno.comprobante') }}" data-page="comprobantes">

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
    .header-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-radius: 0 0 15px 15px;
    }
    .filter-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        border: none;
        margin-bottom: 2rem;
    }
    .payment-table {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .table thead th {
        background: linear-gradient(45deg, #f8f9fa, #e9ecef);
        border: none;
        font-weight: 600;
        color: #495057;
        padding: 1rem 0.75rem;
    }
    .table tbody td {
        padding: 1rem 0.75rem;
        border-bottom: 1px solid #f8f9fa;
        vertical-align: middle;
    }
    .table tbody tr:hover {
        background-color: #f8f9fa;
        transition: background-color 0.3s ease;
    }
    
    /* Responsividad para móviles */
    @media (max-width: 768px) {
        .payment-table {
            border-radius: 0;
            margin: 0 -15px;
        }
        .table-responsive {
            border: none;
        }
        .table thead {
            display: none;
        }
        .table tbody tr {
            display: block;
            margin-bottom: 1rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border: none !important;
        }
        .table tbody td {
            display: block;
            text-align: left;
            border: none;
            padding: 0.75rem 1rem;
            position: relative;
            padding-left: 40%;
        }
        .table tbody td::before {
            content: attr(data-label);
            position: absolute;
            left: 1rem;
            width: 35%;
            padding-right: 10px;
            white-space: nowrap;
            font-weight: 600;
            color: #495057;
        }
        .summary-cards .col-md-4 {
            margin-bottom: 1rem;
        }
        .header-section {
            padding: 1.5rem 0;
            margin-bottom: 1.5rem;
        }
        .header-section h1 {
            font-size: 1.5rem;
        }
        .header-section .lead {
            font-size: 1rem;
        }
        .header-section .fa-3x {
            font-size: 2rem;
        }
    }
    
    @media (max-width: 576px) {
        .container {
            padding-left: 10px;
            padding-right: 10px;
        }
        .summary-card {
            padding: 1rem;
        }
        .summary-card h4 {
            font-size: 1.2rem;
        }
        .summary-card .fa-2x {
            font-size: 1.5rem;
        }
        .filter-card .card-body {
            padding: 1rem;
        }
        .table tbody td {
            padding-left: 35%;
            font-size: 0.9rem;
        }
        .table tbody td::before {
            width: 30%;
            font-size: 0.8rem;
        }
    }
    .badge-complete {
        background: linear-gradient(45deg, #28a745, #20c997) !important;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 20px;
    }
    .badge-pending {
        background: linear-gradient(45deg, #ffc107, #fd7e14) !important;
        color: #000 !important;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 20px;
    }
    .money-positive {
        color: #28a745;
        font-weight: 600;
    }
    .money-pending {
        color: #dc3545;
        font-weight: 600;
    }
    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #6c757d;
    }
    .custom-select {
        border-radius: 10px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }
    .custom-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    .summary-cards {
        margin-bottom: 2rem;
    }
    .summary-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        border-left: 4px solid;
        transition: transform 0.3s ease;
    }
    .summary-card:hover {
        transform: translateY(-2px);
    }
    .summary-card.total { border-left-color: #007bff; }
    .summary-card.paid { border-left-color: #28a745; }
    .summary-card.pending { border-left-color: #dc3545; }
</style>

<div class="header-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-6 mb-2">
                    <i class="fas fa-receipt me-3"></i>
                    Comprobante de Pagos
                </h1>
                <p class="lead mb-0">Consulta el estado de tus pagos por periodo académico</p>
            </div>
            <div class="col-md-4 text-md-end">
                <i class="fas fa-credit-card fa-3x opacity-75"></i>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">
    <!-- Filtro de Periodo -->
    <div class="card filter-card">
        <div class="card-body">
            <form method="GET" action="{{ route('alumno.comprobante') }}">
                <div class="row align-items-center">
                    <div class="col-12 col-md-3 mb-2 mb-md-0">
                        <label for="periodo_id" class="form-label fw-bold">
                            <i class="fas fa-calendar-alt me-2 text-primary"></i>
                            Seleccionar Periodo:
                        </label>
                    </div>
                    <div class="col-12 col-md-6 mb-2 mb-md-0">
                        <select name="periodo_id" id="periodo_id" class="form-select custom-select" onchange="this.form.submit()">
                            @foreach($periodos as $periodo)
                                <option value="{{ $periodo->id }}" {{ $periodo->id == $periodoSeleccionado ? 'selected' : '' }}>
                                    {{ $periodo->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-3 text-md-end">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Actualización automática
                        </small>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(count($datos) > 0)
        <!-- Resumen de Pagos -->
        <div class="row summary-cards">
            @php
                $totalGeneral = collect($datos)->sum('monto_total');
                $totalPagado = collect($datos)->sum('monto_pagado');
                $totalPendiente = collect($datos)->sum('restante');
            @endphp
            
            <div class="col-12 col-md-4 mb-3">
                <div class="summary-card total">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-coins fa-2x text-primary"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1">Monto Total</h6>
                            <h4 class="mb-0">S/ {{ number_format($totalGeneral, 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-4 mb-3">
                <div class="summary-card paid">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1">Total Pagado</h6>
                            <h4 class="mb-0 text-success">S/ {{ number_format($totalPagado, 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-4 mb-3">
                <div class="summary-card pending">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-clock fa-2x text-danger"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1">Saldo Pendiente</h6>
                            <h4 class="mb-0 text-danger">S/ {{ number_format($totalPendiente, 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
 <!-- filtro -->
<div class="mb-3 text-end">
    <label for="filtroEstado" class="form-label me-2 fw-bold">Filtrar por Estado:</label>
    <select id="filtroEstado" class="form-select d-inline-block w-auto">
        <option value="todos">Todos</option>
        <option value="completo">Pago Completo</option>
        <option value="pendiente">Pendiente</option>
    </select>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const filtro = document.getElementById('filtroEstado');
    const filas = document.querySelectorAll('.fila-estado');

    filtro.addEventListener('change', function () {
        const estadoSeleccionado = filtro.value;

        filas.forEach(fila => {
            const estado = fila.getAttribute('data-estado');
            
            if (estadoSeleccionado === 'todos' || estado === estadoSeleccionado) {
                fila.style.display = '';
            } else {
                fila.style.display = 'none';
            }
        });
    });
});
</script>


    <!-- Tabla de Pagos -->
    <div class="payment-table">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th><i class="fas fa-book me-2"></i>Curso</th>
                        <th><i class="fas fa-users me-2"></i>Sección</th>
                        <th><i class="fas fa-clock me-2"></i>Turno</th>
                        <th><i class="fas fa-calendar me-2"></i>Periodo</th>
                        <th><i class="fas fa-tag me-2"></i>Monto Total</th>
                        <th><i class="fas fa-check me-2"></i>Monto Pagado</th>
                        <th><i class="fas fa-exclamation me-2"></i>Restante</th>
                        <th><i class="fas fa-info-circle me-2"></i>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($datos as $dato)
                        <tr class="fila-estado" data-estado="{{ (!is_null($dato['monto_total']) && $dato['monto_pagado'] >= $dato['monto_total']) ? 'completo' : 'pendiente' }}">

                            <td data-label="Curso">
                                <strong>{{ $dato['curso'] }}</strong>
                            </td>
                            <td data-label="Sección">
                                <span class="badge bg-light text-dark">{{ $dato['seccion'] }}</span>
                            </td>
                            <td data-label="Turno">{{ ucfirst($dato['turno']) }}</td>
                            <td data-label="Periodo">{{ $dato['periodo'] }}</td>
                            <td data-label="Monto Total">
                                <span class="money-positive">
                                    <i class="fas fa-coins me-1"></i>
                                    {{ is_null($dato['monto_total']) ? '--' : 'S/ ' . number_format($dato['monto_total'], 2) }}
                                </span>
                            </td>
                            <td data-label="Monto Pagado">
                                <span class="money-positive">
                                    <i class="fas fa-check-circle me-1"></i>
                                    S/ {{ number_format($dato['monto_pagado'], 2) }}
                                </span>
                            </td>
                            <td data-label="Restante">
                                <span class="{{ $dato['restante'] > 0 ? 'money-pending' : 'money-positive' }}">
                                    <i class="fas fa-{{ $dato['restante'] > 0 ? 'exclamation-triangle' : 'check' }} me-1"></i>
                                    S/ {{ number_format($dato['restante'], 2) }}
                                </span>
                            </td>
                            <td data-label="Estado">
                               @if(!is_null($dato['monto_total']) && $dato['monto_pagado'] >= $dato['monto_total'])
                                    <span class="badge badge-complete">
                                        <i class="fas fa-check me-1"></i>
                                        Pago Completo
                                    </span>
                                @else
                                    <span class="badge badge-pending">
                                        <i class="fas fa-clock me-1"></i>
                                        Pendiente
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="border-0">
                                <div class="empty-state">
                                    <i class="fas fa-inbox fa-4x mb-3"></i>
                                    <h4 class="mb-3">No hay registros</h4>
                                    <p class="mb-0">No hay cursos matriculados en este periodo académico.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if(count($datos) > 0)
        <div class="text-center mt-4">
            <small class="text-muted">
                <i class="fas fa-info-circle me-1"></i>
                Mostrando {{ count($datos) }} curso(s) para el periodo seleccionado
            </small>
        </div>
    @endif
</div>
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

