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
                        <a class="nav-link  active nav-group-toggle" href="#notasSubmenu" data-bs-toggle="collapse" aria-expanded="false" aria-controls="notasSubmenu">
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
                                    <a class="nav-link active" href="{{ route('admin.notas_y_asistencias') }}">
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
    :root {
        --primary-gradient: linear-gradient(120deg, #0249BB 0%, #003bb1 100%);
        --primary-color: #0249BB;
        --secondary-color: #003bb1;
    }

   

    .header-section {
        background: var(--primary-gradient);
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-radius: 0 0 20px 20px;
        box-shadow: 0 4px 20px rgba(2, 73, 187, 0.3);
    }

    .header-section h3 {
        margin: 0;
        font-weight: 600;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .filter-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        border: none;
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .filter-card .card-header {
        background: var(--primary-gradient);
        color: white;
        border: none;
        padding: 1.25rem;
    }

    .filter-card .card-body {
        padding: 2rem;
    }

    .form-select, .form-control {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .form-select:focus, .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(2, 73, 187, 0.25);
    }

    .btn-export {
        background: var(--primary-gradient);
        border: none;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        color: white;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(2, 73, 187, 0.3);
    }

    .btn-export:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(2, 73, 187, 0.4);
        color: white;
    }

    .table-container {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .table {
        margin: 0;
    }

    .table thead th {
        background: var(--primary-gradient);
        color: white;
        border: none;
        padding: 1rem;
        font-weight: 600;
        text-align: center;
        vertical-align: middle;
    }

    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-color: #f8f9fa;
    }

    .table tbody tr:hover {
        background-color: rgba(2, 73, 187, 0.05);
    }

    .btn-edit {
        background: var(--primary-gradient);
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        color: white;
        font-size: 0.875rem;
        transition: all 0.3s ease;
    }

    .btn-edit:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(2, 73, 187, 0.3);
        color: white;
    }

    .modal-content {
        border: none;
        border-radius: 15px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        background: var(--primary-gradient);
        color: white;
        border: none;
        border-radius: 15px 15px 0 0;
        padding: 1.5rem;
    }

    .modal-title {
        font-weight: 600;
    }

    .section-title {
        color: var(--primary-color);
        font-weight: 600;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--primary-color);
    }

    .readonly-input {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
        font-weight: 600;
        color: var(--primary-color);
    }

    .final-grade {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
        color: white !important;
        font-weight: 700;
        font-size: 1.1rem;
    }

    .attendance-badge {
        background: var(--primary-gradient);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        display: inline-block;
    }

    .alert {
        border: none;
        border-radius: 10px;
        padding: 1rem 1.5rem;
    }

    .alert-success {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        color: #155724;
    }

    .alert-danger {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        color: #721c24;
    }

    .alert-warning {
        background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
        color: #856404;
    }

    @media (max-width: 768px) {
        .header-section {
            padding: 1.5rem 0;
        }
        
        .filter-card .card-body {
            padding: 1.5rem;
        }
        
        .table-responsive {
            border-radius: 15px;
        }
        
        .table thead th {
            font-size: 0.875rem;
            padding: 0.75rem 0.5rem;
        }
        
        .table tbody td {
            font-size: 0.875rem;
            padding: 0.75rem 0.5rem;
        }
    }

    @media (max-width: 576px) {
        .modal-dialog {
            margin: 0.5rem;
        }
        
        .modal-body {
            padding: 1rem;
        }
    }
</style>

<div class="header-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col">
                <h3><i class="fas fa-graduation-cap me-3"></i>Notas y Asistencias de Alumnos</h3>
            </div>
        </div>
    </div>
</div>

