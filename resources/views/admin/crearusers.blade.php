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
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
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
            flex-shrink: 0;
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
            content: '\f19c'; /* Icono de Font Awesome para un libro o similar */
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
            flex-grow: 1;
        }
        .nav-item {
            margin-bottom: 5px;
            --bs-nav-link-hover-color: #ffffffff !important;
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
            flex-grow: 1;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        .sidebar-collapsed .nav-text {
            opacity: 0;
            width: 0;
            margin: 0;
            white-space: nowrap;
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

        /* MODIFICACIONES PARA TOP-NAVBAR FIJA */
        .top-navbar {
            position: fixed; /* Hace la barra fija a la ventana */
            top: 0; /* La ancla a la parte superior */
            left: 70px; /* Posición inicial para sidebar colapsado */
            width: calc(100% - 70px); /* Ancho inicial para sidebar colapsado */
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 20px;
            z-index: 990; /* Asegura que esté por encima del contenido, pero debajo del sidebar */
            transition: all 0.3s ease; /* Transición suave para cambios de tamaño/posición */
        }

        /* Main Content */
        .main-content {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin-left: 70px; /* Margen inicial para sidebar colapsado */
            padding-top: 65px; /* Espacio para la barra de navegación fija (aprox. altura de top-navbar) */
            width: calc(100% - 70px); /* Ancho inicial para sidebar colapsado */
            transition: all 0.3s ease;
            overflow-x: hidden;
        }

        /* Ajustes cuando el sidebar está expandido */
        .sidebar-expanded ~ .top-navbar {
            left: 250px;
            width: calc(100% - 250px);
        }
        .sidebar-expanded ~ .main-content {
            margin-left: 250px;
            width: calc(100% - 250px);
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
            z-index: 9999 !important;
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
        .sidebar-collapsed .nav-link:hover .tooltip-custom,
        .sidebar-collapsed .nav-group-toggle:hover .tooltip-custom {
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
            z-index: 9999 !important;
        }
        .dropdown-menu {
            position: fixed !important;
            z-index: 99999 !important;
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
            right: 20px !important;
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
            flex-shrink: 0;
        }
        .sidebar-collapsed .expand-indicator {
            opacity: 1;
        }
        /* --- ESTILOS MEJORADOS PARA SUBMENÚS COLAPSABLES --- */
        .nav-group-toggle {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }
        /* NUEVO: Estilo para el toggle de grupo cuando está expandido */
        .nav-group-toggle[aria-expanded="true"] {
            background-color: rgba(255,255,255,0.1);
            color: white;
            font-weight: 500;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .nav-group-icon {
            transition: transform 0.3s ease;
            margin-left: auto;
        }
        .nav-group-toggle[aria-expanded="true"] .nav-group-icon {
            transform: rotate(180deg);
        }
        .nav-submenu {
            padding-left: 20px;
        }
        .nav-submenu-level-2 {
            padding-left: 15px;
        }
        /* Ajustes para sidebar colapsado (modo icono) */
        .sidebar-collapsed .nav-group-toggle {
            justify-content: center;
            padding: 15px 10px;
            margin-right: 5px;
        }
        .sidebar-collapsed .nav-group-toggle .nav-text {
            opacity: 0;
            width: 0;
            margin: 0;
            white-space: nowrap;
        }
        .sidebar-collapsed .nav-group-toggle .nav-group-icon {
            opacity: 0;
            width: 0;
            margin: 0;
        }
        /* Asegura que los iconos de los toggles de grupo sean visibles en modo colapsado */
        .sidebar-collapsed .nav-group-toggle i:first-child {
            margin-right: 0;
            font-size: 20px;
        }
        /* --- FIN ESTILOS MEJORADOS --- */
        /* Responsive */
        @media (max-width: 768px) {
            .app-container {
                position: relative;
            }
            .dropdown-toggle {
                z-index: 999 !important;
            }
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                width: 280px !important;
                flex: none !important;
                transform: translateX(-100%);
                z-index: 1001;
                height: 100vh;
                overflow-y: auto;
            }
            /* MODIFICACIONES PARA TOP-NAVBAR FIJA EN MÓVIL */
            .top-navbar {
                left: 0 !important; /* Asegura que esté a la izquierda */
                width: 100% !important; /* Ocupa todo el ancho */
                /* position: fixed; y top: 0; ya están definidos arriba */
            }
            .main-content {
                margin-left: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                overflow-x: hidden !important;
                /* padding-top ya está definido arriba */
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
                white-space: normal !important;
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
                z-index: 999 !important;
                right: 10px !important;
                left: auto !important;
                top: 60px !important;
                min-width: 200px;
            }
            .dropdown-menu.show {
                z-index: 999 !important;
            }
            /* Cuando el sidebar está abierto en móvil, ocultar el dropdown */
            .sidebar.mobile-open ~ .main-content .dropdown-menu.show {
                display: none !important;
            }
            .user-info {
                z-index: 999 !important;
            }
            .dropdown {
                z-index: 999 !important;
            }
            /* Mobile adjustments for group toggles */
            .sidebar .nav-group-toggle {
                justify-content: flex-start !important;
                padding: 15px 20px !important;
                margin-right: 10px !important;
            }
            .sidebar .nav-group-toggle .nav-text {
                opacity: 1 !important;
                width: auto !important;
                margin: 0 !important;
            }
            .sidebar .nav-group-toggle .nav-group-icon {
                opacity: 1 !important;
                width: auto !important;
                margin-left: auto !important;
                margin-right: 0 !important;
            }
            .sidebar .nav-group-toggle i:first-child {
                margin-right: 15px !important;
                font-size: 18px !important;
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
                <h4>Portal Admin</h4>
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
                    <li class="nav-item nav-group">
                        <a class="nav-link active nav-group-toggle" href="#usuariosSubmenu" data-bs-toggle="collapse" aria-expanded="false" aria-controls="usuariosSubmenu">
                            <i class="fas fa-users-cog"></i>
                            <span class="nav-text">Gestión de Usuarios</span>
                            <i class="fas fa-chevron-down nav-group-icon"></i>
                            <div class="tooltip-custom">Gestión de Usuarios</div>
                        </a>
                        <div class="collapse" id="usuariosSubmenu">
                            <ul class="nav flex-column nav-submenu">
                                <li class="nav-item">
                                    <a class="nav-link active" href="{{ route('admin.usuarios.create') }}">
                                        <i class="fas fa-user"></i> <span class="nav-text">Usuarios y Roles</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!-- Nuevo Grupo Colapsable: Administración -->
                    <li class="nav-item nav-group">
                        <a class="nav-link nav-group-toggle" href="#academicaSubmenu" data-bs-toggle="collapse" aria-expanded="false" aria-controls="academicaSubmenu">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <span class="nav-text">Gestión Académica</span>
                            <i class="fas fa-chevron-down nav-group-icon"></i>
                            <div class="tooltip-custom">Gestión Académica</div>
                        </a>
                        <div class="collapse" id="academicaSubmenu">
                            <ul class="nav flex-column nav-submenu">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.cursos.create') }}">
                                        <i class="fas fa-book"></i> <span class="nav-text">Crear y asignar curso</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.matricula.create') }}">
                                        <i class="fas fa-user-graduate"></i> <span class="nav-text">Matricular alumnos</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('curso_silabo.index') }}">
                                        <i class="fas fa-file-upload"></i> <span class="nav-text">Subir sílabo</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.periodos.index') }}">
                                        <i class="fas fa-calendar-alt"></i> <span class="nav-text">Periodo académico</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.calificado_profesor.index') }}">
                                        <i class="fas fa-star"></i> <span class="nav-text">Calificación del profesor</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item nav-group">
                        <a class="nav-link nav-group-toggle" href="#notasSubmenu" data-bs-toggle="collapse" aria-expanded="false" aria-controls="notasSubmenu">
                            <i class="fas fa-file-alt"></i>
                            <span class="nav-text">Notas y Evaluaciones</span>
                            <i class="fas fa-chevron-down nav-group-icon"></i>
                            <div class="tooltip-custom">Notas y Evaluaciones</div>
                        </a>
                        <div class="collapse" id="notasSubmenu">
                            <ul class="nav flex-column nav-submenu">
                                <li class="nav-item">
                <a class="nav-link " href="{{ route('admin.calificaciones.index') }}">
                    <i class="fas fa-pencil-alt"></i> <!-- Icono para calificar -->
                    <span class="nav-text">Reporte Calificaciones</span>
                </a>
            </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.notas_y_asistencias') }}">
                                        <i class="fas fa-clipboard-list"></i>
                                        <span class="nav-text">Ver notas y asistencias</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.librerarnotas.index') }}">
                                        <i class="fas fa-unlock"></i>
                                        <span class="nav-text">Liberar notas</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!-- Menú: Comunicación -->
                    <li class="nav-item nav-group">
                        <a class="nav-link nav-group-toggle" href="#comunicacionSubmenu" data-bs-toggle="collapse" aria-expanded="false" aria-controls="comunicacionSubmenu">
                            <i class="fas fa-comments"></i>
                            <span class="nav-text">Comunicación</span>
                            <i class="fas fa-chevron-down nav-group-icon"></i>
                            <div class="tooltip-custom">Comunicación</div>
                        </a>
                        <div class="collapse" id="comunicacionSubmenu">
                            <ul class="nav flex-column nav-submenu">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.mensajes.crear') }}">
                                        <i class="fas fa-envelope"></i>
                                        <span class="nav-text">Enviar mensajes</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.clasesurl.index') }}">
                                        <i class="fas fa-video"></i>
                                        <span class="nav-text">Ingresar links de clases virtuales</span>
                                    </a>
                                </li>
                                  <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.materiales') }}">
                    <i class="fas fa-folder-open"></i>
                    <span class="nav-text">Materiales y Clases Grabadas</span>
                </a>
            </li>
                            </ul>
                        </div>
                    </li>
                    <!-- Menú: Pagos -->
                    <li class="nav-item nav-group">
                        <a class="nav-link nav-group-toggle" href="#pagosSubmenu" data-bs-toggle="collapse" aria-expanded="false" aria-controls="pagosSubmenu">
                            <i class="fas fa-money-bill-wave"></i>
                            <span class="nav-text">Pagos</span>
                            <i class="fas fa-chevron-down nav-group-icon"></i>
                            <div class="tooltip-custom">Pagos</div>
                        </a>
                        <div class="collapse" id="pagosSubmenu">
                            <ul class="nav flex-column nav-submenu">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.pagos') }}">
                                        <i class="fas fa-receipt"></i>
                                        <span class="nav-text">Gestión de pagos</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                      <li class="nav-item">
    <a class="nav-link " href="#" data-page="general">
        <i class="fas fa-folder-open"></i>
        <span class="nav-text">Tramite Documentario</span>
        <div class="tooltip-custom">Tramite Documentario</div>
    </a>
</li>
<!-- Menú: Control Académico -->
<li class="nav-item nav-group">
    <a class="nav-link nav-group-toggle" href="#controlAcademicoSubmenu" data-bs-toggle="collapse" aria-expanded="false" aria-controls="controlAcademicoSubmenu">
        <i class="fas fa-user-check"></i>
        <span class="nav-text">Control Académico</span>
        <i class="fas fa-chevron-down nav-group-icon"></i>
        <div class="tooltip-custom">Control Académico</div>
    </a>
    <div class="collapse" id="controlAcademicoSubmenu">
        <ul class="nav flex-column nav-submenu">
            <li class="nav-item">
                 <a class="nav-link" href="{{ route('admin.verprofesor') }}">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span class="nav-text">Asistencia del Profesor</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('retirados.index') }}">
                    <i class="fas fa-user-times"></i>
                    <span class="nav-text">Alumnos Retirados / Faltas</span>
                </a>
            </li>
        </ul>
    </div>
</li>
                </ul>
            </nav>
            <div class="expand-indicator">
                <i class="fas fa-chevron-right"></i>
            </div>
        </div>

        <!-- Top Navbar (AHORA FUERA DE main-content y FIXED) -->
        <nav class="top-navbar" id="topNavbar">
            <div class="d-flex align-items-center w-100">
                <button class="toggle-btn" id="sidebarToggle" title="Toggle Sidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="user-info">
                    <div class="user-avatar">
                        A
                    </div>
                    <div class="dropdown">
                        <a id="navbarDropdown" class="dropdown-toggle text-decoration-none text-dark" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Bienvenido, {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            
                            <div class="dropdown-divider"></div>
                            <a href="javascript:void(0);" class="dropdown-item"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-content" id="mainContent">
            <!-- Content -->
            <div class="content-area">

        <style>
        .user-conteiner {
            background: #ffffff;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }
        
        .container-fluid {
            padding: 1rem;
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .card {
            border: 1px solid #e2e6ea;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(2, 73, 187, 0.08);
            background: #ffffff;
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            background: linear-gradient(120deg, #0249BB 0%, #003bb1 100%);
            color: white;
            border-radius: 12px 12px 0 0 !important;
            padding: 1rem 1.25rem;
            border: none;
        }
        
        .card-header h3 {
            margin: 0;
            font-weight: 600;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .form-group {
            margin-bottom: 1rem;
        }
        
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.4rem;
            font-size: 0.9rem;
        }
        
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #d1d5db;
            padding: 0.5rem 0.75rem;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            height: auto;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #0249BB;
            box-shadow: 0 0 0 0.15rem rgba(2, 73, 187, 0.2);
        }
        
        .btn-primary {
            background: linear-gradient(120deg, #0249BB 0%, #003bb1 100%);
            border: none;
            border-radius: 8px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(2, 73, 187, 0.3);
            background: linear-gradient(120deg, #003bb1 0%, #002a8a 100%);
        }
        
        .btn-success {
            background: linear-gradient(120deg, #28a745 0%, #20923a 100%);
            border: none;
            border-radius: 6px;
            font-size: 0.8rem;
            padding: 0.4rem 0.8rem;
        }
        
        .btn-warning {
            background: linear-gradient(120deg, #ffc107 0%, #e0a800 100%);
            border: none;
            border-radius: 6px;
            font-size: 0.8rem;
            padding: 0.4rem 0.8rem;
            color: #333;
        }
        
        .btn-danger {
            background: linear-gradient(120deg, #dc3545 0%, #c82333 100%);
            border: none;
            border-radius: 6px;
            font-size: 0.8rem;
            padding: 0.4rem 0.8rem;
        }
        
        .btn-secondary {
            background: linear-gradient(120deg, #6c757d 0%, #5a6268 100%);
            border: none;
            border-radius: 6px;
            font-size: 0.8rem;
            padding: 0.4rem 0.8rem;
        }
        
        .table {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            font-size: 0.9rem;
        }
        
        .table thead th {
            background: linear-gradient(120deg, #0249BB 0%, #003bb1 100%);
            color: white;
            border: none;
            font-weight: 600;
            padding: 0.75rem;
            font-size: 0.85rem;
        }
        
        .table tbody tr {
            transition: all 0.2s ease;
        }
        
        .table tbody tr:hover {
            background-color: rgba(2, 73, 187, 0.03);
        }
        
        .table tbody td {
            padding: 0.75rem;
            vertical-align: middle;
            border-color: #e9ecef;
        }
        
        .radio-group {
            display: flex;
            gap: 1.5rem;
            margin-top: 0.3rem;
        }
        
        .radio-item {
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
        
        .radio-item input[type="radio"] {
            transform: scale(1.1);
        }
        
        .radio-item label {
            font-size: 0.9rem;
            margin-bottom: 0;
        }
        
        .badge {
            padding: 0.35rem 0.8rem;
            border-radius: 15px;
            font-size: 0.75rem;
            margin-right: 0.2rem;
            font-weight: 500;
        }
        
        .badge-admin {
            background: linear-gradient(120deg, #dc3545 0%, #c82333 100%);
            color: white;
        }
        
        .badge-profesor {
            background: linear-gradient(120deg, #0249BB 0%, #003bb1 100%);
            color: white;
        }
        
        .badge-alumno {
            background: linear-gradient(120deg, #28a745 0%, #20923a 100%);
            color: white;
        }
        
        .filter-section {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            border: 1px solid #e9ecef;
        }
        
        .search-box {
            position: relative;
        }
        
        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .search-box input {
            padding-left: 35px;
        }
        
        .alert {
            border-radius: 8px;
            border: none;
            margin-bottom: 1rem;
            padding: 0.75rem 1rem;
        }
        
        .alert-success {
            background: linear-gradient(120deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            border-left: 4px solid #28a745;
        }
        
        .alert-danger {
            background: linear-gradient(120deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
            border-left: 4px solid #dc3545;
        }
        
        .btn-group .btn {
            margin-right: 0.25rem;
            margin-bottom: 0.25rem;
        }
        
        .modal-header {
            border-bottom: 1px solid #dee2e6;
        }
        
        .modal-footer {
            border-top: 1px solid #dee2e6;
        }
        
        @media (max-width: 768px) {
            .container-fluid {
                padding: 0.5rem;
            }
            
            .radio-group {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .btn-group {
                display: flex;
                flex-direction: column;
                align-items: stretch;
            }
            
            .btn-group .btn {
                margin-right: 0;
                margin-bottom: 0.25rem;
            }
            
            .card-header {
                flex-direction: column;
                gap: 0.5rem;
                text-align: center;
            }
            
            .card-header .btn {
                align-self: center;
            }
            
            .filter-section .row {
                gap: 0.5rem;
            }
            
            .filter-section .col-md-3,
            .filter-section .col-md-4,
            .filter-section .col-md-2 {
                margin-bottom: 0.5rem;
            }
            
            .table-responsive {
                font-size: 0.8rem;
            }
            
            .badge {
                font-size: 0.7rem;
                padding: 0.25rem 0.5rem;
            }
        }
        
        @media (max-width: 576px) {
            .d-flex.justify-content-between {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .d-flex.justify-content-between .btn {
                width: 100%;
            }
        }
        
        .btn-light {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(2, 73, 187, 0.2);
            color: #0249BB;
            font-weight: 600;
        }
        
        .btn-light:hover {
            background: rgba(2, 73, 187, 0.1);
            border-color: #0249BB;
            color: #003bb1;
        }
    </style>

<section class="user-conteiner">
    <div class="container-fluid">
        <!-- Mostrar mensaje de éxito -->
        @if (session('success'))
            <div class="alert alert-success d-flex align-items-center">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        <!-- Mostrar errores de validación -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Por favor corrige los siguientes errores:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulario de creación de usuario -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3><i class="fas fa-user-plus"></i> Crear nuevo usuario</h3>
              
                <button type="button" class="btn btn-light btn-sm" onclick="toggleCreateForm()" id="toggleBtn">
                    <i class="fas fa-plus me-1"></i>Crear
                </button>
            </div>
            <div class="card-body" id="createForm" style="display: none;">
                <form action="{{ route('admin.usuarios.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Nombre:</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Apellido paterno:</label>
                                <input type="text" name="apellido_p" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Apellido materno:</label>
                                <input type="text" name="apellido_m" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label class="form-label">DNI:</label>
                                <input type="text" name="dni" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Email:</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Teléfono:</label>
                                <input type="text" name="telefono" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Fecha de nacimiento:</label>
                                <input type="date" name="fecha_nacimiento" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <label class="form-label">Género:</label>
                                <select name="genero" class="form-select" required>
                                    <option value="masculino">Masculino</option>
                                    <option value="femenino">Femenino</option>
                                    <option value="otro">Otro</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div class="form-group">
                                <label class="form-label">Tipo de usuario:</label>
                                <div class="radio-group">
                                    <div class="radio-item">
                                        <input type="radio" name="tipo_usuario" value="admin" id="admin" required>
                                        <label for="admin">Admin</label>
                                    </div>
                                    <div class="radio-item">
                                        <input type="radio" name="tipo_usuario" value="profesor" id="profesor">
                                        <label for="profesor">Profesor</label>
                                    </div>
                                    <div class="radio-item">
                                        <input type="radio" name="tipo_usuario" value="usuario" id="usuario">
                                        <label for="usuario">Alumno</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="button" class="btn btn-secondary" onclick="toggleCreateForm()">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Crear usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sección de filtros -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
    <h3 class="mb-0">
        <i class="fas fa-users"></i> Lista de usuarios registrados
    </h3>
     <a href="{{ route('admin.usuarios.export') }}" class="btn btn-success btn-sm">
    <i class="fas fa-file-excel"></i> Exportar usuarios
</a>
    <a href="{{ route('admin.seguridad.login') }}" class="btn btn-light btn-sm">
        <i class="fas fa-plus me-1"></i> Historial de Login
    </a>
   
</div>



           
            
            <div class="card-body">
                <div class="filter-section">
                    <div class="row align-items-end">
                        <div class="col-md-3">
                            <label class="form-label">Filtrar por rol:</label>
                            <form method="GET" action="{{ route('admin.usuarios.create') }}">
                                <select name="filtro" class="form-select" onchange="this.form.submit()">
                                    <option value="">Todos</option>
                                    <option value="admin" {{ request('filtro') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="profesor" {{ request('filtro') == 'profesor' ? 'selected' : '' }}>Profesor</option>
                                    <option value="usuario" {{ request('filtro') == 'usuario' ? 'selected' : '' }}>Alumno</option>
                                </select>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Buscar por nombre:</label>
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" id="searchName" class="form-control" placeholder="Buscar por nombre completo...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Buscar por DNI:</label>
                            <div class="search-box">
                                <i class="fas fa-id-card"></i>
                                <input type="text" id="searchDNI" class="form-control" placeholder="Buscar por DNI...">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-secondary w-100" onclick="clearFilters()">
                                <i class="fas fa-times me-1"></i>Limpiar
                            </button>
                        </div>
                    </div>
                </div>

                @if($usuarios->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-hover" id="usersTable">
                        <thead>
                            <tr>
                                <th>Nombre completo</th>
                                <th>DNI</th>
                                <th>Email</th>
                                <th>Tipo(s)</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usuarios as $user)
                            <tr>
                                <td><strong>{{ $user->name }} {{ $user->apellido_p }} {{ $user->apellido_m }}</strong></td>
                                <td>{{ $user->dni }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->admin) <span class="badge badge-admin"><i class="fas fa-cog me-1"></i>Admin</span> @endif
                                    @if($user->profesor) <span class="badge badge-profesor"><i class="fas fa-chalkboard-teacher me-1"></i>Profesor</span> @endif
                                    @if($user->usuario) <span class="badge badge-alumno"><i class="fas fa-graduation-cap me-1"></i>Alumno</span> @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-success btn-sm" onclick="abrirEditar({{ $user->id }})">
                                            <i class="fas fa-edit"></i> Editar
                                        </button>
                                        <button type="button" class="btn btn-warning btn-sm" onclick="abrirPassword({{ $user->id }})">
                                            <i class="fas fa-key"></i> Contraseña
                                        </button>
                                        <form method="POST" action="{{ route('admin.usuarios.destroy', $user->id) }}" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar al usuario?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No hay usuarios que coincidan con el filtro seleccionado.</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Editar Usuario -->
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="formEditar" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header" style="background: linear-gradient(120deg, #0249BB 0%, #003bb1 100%); color: white; border-radius: 0;">
                        <h5 class="modal-title" id="modalEditarLabel"><i class="fas fa-edit me-2"></i>Editar usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar" style="filter: invert(1);"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editar_id">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Nombre:</label>
                                    <input type="text" name="name" id="editar_name" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Apellido paterno:</label>
                                    <input type="text" name="apellido_p" id="editar_apellido_p" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Apellido materno:</label>
                                    <input type="text" name="apellido_m" id="editar_apellido_m" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">DNI:</label>
                                    <input type="text" name="dni" id="editar_dni" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Email:</label>
                                    <input type="email" name="email" id="editar_email" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Fecha de nacimiento:</label>
                                    <input type="date" name="fecha_nacimiento" id="editar_fecha_nacimiento" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Género:</label>
                                    <select name="genero" id="editar_genero" class="form-select">
                                        <option value="masculino">Masculino</option>
                                        <option value="femenino">Femenino</option>
                                        <option value="otro">Otro</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Teléfono:</label>
                                    <input type="text" name="telefono" id="editar_telefono" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tipo de usuario:</label>
                            <div class="radio-group">
                                <div class="radio-item">
                                    <input type="radio" name="tipo_usuario" value="admin" id="editar_admin_radio">
                                    <label for="editar_admin_radio">Admin</label>
                                </div>
                                <div class="radio-item">
                                    <input type="radio" name="tipo_usuario" value="profesor" id="editar_profesor_radio">
                                    <label for="editar_profesor_radio">Profesor</label>
                                </div>
                                <div class="radio-item">
                                    <input type="radio" name="tipo_usuario" value="usuario" id="editar_usuario_radio">
                                    <label for="editar_usuario_radio">Alumno</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Guardar cambios</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-2"></i>Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Cambiar Contraseña -->
    <div class="modal fade" id="modalPassword" tabindex="-1" aria-labelledby="modalPasswordLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formPassword" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header" style="background: linear-gradient(120deg, #0249BB 0%, #003bb1 100%); color: white; border-radius: 0;">
                        <h5 class="modal-title" id="modalPasswordLabel"><i class="fas fa-key me-2"></i>Cambiar contraseña</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar" style="filter: invert(1);"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">Nueva contraseña:</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-sync-alt me-2"></i>Actualizar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-2"></i>Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        // Función para mostrar/ocultar formulario de creación
        function toggleCreateForm() {
            const form = document.getElementById('createForm');
            const btn = document.getElementById('toggleBtn');
            
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'block';
                btn.innerHTML = '<i class="fas fa-minus me-1"></i>Ocultar';
                btn.classList.remove('btn-light');
                btn.classList.add('btn-secondary');
            } else {
                form.style.display = 'none';
                btn.innerHTML = '<i class="fas fa-plus me-1"></i>Crear';
                btn.classList.remove('btn-secondary');
                btn.classList.add('btn-light');
            }
        }

        function abrirEditar(id) {
            fetch(`/admin/usuarios/${id}`)
                .then(response => response.json())
                .then(user => {
                    document.getElementById('formEditar').action = `/admin/usuarios/${id}`;
                    document.getElementById('editar_id').value = user.id;
                    document.getElementById('editar_name').value = user.name;
                    document.getElementById('editar_apellido_p').value = user.apellido_p;
                    document.getElementById('editar_apellido_m').value = user.apellido_m;
                    document.getElementById('editar_dni').value = user.dni;
                    document.getElementById('editar_email').value = user.email;
                    document.getElementById('editar_fecha_nacimiento').value = user.fecha_nacimiento;
                    document.getElementById('editar_genero').value = user.genero;
                    document.getElementById('editar_telefono').value = user.telefono;
                    
                    if (user.admin) {
                        document.getElementById('editar_admin_radio').checked = true;
                    } else if (user.profesor) {
                        document.getElementById('editar_profesor_radio').checked = true;
                    } else if (user.usuario) {
                        document.getElementById('editar_usuario_radio').checked = true;
                    }

                    const modal = new bootstrap.Modal(document.getElementById('modalEditar'));
                    modal.show();
                });
        }

        function abrirPassword(id) {
            document.getElementById('formPassword').action = `/admin/usuarios/${id}/password`;
            const modal = new bootstrap.Modal(document.getElementById('modalPassword'));
            modal.show();
        }

        // Funcionalidad de filtrado
        function filterTable() {
            const nameFilter = document.getElementById('searchName').value.toLowerCase();
            const dniFilter = document.getElementById('searchDNI').value.toLowerCase();
            const rows = document.querySelectorAll('#usersTable tbody tr');

            rows.forEach(row => {
                const name = row.cells[0].textContent.toLowerCase();
                const dni = row.cells[1].textContent.toLowerCase();
                
                const nameMatch = name.includes(nameFilter);
                const dniMatch = dni.includes(dniFilter);
                
                if (nameMatch && dniMatch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function clearFilters() {
            document.getElementById('searchName').value = '';
            document.getElementById('searchDNI').value = '';
            filterTable();
        }

        // Event listeners para los filtros
        document.getElementById('searchName').addEventListener('input', filterTable);
        document.getElementById('searchDNI').addEventListener('input', filterTable);
    </script>

</section>
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
            // Handle navigation for ALL nav-links
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    const isSubmenuToggle = this.hasAttribute('data-bs-toggle');
                    const isMobile = window.innerWidth <= 768;
                    if (isSubmenuToggle && isMobile) {
                        e.preventDefault();
                        e.stopPropagation();
                        return;
                    }
                    if (this.href && !this.href.includes('#')) {
                        return;
                    }
                    e.preventDefault();
                    if (!isSubmenuToggle) {
                        navLinks.forEach(l => l.classList.remove('active'));
                        this.classList.add('active');
                    }
                    if (isMobile && !isSubmenuToggle) {
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
            // Mejorar comportamiento del dropdown del usuario
            const userDropdownToggle = document.getElementById('navbarDropdown');
            const userDropdownMenu = userDropdownToggle ? userDropdownToggle.nextElementSibling : null;
            if (userDropdownToggle && userDropdownMenu) {
                userDropdownToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                });
                // Cerrar dropdown al hacer clic fuera
                document.addEventListener('click', function(e) {
                    if (!userDropdownToggle.contains(e.target) && !userDropdownMenu.contains(e.target)) {
                        const bsDropdown = bootstrap.Dropdown.getInstance(userDropdownToggle);
                        if (bsDropdown) {
                            bsDropdown.hide();
                        }
                    }
                });
            }
        });
    </script>
    <!-- Formulario de logout (mantener al final del body) -->
    <form id="logout-form" action="#" method="POST" class="d-none">
        <!-- @csrf -->
    </form>
</body>
</html>