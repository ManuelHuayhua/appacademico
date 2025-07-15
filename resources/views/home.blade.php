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
                        <a class="nav-link" href="" data-page="calificaciones">
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
              <!-- Content -->

          <style>

       
/* Variables de colores para consistencia */
:root {
    --primary-blue:#003bb1;
    --secondary-blue:#003bb1;
    --light-blue: #e0e7ff;
    --dark-blue:#003bb1;
    --white: #ffffff;
    --light-gray: #f8fafc;
    --medium-gray: #64748b;
    --dark-gray: #334155;
    --success: #10b981;
    --warning: #f59e0b;
}

/* Animaciones mejoradas */
@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(40px);
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

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes floatSoft {
    0%, 100% {
        transform: translateY(0px) scale(1);
    }
    50% {
        transform: translateY(-8px) scale(1.02);
    }
}

@keyframes pulse {
    0%, 100% {
        box-shadow: 0 0 0 0 rgba(79, 70, 229, 0.4);
    }
    50% {
        box-shadow: 0 0 0 10px rgba(79, 70, 229, 0);
    }
}

/* Contenedor principal adaptado */
.content-area {
    background: linear-gradient(135deg, var(--light-gray) 0%, #e2e8f0 100%);
    min-height: 100vh;
    padding: 2rem 1rem;
}

/* Header de bienvenida */
.welcome-header {
    text-align: center;
    margin-bottom: 2rem;
    animation: slideInUp 0.8s ease-out;
}

.welcome-header h1 {
    color: var(--primary-blue);
    font-size: 2.8rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    position: relative;
}

.welcome-header h1::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-blue), var(--secondary-blue));
    border-radius: 2px;
}

.welcome-header p {
    color: var(--medium-gray);
    font-size: 1.1rem;
    max-width: 600px;
    margin: 0 auto;
}

/* Tarjeta principal mejorada */
.hero-section {
    background: var(--white);
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(79, 70, 229, 0.1);
    overflow: hidden;
    margin-bottom: 3rem;
    border: 1px solid rgba(79, 70, 229, 0.1);
    animation: slideInUp 1s ease-out 0.2s both;
}

.hero-content {
    padding: 3rem 2rem;
    min-height: 450px;
    display: flex;
    align-items: center;
}

.hero-image-container {
    position: relative;
    animation: slideInLeft 1.2s ease-out 0.4s both;
}

.hero-image-container::before {
    content: '';
    position: absolute;
    top: -20px;
    left: -20px;
    right: -20px;
    bottom: -20px;
    background: linear-gradient(135deg, var(--light-blue), rgba(99, 102, 241, 0.1));
    border-radius: 20px;
    z-index: -1;
}

.student-image {
    width: 100%;
    max-width: 380px;
    height: auto;
    border-radius: 15px;
    animation: floatSoft 4s ease-in-out infinite;
    filter: drop-shadow(0 15px 35px rgba(79, 70, 229, 0.2));
    transition: all 0.3s ease;
}

.student-image:hover {
    transform: scale(1.05);
}

.hero-text {
    animation: slideInRight 1.2s ease-out 0.6s both;
    margin-left: 20px;
}

.hero-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: var(--dark-blue);
    margin-bottom: 1.5rem;
    line-height: 1.3;
}

.hero-subtitle {
    font-size: 1.1rem;
    color: var(--medium-gray);
    margin-bottom: 2.5rem;
    line-height: 1.7;
}

/* Badges mejorados */
.features-container {
    display: flex;
    flex-wrap: wrap;
    gap: 0.8rem;
}

.feature-badge {
    background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
    color: var(--white);
    padding: 0.8rem 1.5rem;
    border-radius: 30px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    transition: all 0.4s ease;
    box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
    position: relative;
    overflow: hidden;
}

.feature-badge::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.feature-badge:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 8px 25px rgba(68, 61, 190, 0.4);
    animation: pulse 2s infinite;
}

.feature-badge:hover::before {
    left: 100%;
}

/* Sección de noticias mejorada */
.news-section {
    animation: slideInUp 1.2s ease-out 0.8s both;
}

