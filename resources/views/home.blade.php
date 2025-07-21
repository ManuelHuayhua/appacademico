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
                        <a class="nav-link active" href="{{ route('home') }}" data-page="general">
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
            <br>
            <!-- Content -->

    {{-- Modal de mensajes importantes --}}
    @if(isset($mensajes) && $mensajes->isNotEmpty())
        <div class="modal fade" id="mensajesModal" tabindex="-1" aria-labelledby="mensajesModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="mensajesModalLabel"><i class="fas fa-bullhorn me-2"></i> Mensajes Importantes</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        @foreach($mensajes as $mensaje)
                            <div class="alert alert-info shadow-sm border-start border-4 border-primary mb-3">
                                <strong>{{ $mensaje->titulo }}</strong><br>
                                {{ $mensaje->contenido }}
                            </div>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

   @if(isset($mensajes) && $mensajes->isNotEmpty())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modal = new bootstrap.Modal(document.getElementById('mensajesModal'));
            modal.show();
        });
    </script>
    @endif

              <!-- Content -->

         


 <!-- Content -->
<div class="content-area">



 <style>
        :root {
            --primary-blue: #0249BB;
            --dark-blue: #003BB1;
            --warning-orange: #ff6b35;
            --light-gray: #f8f9fa;
        }

        .custom-banner-height {
            height: 300px;
        }

        @media (min-width: 536px) {
            .custom-banner-height {
                height: 450px;
            }
        }

        .custom-banner-altura {
            min-height: 400px;
        }

        @media (min-width: 992px) {
            .custom-banner-altura {
                min-height: 550px;
            }
        }

        .text-truncate-2-lines {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.4;
        }

        .carousel-item img {
            filter: brightness(0.8);
            transition: all 0.3s ease;
        }

        .carousel-item.active img {
            filter: brightness(1);
        }

        .btn-glow {
            box-shadow: 0 0 20px rgba(255, 107, 53, 0.4);
            transition: all 0.3s ease;
        }

        .btn-glow:hover {
            box-shadow: 0 0 30px rgba(255, 107, 53, 0.6);
            transform: translateY(-2px);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1) !important;
        }

        .news-item {
            transition: all 0.2s ease;
            border-radius: 12px;
            padding: 15px;
        }

        .news-item:hover {
            background-color: var(--light-gray);
            transform: translateX(5px);
        }

        .news-image {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .news-image:hover {
            transform: scale(1.05);
        }

        .gradient-overlay {
            background: linear-gradient(135deg, rgba(2, 73, 187, 0.9) 0%, rgba(0, 59, 177, 0.7) 50%, rgba(2, 73, 187, 0.8) 100%);
        }

        .learning-card-bg {
            background: linear-gradient(135deg, rgba(2, 73, 187, 0.95) 0%, rgba(0, 59, 177, 0.85) 100%);
        }

        .pulse-animation {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .fade-in-up {
            animation: fadeInUp 0.8s ease-out;
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

        .modern-shadow {
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1), 0 8px 25px rgba(0, 0, 0, 0.06);
        }

        .icon-badge {
            background: linear-gradient(135deg, var(--warning-orange), #ff8f65);
            width: 50px;
            height: 50px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }

        .progress-indicator {
            background: linear-gradient(90deg, var(--warning-orange) 0%, #ff8f65 100%);
            height: 4px;
            border-radius: 2px;
            margin-top: 1rem;
        }

        .news-badge {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            font-size: 0.75rem;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 600;
        }

        .shimmer {
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
    </style>
</head>


<!-- Sección de Carrusel/Banner Superior -->
<div class="container-fluid mb-5 fade-in-up">
    <div class="position-relative overflow-hidden rounded-4 modern-shadow custom-banner-height" style="background-color: var(--primary-blue);">
        
        <!-- Contenido del banner -->
        <div id="carouselExampleIndicators" class="carousel slide h-100" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner h-100">
                <div class="carousel-item active h-100">
                    <img src="https://image.ondacero.es/clipping/cmsimages01/2025/07/11/BFACE3C9-9406-433A-A3F5-22E8F4B4B191/universidad-extremadura-ocupa-posicion-numero-13-universidades-espanolas-titulaciones-titulados_103.jpg?crop=1920,1440,x0,y0&width=1200&height=900&optimize=low&format=webply" class="d-block w-100 h-100 object-fit-cover" alt="Banner 1">
                </div>
                <div class="carousel-item h-100">
                    <img src="https://imagenes.20minutos.es/files/image_990_556/files/fp/uploads/imagenes/2022/08/28/estudiantes-universitarios.r_d.3355-2237.jpeg" class="d-block w-100 h-100 object-fit-cover" alt="Banner 2">
                </div>
                <div class="carousel-item h-100">
                    <img src="https://imagenes.20minutos.es/files/image_990_556/files/fp/uploads/imagenes/2022/08/28/estudiantes-universitarios.r_d.3355-2237.jpeg" class="d-block w-100 h-100 object-fit-cover" alt="Banner 3">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</div>

<!-- Sección Inferior de Contenido -->
<div class="container-fluid fade-in-up">
    <div class="row g-4">
        <!-- Columna Izquierda: Imagen de Fondo con Texto -->
        <div class="col-12 col-lg-8">
            <div class="position-relative overflow-hidden rounded-4 modern-shadow d-flex align-items-center p-4 p-md-5 custom-banner-altura card-hover" style="background-color: var(--primary-blue);">

                <!-- Imagen de fondo y overlay -->
                <div class="position-absolute w-100 h-100" style="background-image: url('https://www.infobae.com/resizer/v2/https%3A%2F%2Fs3.amazonaws.com%2Farc-wordpress-client-uploads%2Finfobae-wp%2Fwp-content%2Fuploads%2F2016%2F11%2F25090433%2FUniversidad-Austral-1920.jpg?auth=295e8c7c90fd29faaaf230dc03033415f3a275abdfa87d1e03fac004f7069c27&smart=true&width=1200&height=900&quality=85'); background-size: cover; background-position: center;"></div>
                <div class="position-absolute w-100 h-100 learning-card-bg"></div>

                <!-- Contenido de la tarjeta de aprendizaje -->
                <div class="position-relative z-1 text-white" style="max-width: 500px;">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-badge me-3">
                            <i class="fas fa-play"></i>
                        </div>
                        <span class="badge news-badge">Continúa Aprendiendo</span>
                    </div>
                    
                    <h1 class="display-5 fw-bolder lh-1 mb-3">
                        Contabilidad 
                        <span style="color: var(--warning-orange);">BÁSICA</span>
                    </h1>
                    
                    <div class="mb-4">
                        <p class="fs-5 mb-2 opacity-90">
                            <i class="fas fa-bookmark me-2"></i>
                            Sesión 06: Beneficios Sociales-2024
                        </p>
                        <div class="d-flex align-items-center text-white-50">
                            <i class="fas fa-clock me-2"></i>
                            <span class="me-3">2h 30min restantes</span>
                            <i class="fas fa-chart-line me-2"></i>
                            <span>75% completado</span>
                        </div>
                        <div class="progress-indicator" style="width: 75%;"></div>
                    </div>
                    
                    <div class="d-flex flex-column flex-sm-row gap-3">
                        <button class="btn btn-warning btn-lg rounded-pill fw-bold btn-glow pulse-animation">
                            <i class="fas fa-play me-2"></i>
                            Continuar Curso
                        </button>
                        <button class="btn btn-outline-light btn-lg rounded-pill fw-semibold">
                            <i class="fas fa-book-open me-2"></i>
                            Mis Cursos
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Columna Derecha: Noticias -->
        <div class="col-12 col-lg-4">
            <div class="card rounded-4 modern-shadow p-4 card-hover h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h3 class="fs-4 fw-bold text-dark mb-1">
                            <i class="fas fa-newspaper me-2" style="color: var(--warning-orange);"></i>
                            NOTICIAS
                        </h3>
                        <p class="text-muted small mb-0">Mantente actualizado</p>
                    </div>
                    <a href="#" class="btn btn-outline-primary btn-sm rounded-pill">
                        <i class="fas fa-arrow-right me-1"></i>
                        Ver Blog
                    </a>
                </div>

                <div class="d-flex flex-column gap-3">
                    <!-- Noticia 1 -->
                    <div class="news-item d-flex align-items-start">
                        <div class="position-relative me-3">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR690ND98zM-XCQM-jMKT1F5Szk17y8r5t65g&s" alt="Noticia 1" class="news-image" style="width: 90px; height: 90px; object-fit: cover;">
                            <span class="position-absolute top-0 start-0 badge bg-danger rounded-pill" style="font-size: 0.6rem; margin: 5px;">
                                <i class="fas fa-fire"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-primary me-2" style="font-size: 0.7rem;">Economía</span>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>Hace 2h
                                </small>
                            </div>
                            <h4 class="fs-6 fw-semibold text-dark mb-2">FMI advierte sobre impacto fiscal de Zonas Económicas Especiales</h4>
                            <p class="text-muted small mb-2 text-truncate-2-lines">El Fondo Monetario Internacional ha alertado sobre el posible impacto fiscal negativo de las zonas económicas especiales...</p>
                            <a href="#" class="text-primary text-decoration-none small fw-semibold">
                                <i class="fas fa-arrow-right me-1"></i>Leer más
                            </a>
                        </div>
                    </div>

                    <hr class="my-2 opacity-25">

                    <!-- Noticia 2 -->
                    <div class="news-item d-flex align-items-start">
                        <div class="position-relative me-3">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR690ND98zM-XCQM-jMKT1F5Szk17y8r5t65g&s" alt="Noticia 2" class="news-image" style="width: 90px; height: 90px; object-fit: cover;">
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-success me-2" style="font-size: 0.7rem;">Tributario</span>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>Hace 5h
                                </small>
                            </div>
                            <h4 class="fs-6 fw-semibold text-dark mb-2">Exoneración del Impuesto predial para adultos mayores en 2025</h4>
                            <p class="text-muted small mb-2 text-truncate-2-lines">Nueva normativa beneficia a propietarios mayores de 65 años con exoneración total del impuesto predial...</p>
                            <a href="#" class="text-primary text-decoration-none small fw-semibold">
                                <i class="fas fa-arrow-right me-1"></i>Leer más
                            </a>
                        </div>
                    </div>

                    <hr class="my-2 opacity-25">

                    <!-- Noticia 3 -->
                    <div class="news-item d-flex align-items-start">
                        <div class="position-relative me-3">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR690ND98zM-XCQM-jMKT1F5Szk17y8r5t65g&s" alt="Noticia 3" class="news-image" style="width: 90px; height: 90px; object-fit: cover;">
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-info me-2" style="font-size: 0.7rem;">Bancario</span>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>Hace 1d
                                </small>
                            </div>
                            <h4 class="fs-6 fw-semibold text-dark mb-2">Perú facilitará apertura de cuentas bancarias para extranjeros</h4>
                            <p class="text-muted small mb-2 text-truncate-2-lines">La SBS simplifica procesos de apertura de cuentas para ciudadanos extranjeros residentes en el país...</p>
                            <a href="#" class="text-primary text-decoration-none small fw-semibold">
                                <i class="fas fa-arrow-right me-1"></i>Leer más
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<script>
    // Animación suave al cargar
    document.addEventListener('DOMContentLoaded', function() {
        const fadeElements = document.querySelectorAll('.fade-in-up');
        fadeElements.forEach((element, index) => {
            element.style.animationDelay = `${index * 0.2}s`;
        });
    });

    // Efecto hover mejorado para las noticias
    document.querySelectorAll('.news-item').forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(8px)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });
</script>


 <!-- Fin del content -->

    </div>

 
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
                