<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        </div>
    @endif

    <!-- Filtros -->
    <div class="card filter-card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filtros de Búsqueda</h5>
        </div>
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-university me-1"></i>Facultad
                    </label>
                    <select name="facultad_id" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Seleccionar Facultad --</option>
                        @foreach($facultades as $fac)
                            <option value="{{ $fac->id }}" {{ request('facultad_id') == $fac->id ? 'selected' : '' }}>
                                {{ $fac->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-book me-1"></i>Carrera
                    </label>
                    <select name="carrera_id" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Seleccionar Carrera --</option>
                        @foreach(\App\Models\Carrera::where('facultad_id', request('facultad_id'))->get() as $car)
                            <option value="{{ $car->id }}" {{ request('carrera_id') == $car->id ? 'selected' : '' }}>
                                {{ $car->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-chalkboard-teacher me-1"></i>Curso
                    </label>
                    <select name="curso_id" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Seleccionar Curso --</option>
                        @foreach(\App\Models\Curso::where('carrera_id', request('carrera_id'))->get() as $cur)
                            <option value="{{ $cur->id }}" {{ request('curso_id') == $cur->id ? 'selected' : '' }}>
                                {{ $cur->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="fas fa-calendar-alt me-1"></i>Periodo
                    </label>
                    <select name="periodo_id" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Seleccionar Periodo --</option>
                        @foreach($periodos as $per)
                            <option value="{{ $per->id }}" {{ request('periodo_id') == $per->id ? 'selected' : '' }}>
                                {{ $per->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
    </div>

    @if($matriculas->count())
        <div class="mb-4">
            <a href="{{ route('admin.notas.exportar', request()->query()) }}" class="btn btn-export">
                <i class="fas fa-file-excel me-2"></i>Exportar a Excel
            </a>
        </div>

        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th><i class="fas fa-user me-1"></i>Alumno</th>
                            <th><i class="fas fa-id-card me-1"></i>DNI</th>
                            <th>1er Avance</th>
                            <th>2do Avance</th>
                            <th>Final</th>
                            <th><i class="fas fa-trophy me-1"></i>Promedio</th>
                            <th><i class="fas fa-calendar-check me-1"></i>Asistencias</th>
                            <th><i class="fas fa-cogs me-1"></i>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($matriculas as $matricula)
                            @php
                                $calificacion = $matricula->user->calificaciones->first();
                                $asistencias = $matricula->user->asistencias;
                                $asistenciasCount = $asistencias->count();
                                $asistenciasAsistio = $asistencias->where('asistio', true)->count();
                                $porcentajeAsistencia = $asistenciasCount > 0 ? round(($asistenciasAsistio / $asistenciasCount) * 100, 1) : 0;
                            @endphp
                            <tr>
                                <td class="fw-semibold">{{ $matricula->user->name }}</td>
                                <td>{{ $matricula->user->dni }}</td>
                                <td class="text-center">
                                    <span class="badge bg-secondary">{{ $calificacion->primer_avance ?? '-' }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary">{{ $calificacion->segundo_avance ?? '-' }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary">{{ $calificacion->presentacion_final ?? '-' }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-success fs-6">{{ $calificacion->promedio_final ?? '-' }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="attendance-badge">
                                        {{ $asistenciasAsistio }}/{{ $asistenciasCount }} ({{ $porcentajeAsistencia }}%)
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-edit btn-sm" data-bs-toggle="modal" data-bs-target="#modalNotas{{ $matricula->id }}">
                                        <i class="fas fa-edit me-1"></i>Editar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modales -->
        @foreach($matriculas as $matricula)
            @php
                $calificacion = $matricula->user->calificaciones->first();
            @endphp
            <div class="modal fade" id="modalNotas{{ $matricula->id }}" tabindex="-1" aria-labelledby="modalNotasLabel{{ $matricula->id }}" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalNotasLabel{{ $matricula->id }}">
                                <i class="fas fa-user-graduate me-2"></i>
                                Editar Calificaciones - {{ $matricula->user->name }}
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="{{ route('admin.notas.actualizar', $calificacion->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <!-- Avances Académicos -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h5 class="section-title">
                                                <i class="fas fa-chart-line me-2"></i>Avances Académicos
                                            </h5>
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-3">
                                            <label class="form-label fw-semibold">Primer Avance</label>
                                            <input type="number" step="0.01" name="primer_avance" class="form-control calc" value="{{ $calificacion->primer_avance }}">
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-3">
                                            <label class="form-label fw-semibold">Segundo Avance</label>
                                            <input type="number" step="0.01" name="segundo_avance" class="form-control calc" value="{{ $calificacion->segundo_avance }}">
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-3">
                                            <label class="form-label fw-semibold">Presentación Final</label>
                                            <input type="number" step="0.01" name="presentacion_final" class="form-control calc" value="{{ $calificacion->presentacion_final }}">
                                        </div>
                                        <div class="col-lg-3 col-md-6 mb-3">
                                            <label class="form-label fw-bold">Promedio Avance</label>
                                            <input type="number" step="0.01" name="promedio_avance" class="form-control readonly-input" id="promedio_avance{{ $matricula->id }}" readonly>
                                        </div>
                                    </div>

                                    <!-- Evaluaciones Orales -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h5 class="section-title">
                                                <i class="fas fa-microphone me-2"></i>Evaluaciones Orales
                                            </h5>
                                        </div>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                                                <label class="form-label fw-semibold">Oral {{ $i }}</label>
                                                <input type="number" step="0.01" name="oral_{{ $i }}" class="form-control calc" value="{{ $calificacion->{'oral_'.$i} }}">
                                            </div>
                                        @endfor
                                        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                                            <label class="form-label fw-bold">Promedio Orales</label>
                                            <input type="number" step="0.01" name="promedio" class="form-control readonly-input" id="promedio_orales{{ $matricula->id }}" readonly>
                                        </div>
                                    </div>

                                    <!-- Evaluación Final -->
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h5 class="section-title">
                                                <i class="fas fa-clipboard-check me-2"></i>Evaluación Final
                                            </h5>
                                        </div>
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <label class="form-label fw-bold">Promedio Evaluación Permanente</label>
                                            <input type="number" step="0.01" name="promedio_evaluacion_permanente" class="form-control readonly-input" id="promedio_evaluacion_permanente{{ $matricula->id }}" readonly>
                                        </div>
                                        <div class="col-lg-4 col-md-6 mb-3">
                                            <label class="form-label fw-semibold">Examen Final</label>
                                            <input type="number" step="0.01" name="examen_final" class="form-control calc" value="{{ $calificacion->examen_final }}">
                                        </div>
                                        <div class="col-lg-4 col-md-12 mb-3">
                                            <label class="form-label fw-bold text-success">
                                                <i class="fas fa-trophy me-1"></i>Promedio Final
                                            </label>
                                            <input type="number" step="0.01" name="promedio_final" class="form-control final-grade" id="promedio_final{{ $matricula->id }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-2"></i>Guardar Cambios
                                </button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-2"></i>Cancelar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

    @elseif(request()->filled(['facultad_id', 'carrera_id', 'curso_id', 'periodo_id']))
        <div class="alert alert-warning text-center">
            <i class="fas fa-exclamation-triangle me-2"></i>
            No hay alumnos matriculados en este curso y periodo.
        </div>
    @endif
</div>
<script>
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('input', function () {
            const id = this.id.replace('modalNotas', '');
            const getValue = (name) => {
                const input = modal.querySelector(`[name="${name}"]`);
                return input ? parseFloat(input.value) || 0 : 0;
            };

            // Calcular promedio de avances
            const promAvance = (
                getValue('primer_avance') + getValue('segundo_avance') + getValue('presentacion_final')
            ) / 3;

            // Calcular promedio de orales
            const orales = ['oral_1', 'oral_2', 'oral_3', 'oral_4', 'oral_5'];
            const promOrales = orales.reduce((sum, n) => sum + getValue(n), 0) / orales.length;

            // Calcular promedio de evaluación permanente
            const promEvalPermanente = (promAvance + promOrales) / 2;

            // Calcular promedio final
            const promFinal = (promEvalPermanente + getValue('examen_final')) / 2;

            // Actualizar campos
            modal.querySelector(`#promedio_avance${id}`).value = promAvance.toFixed(2);
            modal.querySelector(`#promedio_orales${id}`).value = promOrales.toFixed(2);
            modal.querySelector(`#promedio_evaluacion_permanente${id}`).value = promEvalPermanente.toFixed(2);
            modal.querySelector(`#promedio_final${id}`).value = promFinal.toFixed(2);
        });

        // Calcular al abrir el modal
        modal.addEventListener('shown.bs.modal', () => {
            modal.dispatchEvent(new Event('input'));
        });
    });
</script>


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