.news-title {
    color: var(--dark-blue);
    font-size: 2.2rem;
    font-weight: 700;
    text-align: center;
    margin-bottom: 3rem;
    position: relative;
}

.news-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 3px;
    background: var(--primary-blue);
    border-radius: 2px;
}

.news-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 2rem;
    max-width: 1400px;
    margin: 0 auto;
}

.news-card {
    background: var(--white);
    border-radius: 16px;
    padding: 2rem;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(79, 70, 229, 0.1);
    box-shadow: 0 4px 20px rgba(79, 70, 229, 0.08);
    position: relative;
    overflow: hidden;
    animation: slideInUp 0.8s ease-out both;
}

.news-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-blue), var(--secondary-blue));
}

.news-card:nth-child(1) { animation-delay: 1s; }
.news-card:nth-child(2) { animation-delay: 1.1s; }
.news-card:nth-child(3) { animation-delay: 1.2s; }
.news-card:nth-child(4) { animation-delay: 1.3s; }
.news-card:nth-child(5) { animation-delay: 1.4s; }

.news-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(79, 70, 229, 0.15);
    border-color: var(--primary-blue);
}

.news-date {
    color: var(--primary-blue);
    font-size: 0.9rem;
    font-weight: 600;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
}

.news-card-title {
    color: var(--dark-blue);
    font-weight: 700;
    margin-bottom: 1rem;
    font-size: 1.2rem;
    line-height: 1.4;
}

.news-excerpt {
    color: var(--medium-gray);
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.btn-news {
    background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
    border: none;
    color: var(--white);
    padding: 0.7rem 1.8rem;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    position: relative;
    overflow: hidden;
}

.btn-news::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.btn-news:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(79, 70, 229, 0.4);
    color: var(--white);
}

.btn-news:hover::before {
    left: 100%;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .hero-content {
        padding: 2.5rem 1.5rem;
    }
    
    .news-grid {
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }
}

@media (max-width: 768px) {
    .content-area {
        padding: 1rem 0.5rem;
    }
    
    .welcome-header h1 {
        font-size: 2.2rem;
    }
    
    .hero-content {
        flex-direction: column;
        text-align: center;
        padding: 2rem 1rem;
        min-height: auto;
    }
    
    .hero-title {
        font-size: 1.8rem;
        margin-bottom: 1rem;
        margin-top: 2rem;

    }
    
    .student-image {
        max-width: 280px;
        margin-bottom: 2rem;
    }
    
    .features-container {
        justify-content: center;
    }
    
    .feature-badge {
        padding: 0.6rem 1.2rem;
        font-size: 0.9rem;
    }
    
    .news-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .news-card {
        padding: 1.5rem;
    }
    
    .news-title {
        font-size: 1.8rem;
    }
}

@media (max-width: 480px) {
    .welcome-header h1 {
        font-size: 1.9rem;
        
    }
    
    .hero-title {
        font-size: 1.6rem;
    }
    
    .student-image {
        max-width: 240px;
    }
    
    .feature-badge {
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
    }
    
    .news-card {
        padding: 1.2rem;
    }
}
</style>


 <!-- Content -->
