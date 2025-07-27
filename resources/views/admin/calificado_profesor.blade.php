<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Estudiante</title>
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
                        <a class="nav-link nav-group-toggle" href="#usuariosSubmenu" data-bs-toggle="collapse" aria-expanded="false" aria-controls="usuariosSubmenu">
                            <i class="fas fa-users-cog"></i>
                            <span class="nav-text">Gestión de Usuarios</span>
                            <i class="fas fa-chevron-down nav-group-icon"></i>
                            <div class="tooltip-custom">Gestión de Usuarios</div>
                        </a>
                        <div class="collapse" id="usuariosSubmenu">
                            <ul class="nav flex-column nav-submenu">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.usuarios.create') }}">
                                        <i class="fas fa-user"></i> <span class="nav-text">Usuarios y Roles</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!-- Nuevo Grupo Colapsable: Administración -->
                    <li class="nav-item nav-group">
                        <a class="nav-link active nav-group-toggle" href="#academicaSubmenu" data-bs-toggle="collapse" aria-expanded="false" aria-controls="academicaSubmenu">
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
                                    <a class="nav-link active" href="{{ route('admin.calificado_profesor.index') }}">
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
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user me-2"></i>Mi Perfil
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cog me-2"></i>Configuración
                            </a>
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
       
        .header-gradient {
            background: linear-gradient(120deg, #0249BB 0%, #003bb1 100%);
            color: white;
            padding: 2.5rem 1.5rem; /* Menos padding para hacerlo más compacto */
            border-bottom-left-radius: 1rem;
            border-bottom-right-radius: 1rem;
            position: relative;
            overflow: hidden;
        }
        .header-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path fill="rgba(255,255,255,0.1)" d="M0,0 C30,100 70,0 100,100 L100,0 Z" /></svg>') no-repeat center center;
            background-size: cover;
            opacity: 0.1;
            transform: scaleY(-1); /* Invertir para que la onda esté en la parte inferior */
        }
        .card {
            border: none;
            border-radius: 1rem; /* Bordes más redondeados */
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1); /* Sombra más pronunciada pero suave */
            margin-bottom: 2rem; /* Espacio entre tarjetas */
        }
        .card-header-custom {
            background-color: #f8f9fa; /* Fondo claro para encabezados de tarjeta */
            border-bottom: 1px solid #e9ecef;
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            color: #212529;
            font-size: 1.15rem;
        }
        .form-select, .form-control {
            border-radius: 0.6rem; /* Bordes más suaves para inputs */
            padding: 0.6rem 1rem;
            font-size: 0.95rem;
        }
        .table-responsive {
            border-radius: 0.75rem; /* Bordes redondeados para la tabla */
            overflow: hidden;
            border: 1px solid #e9ecef;
        }
        .table thead th {
            background-color: #e9ecef; /* Fondo para el encabezado de la tabla */
            color: #495057;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
            padding: 0.75rem 1rem; /* Menos padding en th */
            font-size: 0.85rem;
            text-transform: uppercase;
        }
        .table tbody tr td {
            vertical-align: middle;
            padding: 0.6rem 1rem; /* Menos padding en td */
            font-size: 0.9rem;
            color: #495057;
        }
        .table tbody tr:hover {
            background-color: #f0f8ff; /* Un azul muy claro al pasar el ratón */
        }
        .avg-score-card {
            background: linear-gradient(45deg, #e3f2fd 0%, #bbdefb 100%); /* Gradiente sutil para la tarjeta de promedio */
            border: 1px solid #90caf9;
            color: #0d47a1;
            text-align: center;
        }
        .avg-score-value {
            font-size: 5rem; /* Tamaño grande pero no excesivo */
            font-weight: 900; /* Más negrita */
            line-height: 1;
            color: #003bb1; /* Color del gradiente principal */
            text-shadow: 1px 1px 3px rgba(0,0,0,0.1);
        }
        .icon-large {
            font-size: 3.5rem; /* Tamaño del ícono */
            color: #003bb1;
        }
        .text-primary-custom {
            color: #003bb1 !important; /* Asegurar que el color primario sea el del gradiente */
        }
        .alert-danger {
            background-color: #fde7e7;
            border-color: #f5c6cb;
            color: #721c24;
        }
        .alert-danger .btn-close {
            color: #721c24;
        }
        /* Estilo para truncar comentarios */
        .text-truncate-custom {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 180px; /* Ajusta esto según el espacio deseado */
            display: inline-block; /* Necesario para que text-truncate funcione */
        }

        /* Media queries para responsividad */
        @media (max-width: 767.98px) {
            .header-gradient {
                padding: 2rem 1rem;
                border-radius: 0; /* Sin bordes redondeados en móviles para ocupar todo el ancho */
            }
            .display-4 {
                font-size: 2.5rem;
            }
            .lead {
                font-size: 1rem;
            }
            .card {
                border-radius: 0.75rem;
                margin-bottom: 1.5rem;
            }
            .card-body {
                padding: 1.5rem;
            }
            .avg-score-value {
                font-size: 4rem;
            }
            .icon-large {
                font-size: 3rem;
            }
            .table thead th, .table tbody tr td {
                padding: 0.5rem 0.75rem;
                font-size: 0.8rem;
            }
            .text-truncate-custom {
                max-width: 120px; /* Más pequeño en móviles */
            }
        }
    </style>
     <div class="container-fluid p-0">
        <!-- Encabezado con fondo de gradiente -->
        <div class="header-gradient text-center mb-5">
            <h1 class="display-4 fw-bold mb-2">Calificaciones de Profesores</h1>
            <p class="lead opacity-90">Análisis detallado del rendimiento docente</p>
        </div>
    </div>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-11 col-xl-10">
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>¡Error!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Filtros de Periodo y Profesor -->
                <div class="card mb-5">
                    <div class="card-header-custom">
                        <i class="fas fa-filter me-2"></i> Filtros de Búsqueda
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.calificado_profesor.index') }}" class="row g-3 align-items-end">
                            <div class="col-12 col-md-6">
                                <label for="periodo_id" class="form-label fw-semibold">Periodo Académico:</label>
                                <select name="periodo_id" id="periodo_id" class="form-select" onchange="this.form.submit()">
                                    @foreach($periodos as $periodo)
                                        <option value="{{ $periodo->id }}" @if($periodo->id == $periodo_id) selected @endif>{{ $periodo->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="profesor_id" class="form-label fw-semibold">Profesor:</label>
                                <select name="profesor_id" id="profesor_id" class="form-select" onchange="this.form.submit()">
                                    @foreach($profesores as $profesor)
                                        <option value="{{ $profesor->id }}" @if($profesor->id == $profesor_id) selected @endif>{{ $profesor->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Promedio general del profesor -->
                <div class="card mb-5 avg-score-card">
                    <div class="card-body p-4 p-md-5">
                        <h4 class="h4 fw-semibold mb-4">
                            Promedio General de
                            <span class="text-primary-custom fw-bold">{{ $profesores->firstWhere('id', $profesor_id)->name ?? 'Profesor' }}</span>
                            en el periodo
                            <span class="text-primary-custom fw-bold">{{ $periodos->firstWhere('id', $periodo_id)->nombre ?? 'Periodo' }}</span>:
                        </h4>
                        <div class="d-flex flex-column flex-sm-row align-items-center justify-content-center gap-3">
                            <i class="fas fa-award icon-large"></i>
                            <p class="avg-score-value mb-0">{{ number_format($promedioGeneral, 2) ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Promedios por curso -->
                <div class="card mb-5">
                    <div class="card-header-custom">
                        <i class="fas fa-book-open me-2"></i> Promedios por Curso
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">Curso</th>
                                        <th scope="col">Total de Calificaciones</th>
                                        <th scope="col">Promedio Preguntas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($promediosPorCurso as $curso)
                                        <tr>
                                            <td>{{ $curso['curso_nombre'] }}</td>
                                            <td>{{ $curso['cantidad_calificaciones'] }}</td>
                                            <td>{{ number_format($curso['promedio_preguntas'], 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted py-4">No hay calificaciones por curso para este profesor en este periodo.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Detalle de calificaciones -->
                <div class="card mb-5">
                    <div class="card-header-custom">
                        <i class="fas fa-list-alt me-2"></i> Detalle de Calificaciones Individuales
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">ID Calificación</th>
                                        <th scope="col">Curso</th>
                                        <th scope="col">Promedio Preguntas</th>
                                        <th scope="col">Preguntas (1-5)</th>
                                        <th scope="col">Comentario</th>
                                        <th scope="col">Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($calificaciones as $cal)
                                        <tr>
                                            <td>{{ $cal->calificacion_id }}</td>
                                            <td>{{ $cal->curso_nombre }}</td>
                                            <td>{{ $cal->promedio_preguntas }}</td>
                                            <td>{{ $cal->pregunta_1 }}, {{ $cal->pregunta_2 }}, {{ $cal->pregunta_3 }}, {{ $cal->pregunta_4 }}, {{ $cal->pregunta_5 }}</td>
                                            <td>
                                                <span class="text-truncate-custom" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $cal->comentario ?? '-' }}">
                                                    {{ $cal->comentario ?? '-' }}
                                                </span>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($cal->created_at)->format('Y-m-d') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Profesores con promedio menor a 3 -->
                <div class="card">
                    <div class="card-header-custom">
                        <i class="fas fa-exclamation-triangle me-2"></i> Profesores con Promedio Menor a 3
                    </div>
                    <div class="card-body p-0">
                        @if($profesoresMalCalificados->isEmpty())
                            <p class="text-muted text-center py-4 mb-0">No hay profesores con promedio menor a 3 en este periodo.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Profesor</th>
                                            <th scope="col">Promedio Preguntas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($profesoresMalCalificados as $prof)
                                            <tr>
                                                <td>{{ $prof->name }}</td>
                                                <td>{{ number_format($prof->promedio_preguntas, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Inicializar tooltips de Bootstrap
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>


                <!-- aquí agrega tu contenido principal -->
               
           
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
