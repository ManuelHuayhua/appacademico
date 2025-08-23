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
                        <a class="nav-link " href="{{ route('alumno.cursos') }}"  data-page="cursos">
                            <i class="fas fa-book"></i>
                            <span class="nav-text">Cursos</span>
                            <div class="tooltip-custom">Cursos</div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('alumno.calificaciones.index') }}"  data-page="calificaciones">
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
                                <a class="dropdown-item" href="{{ route('alumno.perfil') }}">
                                    <i class="fas fa-user me-2"></i>Mi Perfil
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
             /* Estilos personalizados para un toque extra */
       :root {
        --primary-blue-start: #0249BB;
        --primary-blue-end: #003bb1;
        --primary-blue-light: #e3f2fd;
        --accent-green: #10b981;
        --accent-green-light: #d1fae5;
        --accent-red: #ef4444;
        --accent-red-light: #fee2e2;
        --accent-orange: #f59e0b;
        --accent-orange-light: #fef3c7;
        --text-dark: #1f2937;
        --text-medium: #4b5563;
        --text-muted: #6b7280;
        --text-light: #9ca3af;
        --bg-primary: #f8fafc;
        --bg-secondary: #f1f5f9;
        --card-bg: #ffffff;
        --border-light: #e2e8f0;
        --border-medium: #cbd5e1;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        --radius-sm: 0.375rem;
        --radius-md: 0.5rem;
        --radius-lg: 0.75rem;
        --radius-xl: 1rem;
    }
        .container {
        max-width: 1200px;
        padding: 0 1rem;
    }

    /* Título principal mejorado */
    .main-title {
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 800;
        color: var(--text-dark);
        text-align: center;
        margin-bottom: 3rem;
        position: relative;
        letter-spacing: -0.025em;
    }

    .main-title::after {
        content: '';
        position: absolute;
        bottom: -0.5rem;
        left: 50%;
        transform: translateX(-50%);
        width: 4rem;
        height: 0.25rem;
        background: linear-gradient(90deg, var(--primary-blue-start), var(--primary-blue-end));
        border-radius: 2px;
    }

    .main-title .fas {
        color: var(--primary-blue-start);
        margin-right: 0.75rem;
        font-size: 0.9em;
    }

    /* Formulario de período mejorado */
    .period-form {
        background: var(--card-bg);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-lg);
        padding: 2rem;
        margin-bottom: 3rem;
        border: 1px solid var(--border-light);
        position: relative;
        overflow: hidden;
    }

    .period-form::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-blue-start), var(--primary-blue-end));
    }

    .period-form-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1.5rem;
    }

    @media (min-width: 768px) {
        .period-form-content {
            flex-direction: row;
            justify-content: center;
        }
    }

    .period-form label {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-medium);
        display: flex;
        align-items: center;
        margin: 0;
        white-space: nowrap;
    }

    .period-form .form-select {
        border-radius: var(--radius-md);
        padding: 0.75rem 1rem;
        border: 2px solid var(--border-light);
        box-shadow: var(--shadow-sm);
        transition: all 0.2s ease;
        font-size: 0.95rem;
        font-weight: 500;
        min-width: 200px;
        background-color: var(--card-bg);
    }

    .period-form .form-select:focus {
        border-color: var(--primary-blue-end);
        box-shadow: 0 0 0 3px rgba(2, 73, 187, 0.1);
        outline: none;
    }

    /* Alerta informativa mejorada */
    .info-alert {
        background: linear-gradient(135deg, var(--primary-blue-light) 0%, #f0f9ff 100%);
        color: var(--primary-blue-end);
        border: 1px solid rgba(2, 73, 187, 0.2);
        border-left: 4px solid var(--primary-blue-start);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        padding: 2rem;
        margin-bottom: 3rem;
        position: relative;
        overflow: hidden;
    }

    .info-alert::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: radial-gradient(circle, rgba(2, 73, 187, 0.1) 0%, transparent 70%);
        transform: translate(30px, -30px);
    }

    .info-alert .alert-heading {
        color: var(--primary-blue-end);
        font-weight: 700;
        font-size: 1.25rem;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
    }

    .info-alert p {
        font-size: 1rem;
        margin: 0;
        font-weight: 500;
    }

    /* Grid responsivo mejorado */
    .grades-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }

    @media (max-width: 400px) {
        .grades-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
    }

    /* Tarjetas mejoradas */
    .grade-card {
        background: var(--card-bg);
        border-radius: var(--radius-xl);
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-light);
        position: relative;
        height: fit-content;
    }

    .grade-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-xl);
    }

    /* Header de tarjeta mejorado */
    .card-header-custom {
        background: linear-gradient(135deg, var(--primary-blue-start) 0%, var(--primary-blue-end) 100%);
        color: white;
        padding: 2rem 1.5rem;
        position: relative;
        overflow: hidden;
    }

    .card-header-custom::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml;utf8,<svg width="100%" height="100%" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="diagonal-stripe" patternUnits="userSpaceOnUse" width="8" height="8"><path d="M-2,2 l4,-4 M0,8 l8,-8 M6,10 l4,-4" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23diagonal-stripe)"/></svg>') repeat;
        opacity: 0.6;
    }

    .card-header-custom > * {
        position: relative;
        z-index: 1;
    }

    .card-title-course {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
        line-height: 1.3;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
    }

    .card-subtitle-details {
        font-size: 0.875rem;
        opacity: 0.9;
        line-height: 1.5;
        font-weight: 500;
    }

    .card-subtitle-details .fas {
        margin-right: 0.5rem;
        width: 1rem;
        text-align: center;
    }

    /* Sección de calificaciones mejorada */
    .grade-section {
        padding: 2rem 1.5rem;
        background: var(--card-bg);
    }

    .final-grade-display {
        background: linear-gradient(135deg, var(--primary-blue-light) 0%, #f8fafc 100%);
        border: 2px solid rgba(2, 73, 187, 0.1);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .final-grade-display::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary-blue-start), var(--primary-blue-end));
    }

    .final-grade-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--text-medium);
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .final-grade-value {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--primary-blue-start);
        line-height: 1;
        letter-spacing: -0.02em;
    }

    /* Botón de colapso mejorado */
    .btn-collapse-toggle {
        border-radius: var(--radius-md);
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border: 2px solid var(--primary-blue-end);
        color: var(--primary-blue-end);
        background: transparent;
        transition: all 0.2s ease;
        font-size: 0.875rem;
        width: 100%;
        position: relative;
        overflow: hidden;
    }

    .btn-collapse-toggle::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(2, 73, 187, 0.1), transparent);
        transition: left 0.5s ease;
    }

    .btn-collapse-toggle:hover {
        background: var(--primary-blue-end);
        color: white;
        box-shadow: var(--shadow-md);
        transform: translateY(-1px);
    }

    .btn-collapse-toggle:hover::before {
        left: 100%;
    }

    .btn-collapse-toggle .fas {
        transition: transform 0.3s ease;
        margin-left: 0.5rem;
    }

    .btn-collapse-toggle[aria-expanded="true"] .fas {
        transform: rotate(180deg);
    }

    /* Detalles de calificaciones mejorados */
    .grades-details {
        margin-top: 1.5rem;
    }

    .grade-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid var(--border-light);
        transition: background-color 0.2s ease;
    }

    .grade-item:hover {
        background-color: var(--bg-primary);
        margin: 0 -1rem;
        padding-left: 1rem;
        padding-right: 1rem;
        border-radius: var(--radius-sm);
    }

    .grade-item:last-of-type {
        border-bottom: none;
    }

    .grade-label {
        font-weight: 600;
        color: var(--text-medium);
        font-size: 0.875rem;
        flex: 1;
    }

    .grade-value {
        font-weight: 700;
        color: var(--text-dark);
        font-size: 1rem;
        text-align: right;
    }

    /* Lista de orales mejorada */
    .orales-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        justify-content: flex-end;
        max-width: 200px;
    }

    .orales-list span {
        background: linear-gradient(135deg, var(--bg-secondary) 0%, var(--bg-primary) 100%);
        padding: 0.25rem 0.75rem;
        border-radius: var(--radius-sm);
        font-weight: 600;
        font-size: 0.75rem;
        border: 1px solid var(--border-light);
        color: var(--text-dark);
        transition: all 0.2s ease;
    }

    .orales-list span:hover {
        transform: translateY(-1px);
        box-shadow: var(--shadow-sm);
    }

    /* Badges de estado mejorados */
    .status-badge {
        font-size: 0.75rem;
        padding: 0.5rem 1rem;
        border-radius: var(--radius-md);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        transition: all 0.2s ease;
    }

    .status-badge.bg-success {
        background: linear-gradient(135deg, var(--accent-green) 0%, #059669 100%) !important;
        color: white;
        box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);
    }

    .status-badge.bg-danger {
        background: linear-gradient(135deg, var(--accent-red) 0%, #dc2626 100%) !important;
        color: white;
        box-shadow: 0 2px 4px rgba(239, 68, 68, 0.3);
    }

    .status-badge:hover {
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    /* Botón de descarga mejorado */
    .btn-download {
        background: linear-gradient(135deg, var(--accent-green) 0%, #059669 100%);
        border: none;
        font-weight: 700;
        padding: 1rem 2rem;
        border-radius: var(--radius-md);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        font-size: 1rem;
        color: white;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-download::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .btn-download:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
        color: white;
    }

    .btn-download:hover::before {
        left: 100%;
    }

    .card-footer-custom {
        background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 100%);
        border-top: 1px solid var(--border-light);
        padding: 1.5rem;
    }

    /* Separador mejorado */
    .section-divider {
        border: none;
        height: 2px;
        background: linear-gradient(90deg, transparent, var(--border-medium), transparent);
        margin: 2rem 0;
    }

    /* Animaciones */
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

    .grade-card {
        animation: fadeInUp 0.6s ease forwards;
    }

    .grade-card:nth-child(2) { animation-delay: 0.1s; }
    .grade-card:nth-child(3) { animation-delay: 0.2s; }
    .grade-card:nth-child(4) { animation-delay: 0.3s; }

    /* Mejoras para dispositivos móviles */
    @media (max-width: 768px) {
        .container {
            padding: 0 0.75rem;
        }

        .main-title {
            font-size: 2rem;
            margin-bottom: 2rem;
        }

        .period-form {
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .grade-section {
            padding: 1.5rem 1rem;
        }

        .final-grade-display {
            padding: 1rem;
        }

        .final-grade-value {
            font-size: 2rem;
        }

        .orales-list {
            max-width: none;
            justify-content: flex-start;
        }

        .grade-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
            padding: 0.75rem 0;
        }

        .grade-value {
            text-align: left;
            font-size: 1.1rem;
        }
    }

    /* Estados de carga */
    .loading-shimmer {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
</style>
      <div class="container py-5">
    <h1 class="main-title">
        <i class="fas fa-graduation-cap"></i>
        Mis Calificaciones
    </h1>
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
@endif

@if(session('info'))
    <div class="alert alert-info alert-dismissible fade show mt-3" role="alert">
        <i class="fas fa-info-circle me-2"></i>
        {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
@endif

    {{-- Formulario para seleccionar el periodo --}}
    @if($periodos->isNotEmpty())
        <div class="period-form">
            <form method="GET" action="{{ route('alumno.calificaciones.index') }}" class="period-form-content">
                <label for="periodo_id" class="form-label">
                    <i class="fas fa-calendar-alt me-2"></i>
                    Selecciona el período:
                </label>
                <select name="periodo_id" id="periodo_id" class="form-select" onchange="this.form.submit()">
                    @foreach($periodos as $p)
                        <option value="{{ $p->id }}" {{ isset($periodoSeleccionado) && $periodoSeleccionado->id == $p->id ? 'selected' : '' }}>
                            {{ $p->nombre }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    @endif

    {{-- Mostrar mensaje si no hay calificaciones --}}
    @if($calificaciones->isEmpty())
        <div class="info-alert" role="alert">
            <h4 class="alert-heading">
                <i class="fas fa-info-circle me-2"></i>
                ¡Atención!
            </h4>
            <p>No tienes calificaciones registradas para este período. ¡Sigue esforzándote!</p>
        </div>
    @else
        {{-- Definir si se debe mostrar la columna del código --}}
        @php
            $mostrarCodigo = $calificaciones->contains(function ($cal) {
                return !empty($cal->codigo_certificado);
            });
        @endphp

        <div class="grades-grid">
            @foreach($calificaciones as $index => $cal)
                <div class="grade-card">
                    <div class="card-header-custom">
                        <h2 class="card-title-course">
                            <i class="fas fa-book-open"></i>
                            <span>{{ $cal->curso }}</span>
                        </h2>
                        <div class="card-subtitle-details">
                            <div class="mb-1">
                                <i class="fas fa-user-tie"></i>
                                {{ $cal->profesor ?? 'Sin asignar' }}
                            </div>
                            <div>
                                <i class="fas fa-building"></i>
                                Sección: {{ $cal->seccion }}
                            </div>
                        </div>
                    </div>

                    <div class="grade-section">
                        {{-- Promedio Final destacado --}}
                        <div class="final-grade-display">
                            <div class="final-grade-label">Promedio Final</div>
                            <div class="final-grade-value">{{ $cal->promedio_final ?? '-' }}</div>
                        </div>

                        {{-- Botón para mostrar detalles --}}
                        <button class="btn btn-collapse-toggle" type="button" 
                                data-bs-toggle="collapse" 
                                data-bs-target="#collapseGrades{{ $index }}" 
                                aria-expanded="false" 
                                aria-controls="collapseGrades{{ $index }}">
                            Ver Detalles Completos
                            <i class="fas fa-chevron-down"></i>
                        </button>

                        {{-- Detalles colapsables --}}
                        <div class="collapse grades-details" id="collapseGrades{{ $index }}">
                            <div class="grade-item">
                                <span class="grade-label">1er Avance</span>
                                <span class="grade-value">{{ $cal->primer_avance ?? '-' }}</span>
                            </div>
                            <div class="grade-item">
                                <span class="grade-label">2do Avance</span>
                                <span class="grade-value">{{ $cal->segundo_avance ?? '-' }}</span>
                            </div>
                            <div class="grade-item">
                                <span class="grade-label">Presentación Final</span>
                                <span class="grade-value">{{ $cal->presentacion_final ?? '-' }}</span>
                            </div>
                            <div class="grade-item">
                                <span class="grade-label">Promedio Avance</span>
                                <span class="grade-value">{{ $cal->promedio_avance ?? '-' }}</span>
                            </div>
                            <div class="grade-item">
                                <span class="grade-label">Evaluaciones Orales</span>
                                <div class="orales-list">
                                    <span>{{ $cal->oral_1 ?? '-' }}</span>
                                    <span>{{ $cal->oral_2 ?? '-' }}</span>
                                    <span>{{ $cal->oral_3 ?? '-' }}</span>
                                    <span>{{ $cal->oral_4 ?? '-' }}</span>
                                    <span>{{ $cal->oral_5 ?? '-' }}</span>
                                </div>
                            </div>
                            <div class="grade-item">
                                <span class="grade-label">Promedio Orales</span>
                                <span class="grade-value">
                                    @php
                                        $orales = collect([$cal->oral_1, $cal->oral_2, $cal->oral_3, $cal->oral_4, $cal->oral_5])->filter();
                                        $promOrales = $orales->isNotEmpty() ? number_format($orales->avg(), 2) : '-';
                                    @endphp
                                    {{ $promOrales }}
                                </span>
                            </div>
                            <div class="grade-item">
                                <span class="grade-label">Evaluación Permanente</span>
                                <span class="grade-value">{{ $cal->promedio_evaluacion_permanente ?? '-' }}</span>
                            </div>
                            <div class="grade-item">
                                <span class="grade-label">Examen Final</span>
                                <span class="grade-value">{{ $cal->examen_final ?? '-' }}</span>
                            </div>

                            <hr class="section-divider">

                            {{-- Información adicional --}}
                            @if($mostrarCodigo)
                                <div class="grade-item">
                                    <span class="grade-label">Código Certificado</span>
                                    <span class="grade-value">
                                        @if($cal->pago_realizado && $cal->califica_profesor)
                                            {{ $cal->codigo_certificado ?? '-' }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>
                            @endif

                            <div class="grade-item">
                                <span class="grade-label">Pago Completo</span>
                                <span class="status-badge {{ $cal->pago_realizado ? 'bg-success' : 'bg-danger' }}">
                                    <i class="fas {{ $cal->pago_realizado ? 'fa-check' : 'fa-times' }}"></i>
                                    {{ $cal->pago_realizado ? 'Completado' : 'Pendiente' }}
                                </span>
                            </div>

                            <div class="grade-item">
            <span class="grade-label">Calificación del Profesor</span>
            <span class="status-badge {{ $cal->califica_profesor ? 'bg-success' : 'bg-danger' }}">
                <i class="fas {{ $cal->califica_profesor ? 'fa-check' : 'fa-times' }}"></i>
                {{ $cal->califica_profesor ? 'Completada' : 'Pendiente' }}
            </span>
       

    
  @if (!$cal->califica_profesor)
            <button type="button" class="btn btn-sm btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#modalCalificar{{ $cal->id }}">
                Calificar profesor
            </button>
        @endif

   

                            </div>
                        </div>
                    </div>

                    @if ($cal->codigo_certificado)
                        <div class="card-footer-custom">
                            <a href="{{ route('certificados.mostrar', ['codigo' => $cal->codigo_certificado]) }}" class="btn btn-download w-100">
                                <i class="fas fa-file-download me-2"></i>
                                Descargar Certificado
                            </a>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>


<!-- Modales fuera del contenido de tarjetas -->

<style>
.modal-content {
    border-radius: 1.5rem;
    border: none;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 1.5rem 1.5rem 0 0;
    padding: 1.5rem 2rem;
}

.modal-body {
    padding: 2.5rem;
    background: #f8f9fa;
}

.modal-footer {
    padding: 1.5rem 2.5rem;
    background: #f8f9fa;
    border-radius: 0 0 1.5rem 1.5rem;
    border-top: 1px solid rgba(0,0,0,0.1);
}

.question-card {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(102, 126, 234, 0.1);
    transition: all 0.3s ease;
}

.question-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
}

.question-title {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 1rem;
    font-size: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.star-rating {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 0.5rem;
}

.star {
    font-size: 2rem;
    color: #e9ecef;
    cursor: pointer;
    transition: all 0.2s ease;
    user-select: none;
}

.star:hover {
    transform: scale(1.1);
}

.star.active {
    color: #ffc107;
    text-shadow: 0 0 10px rgba(255, 193, 7, 0.5);
}

.star.hover {
    color: #ffb84d;
}

.comment-section {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(102, 126, 234, 0.1);
}

.form-control {
    border-radius: 0.5rem;
    border: 2px solid #e9ecef;
    transition: border-color 0.3s ease;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.btn-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border: none;
    border-radius: 0.75rem;
    padding: 0.75rem 2rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
}

.btn-secondary {
    border-radius: 0.75rem;
    padding: 0.75rem 2rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    transform: translateY(-2px);
}

.rating-labels {
    display: flex;
    justify-content: space-between;
    font-size: 0.75rem;
    color: #6c757d;
    margin-top: 0.5rem;
}

/* Ocultar etiquetas en pantallas pequeñas */
@media (max-width: 768px) {
    .rating-labels {
        display: none;
    }
    
    .star {
        font-size: 1.8rem;
    }
    
    .star-rating {
        gap: 0.3rem;
    }
    
    .question-card {
        padding: 1rem;
        margin-bottom: 1rem;
    }
    
    .modal-body {
        padding: 1.5rem;
    }
    
    .modal-footer {
        padding: 1rem 1.5rem;
    }
    
    .modal-header {
        padding: 1rem 1.5rem;
    }
    
    .professor-info {
        padding: 0.75rem;
        margin-bottom: 1rem;
    }
    
    .rating-summary {
        padding: 0.75rem;
        margin-bottom: 1.5rem;
    }
    
    .comment-section {
        padding: 1rem;
    }
}

.question-icon {
    width: 20px;
    text-align: center;
}

.modal-title {
    font-size: 1.5rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.professor-info {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 0.75rem;
    padding: 1rem;
    margin-bottom: 1.5rem;
    backdrop-filter: blur(10px);
}

.rating-summary {
    text-align: center;
    padding: 1rem;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 1rem;
    color: white;
    margin-bottom: 2rem;
}
</style>

@foreach ($calificaciones as $cal)
    @if (!$cal->califica_profesor)
    <div class="modal fade" id="modalCalificar{{ $cal->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $cal->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <form action="{{ route('alumno.calificar-profesor', ['id' => $cal->id]) }}" method="POST" id="calificacionForm{{ $cal->id }}">
                    @csrf
                    <div class="modal-header text-white">
                        <div>
                            <h5 class="modal-title" id="modalLabel{{ $cal->id }}">
                                <i class="fas fa-star"></i>
                                Evaluar Desempeño Docente
                            </h5>
                           
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    
                    <div class="modal-body">
                        <div class="rating-summary">
                            <h6 class="mb-2"><i class="fas fa-info-circle me-2"></i>Evalúa cada aspecto del 1 al 5</h6>
                            <small>Tu opinión es valiosa para mejorar la calidad educativa</small>
                        </div>

                        <!-- Pregunta 1: Dominio del tema -->
                        <div class="question-card">
                            <div class="question-title">
                                <i class="fas fa-graduation-cap question-icon"></i>
                                ¿Qué tan bien domina el profesor la materia que enseña?
                            </div>
                            <div class="star-rating" data-question="1" data-modal="{{ $cal->id }}">
                                <span class="star" data-value="1">★</span>
                                <span class="star" data-value="2">★</span>
                                <span class="star" data-value="3">★</span>
                                <span class="star" data-value="4">★</span>
                                <span class="star" data-value="5">★</span>
                            </div>
                            <div class="rating-labels">
                                <span>Deficiente</span>
                                <span>Regular</span>
                                <span>Bueno</span>
                                <span>Muy Bueno</span>
                                <span>Excelente</span>
                            </div>
                            <input type="hidden" name="pregunta_1" id="pregunta_1_{{ $cal->id }}" required>
                        </div>

                        <!-- Pregunta 2: Claridad en explicaciones -->
                        <div class="question-card">
                            <div class="question-title">
                                <i class="fas fa-comments question-icon"></i>
                                ¿Qué tan claras y comprensibles son sus explicaciones?
                            </div>
                            <div class="star-rating" data-question="2" data-modal="{{ $cal->id }}">
                                <span class="star" data-value="1">★</span>
                                <span class="star" data-value="2">★</span>
                                <span class="star" data-value="3">★</span>
                                <span class="star" data-value="4">★</span>
                                <span class="star" data-value="5">★</span>
                            </div>
                            <div class="rating-labels">
                                <span>Muy confuso</span>
                                <span>Confuso</span>
                                <span>Aceptable</span>
                                <span>Claro</span>
                                <span>Muy claro</span>
                            </div>
                            <input type="hidden" name="pregunta_2" id="pregunta_2_{{ $cal->id }}" required>
                        </div>

                        <!-- Pregunta 3: Metodología de enseñanza -->
                        <div class="question-card">
                            <div class="question-title">
                                <i class="fas fa-chalkboard-teacher question-icon"></i>
                                ¿Cómo evalúas su metodología y técnicas de enseñanza?
                            </div>
                            <div class="star-rating" data-question="3" data-modal="{{ $cal->id }}">
                                <span class="star" data-value="1">★</span>
                                <span class="star" data-value="2">★</span>
                                <span class="star" data-value="3">★</span>
                                <span class="star" data-value="4">★</span>
                                <span class="star" data-value="5">★</span>
                            </div>
                            <div class="rating-labels">
                                <span>Inadecuada</span>
                                <span>Poco efectiva</span>
                                <span>Aceptable</span>
                                <span>Efectiva</span>
                                <span>Excelente</span>
                            </div>
                            <input type="hidden" name="pregunta_3" id="pregunta_3_{{ $cal->id }}" required>
                        </div>

                        <!-- Pregunta 4: Disponibilidad y atención -->
                        <div class="question-card">
                            <div class="question-title">
                                <i class="fas fa-handshake question-icon"></i>
                                ¿Qué tan disponible está para resolver dudas y brindar apoyo?
                            </div>
                            <div class="star-rating" data-question="4" data-modal="{{ $cal->id }}">
                                <span class="star" data-value="1">★</span>
                                <span class="star" data-value="2">★</span>
                                <span class="star" data-value="3">★</span>
                                <span class="star" data-value="4">★</span>
                                <span class="star" data-value="5">★</span>
                            </div>
                            <div class="rating-labels">
                                <span>Nunca disponible</span>
                                <span>Poco disponible</span>
                                <span>Moderadamente</span>
                                <span>Muy disponible</span>
                                <span>Siempre disponible</span>
                            </div>
                            <input type="hidden" name="pregunta_4" id="pregunta_4_{{ $cal->id }}" required>
                        </div>

                        <!-- Pregunta 5: Evaluación general -->
                        <div class="question-card">
                            <div class="question-title">
                                <i class="fas fa-trophy question-icon"></i>
                                ¿Cuál es tu evaluación general del profesor?
                            </div>
                            <div class="star-rating" data-question="5" data-modal="{{ $cal->id }}">
                                <span class="star" data-value="1">★</span>
                                <span class="star" data-value="2">★</span>
                                <span class="star" data-value="3">★</span>
                                <span class="star" data-value="4">★</span>
                                <span class="star" data-value="5">★</span>
                            </div>
                            <div class="rating-labels">
                                <span>Muy malo</span>
                                <span>Malo</span>
                                <span>Regular</span>
                                <span>Bueno</span>
                                <span>Excelente</span>
                            </div>
                            <input type="hidden" name="pregunta_5" id="pregunta_5_{{ $cal->id }}" required>
                        </div>

                        <!-- Sección de comentarios -->
                        <div class="comment-section">
                            <label class="form-label fw-semibold mb-3">
                                <i class="fas fa-comment-dots me-2"></i>
                                Comentarios adicionales (opcional)
                            </label>
                            <textarea 
                                name="comentario" 
                                class="form-control" 
                                rows="4" 
                                placeholder="Comparte cualquier comentario adicional que consideres importante para ayudar al profesor a mejorar..."
                            ></textarea>
                        </div>
                    </div>
                    
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-success" id="submitBtn{{ $cal->id }}" disabled>
                            <i class="fas fa-paper-plane me-2"></i>Enviar Evaluación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@endforeach

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modals = document.querySelectorAll('.modal');
    
    modals.forEach(modal => {
        const modalId = modal.id.replace('modalCalificar', '');
        const starRatings = modal.querySelectorAll('.star-rating');
        const submitBtn = modal.querySelector(`#submitBtn${modalId}`);
        let ratings = {};

        starRatings.forEach(rating => {
            const questionNum = rating.dataset.question;
            const stars = rating.querySelectorAll('.star');
            const hiddenInput = modal.querySelector(`#pregunta_${questionNum}_${modalId}`);

            stars.forEach((star, index) => {
                star.addEventListener('mouseenter', function() {
                    highlightStars(stars, index + 1, 'hover');
                });

                star.addEventListener('mouseleave', function() {
                    removeHoverStars(stars);
                    if (ratings[questionNum]) {
                        highlightStars(stars, ratings[questionNum], 'active');
                    }
                });

                star.addEventListener('click', function() {
                    const value = parseInt(star.dataset.value);
                    ratings[questionNum] = value;
                    hiddenInput.value = value;
                    
                    removeAllStars(stars);
                    highlightStars(stars, value, 'active');
                    
                    // Verificar si todas las preguntas están respondidas
                    checkAllQuestionsAnswered();
                });
            });
        });

        function highlightStars(stars, count, className) {
            for (let i = 0; i < count; i++) {
                stars[i].classList.add(className);
            }
        }

        function removeHoverStars(stars) {
            stars.forEach(star => star.classList.remove('hover'));
        }

        function removeAllStars(stars) {
            stars.forEach(star => {
                star.classList.remove('active', 'hover');
            });
        }

        function checkAllQuestionsAnswered() {
            const requiredQuestions = 5;
            const answeredQuestions = Object.keys(ratings).length;
            
            if (answeredQuestions === requiredQuestions) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Enviar Evaluación';
            } else {
                submitBtn.disabled = true;
                submitBtn.innerHTML = `<i class="fas fa-paper-plane me-2"></i>Responde todas las preguntas (${answeredQuestions}/${requiredQuestions})`;
            }
        }

        // Reset form when modal is closed
        modal.addEventListener('hidden.bs.modal', function() {
            ratings = {};
            starRatings.forEach(rating => {
                const stars = rating.querySelectorAll('.star');
                removeAllStars(stars);
            });
            
            // Reset hidden inputs
            for (let i = 1; i <= 5; i++) {
                const input = modal.querySelector(`#pregunta_${i}_${modalId}`);
                if (input) input.value = '';
            }
            
            // Reset textarea
            const textarea = modal.querySelector('textarea[name="comentario"]');
            if (textarea) textarea.value = '';
            
            checkAllQuestionsAnswered();
        });
    });
});
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