<div class="content-area">
    <div class="container-fluid">
        <!-- Header de Bienvenida -->
        <div class="welcome-header">
            <h1>¡Bienvenido al Portal Estudiantil!</h1>
            <p>Tu espacio digital para el crecimiento académico y profesional</p>
        </div>

        <!-- Hero Section -->
        <div class="hero-section">
            <div class="hero-content">
                <div class="row w-100 align-items-center">
                    <div class="col-lg-6 col-md-6">
                        <div class="hero-image-container text-center">
                            <img src="https://cdn3d.iconscout.com/3d/premium/thumb/estudiante-estudiando-en-una-computadora-portatil-mientras-esta-sentado-en-un-puf-5711047-4779535.png?f=webp"
                                 alt="Estudiante estudiando" class="student-image">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="hero-text">
                            <h2 class="hero-title">Explora un mundo de oportunidades</h2>
                            <p class="hero-subtitle">
                                Accede a todas las herramientas y recursos diseñados especialmente para 
                                potenciar tu aprendizaje y alcanzar tus metas académicas.
                            </p>
                            <div class="features-container">
                                <span class="feature-badge">
                                    <i class="fas fa-book me-2"></i>Cursos Activos
                                </span>
                                <span class="feature-badge">
                                    <i class="fas fa-calendar me-2"></i>Calendario
                                </span>
                                <span class="feature-badge">
                                    <i class="fas fa-chart-line me-2"></i>Mi Progreso
                                </span>
                                <span class="feature-badge">
                                    <i class="fas fa-graduation-cap me-2"></i>Certificaciones
                                </span>
                                <span class="feature-badge">
                                    <i class="fas fa-users me-2"></i>Comunidad
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- News Section -->
        <div class="news-section">
            <h2 class="news-title">
                <i class="fas fa-newspaper me-3"></i>Noticias y Anuncios
            </h2>
            
            <div class="news-grid">
                <div class="news-card">
                    <div class="news-date">
                        <i class="fas fa-calendar-alt me-2"></i>15 de Enero, 2024
                    </div>
                    <h5 class="news-card-title">Nueva Plataforma de Aprendizaje Virtual</h5>
                    <p class="news-excerpt">
                        Nos complace anunciar el lanzamiento de nuestra nueva plataforma de aprendizaje virtual con herramientas interactivas, 
                        videos en alta definición y sistema de evaluación en tiempo real para mejorar tu experiencia educativa.
                    </p>
                    <a href="#" class="btn-news">
                        Leer más <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>

                <div class="news-card">
                    <div class="news-date">
                        <i class="fas fa-calendar-alt me-2"></i>12 de Enero, 2024
                    </div>
                    <h5 class="news-card-title">Inscripciones Abiertas para Cursos de Verano</h5>
                    <p class="news-excerpt">
                        Ya están disponibles las inscripciones para los cursos intensivos de verano. Aprovecha esta oportunidad 
                        para adelantar materias o reforzar conocimientos en áreas específicas.
                    </p>
                    <a href="#" class="btn-news">
                        Ver cursos <i class="fas fa-external-link-alt ms-2"></i>
                    </a>
                </div>

                <div class="news-card">
                    <div class="news-date">
                        <i class="fas fa-calendar-alt me-2"></i>10 de Enero, 2024
                    </div>
                    <h5 class="news-card-title">Biblioteca Digital Ampliada</h5>
                    <p class="news-excerpt">
                        Hemos añadido más de 500 nuevos libros digitales y recursos académicos a nuestra biblioteca virtual. 
                        Accede desde cualquier dispositivo las 24 horas del día.
                    </p>
                    <a href="#" class="btn-news">
                        Explorar <i class="fas fa-book-open ms-2"></i>
                    </a>
                </div>

                <div class="news-card">
                    <div class="news-date">
                        <i class="fas fa-calendar-alt me-2"></i>8 de Enero, 2024
                    </div>
                    <h5 class="news-card-title">Nuevo Sistema de Calificaciones Online</h5>
                    <p class="news-excerpt">
                        Implementamos un nuevo sistema de consulta de calificaciones en tiempo real. Ahora podrás ver tus notas 
                        y comentarios de los profesores inmediatamente después de cada evaluación.
                    </p>
                    <a href="#" class="btn-news">
                        Ver notas <i class="fas fa-chart-bar ms-2"></i>
                    </a>
                </div>

                <div class="news-card">
                    <div class="news-date">
                        <i class="fas fa-calendar-alt me-2"></i>5 de Enero, 2024
                    </div>
                    <h5 class="news-card-title">Talleres de Habilidades Digitales</h5>
                    <p class="news-excerpt">
                        Se han programado talleres gratuitos para desarrollar habilidades digitales esenciales. Incluye cursos de 
                        Microsoft Office, herramientas de presentación y técnicas de investigación online.
                    </p>
                    <a href="#" class="btn-news">
                        Inscribirse <i class="fas fa-user-plus ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
    
    
   
               
            
   
        </div>
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
                