
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Estudiante</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

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
    <a class="nav-link active nav-group-toggle" href="#controlAcademicoSubmenu" data-bs-toggle="collapse" aria-expanded="false" aria-controls="controlAcademicoSubmenu">
        <i class="fas fa-user-check"></i>
        <span class="nav-text">Control Académico</span>
        <i class="fas fa-chevron-down nav-group-icon"></i>
        <div class="tooltip-custom">Control Académico</div>
    </a>
    <div class="collapse" id="controlAcademicoSubmenu">
        <ul class="nav flex-column nav-submenu">
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('admin.verprofesor') }}">
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
        :root {
            --primary-gradient: linear-gradient(120deg, #0249BB 0%, #003bb1 100%);
            --primary-color: #0249BB;
            --primary-dark: #003bb1;
            --shadow-light: rgba(2, 73, 187, 0.08);
            --shadow-medium: rgba(2, 73, 187, 0.15);
            --shadow-strong: rgba(2, 73, 187, 0.25);
        }

    
        .main-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
            margin: 1rem 0;
        }

        .header-section {
            background: var(--primary-gradient);
            color: white;
            padding: 1.5rem 2rem;
            position: relative;
            overflow: hidden;
        }

        .header-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Ccircle cx='20' cy='20' r='1.5'/%3E%3C/g%3E%3C/svg%3E") repeat;
        }

        .header-section h2 {
            font-weight: 700;
            font-size: 1.75rem;
            margin: 0;
            position: relative;
            z-index: 1;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .header-section .subtitle {
            font-size: 0.95rem;
            opacity: 0.9;
            margin-top: 0.3rem;
            position: relative;
            z-index: 1;
        }

        .evaluation-form {
            background: linear-gradient(145deg, #ffffff 0%, #f8f9ff 100%);
            border-radius: 12px;
            padding: 1.5rem;
            margin: 1.5rem;
            box-shadow: 0 4px 16px var(--shadow-light);
            border: 1px solid rgba(2, 73, 187, 0.06);
            position: relative;
        }

        .evaluation-form::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--primary-gradient);
            border-radius: 12px 12px 0 0;
        }

        .filters-section {
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            padding: 1rem 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 0.5rem;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .form-control, .form-select {
            border: 1px solid #e0e6ed;
            border-radius: 8px;
            padding: 0.5rem 0.75rem;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
            height: auto;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.15rem var(--shadow-light);
            background: white;
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px var(--shadow-medium);
            height: fit-content;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px var(--shadow-strong);
        }

        .btn-outline-secondary {
            border: 1px solid #6c757d;
            color: #6c757d;
            border-radius: 8px;
            padding: 0.4rem 1rem;
            font-size: 0.8rem;
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            background: #6c757d;
            border-color: #6c757d;
            color: white;
        }

        .table-container {
            background: white;
            border-radius: 0 0 16px 16px;
            overflow: hidden;
        }

        .table {
            margin: 0;
            font-size: 0.8rem;
        }

        .table thead th {
            background: var(--primary-gradient);
            color: white;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            padding: 0.8rem 0.6rem;
            border: none;
            white-space: nowrap;
        }

        .table tbody tr {
            transition: all 0.2s ease;
            border-bottom: 1px solid rgba(2, 73, 187, 0.06);
        }

        .table tbody tr:hover {
            background: linear-gradient(90deg, rgba(2, 73, 187, 0.02) 0%, rgba(2, 73, 187, 0.04) 50%, rgba(2, 73, 187, 0.02) 100%);
        }

        .table tbody td {
            padding: 0.7rem 0.6rem;
            vertical-align: middle;
            border: none;
        }

        .virtual-link {
            background: var(--primary-gradient);
            color: white;
            text-decoration: none;
            padding: 0.3rem 0.8rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        .virtual-link:hover {
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px var(--shadow-medium);
        }

        .no-assigned {
            color: #6c757d;
            font-style: italic;
            font-size: 0.75rem;
        }

        .day-badge {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            padding: 0.2rem 0.6rem;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 500;
            display: inline-block;
        }

        .time-display {
            font-family: 'Monaco', 'Menlo', monospace;
            background: rgba(2, 73, 187, 0.08);
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            color: var(--primary-dark);
            font-weight: 500;
            font-size: 0.75rem;
        }

        .section-badge {
            background: #e9ecef;
            color: #495057;
            padding: 0.2rem 0.5rem;
            border-radius: 8px;
            font-size: 0.7rem;
            font-weight: 500;
        }

        .filter-badge {
            background: var(--primary-color);
            color: white;
            padding: 0.2rem 0.6rem;
            border-radius: 12px;
            font-size: 0.7rem;
            margin-right: 0.5rem;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        .filter-badge .remove-filter {
            cursor: pointer;
            opacity: 0.8;
        }

        .filter-badge .remove-filter:hover {
            opacity: 1;
        }

        /* Select2 Customization */
        .select2-container--default .select2-selection--single {
            border: 1px solid #e0e6ed;
            border-radius: 8px;
            height: auto;
            padding: 0.1rem;
            background: rgba(255, 255, 255, 0.9);
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            padding: 0.4rem 0.6rem;
            color: #495057;
            font-size: 0.85rem;
        }

        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.15rem var(--shadow-light);
        }

        .select2-dropdown {
            border: 1px solid var(--primary-color);
            border-radius: 8px;
            box-shadow: 0 4px 16px var(--shadow-medium);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header-section {
                padding: 1rem;
            }

            .header-section h2 {
                font-size: 1.4rem;
            }

            .evaluation-form {
                margin: 1rem;
                padding: 1rem;
            }

            .filters-section {
                padding: 0.8rem 1rem;
            }

            .table-container {
                overflow-x: auto;
            }

            .table {
                min-width: 800px;
            }

            .table thead th,
            .table tbody td {
                padding: 0.5rem 0.4rem;
            }
        }

        @media (max-width: 576px) {
            .evaluation-form .row,
            .filters-section .row {
                row-gap: 0.8rem;
            }

            .btn-primary {
                width: 100%;
                margin-top: 0.5rem;
            }
        }

        /* Animation */
        .main-container {
            animation: slideInUp 0.5s ease-out;
        }

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

        .hidden-row {
            display: none !important;
        }

        .stats-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 8px;
            padding: 0.8rem;
            text-align: center;
            border: 1px solid #dee2e6;
        }

        .stats-number {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
        }

        .stats-label {
            font-size: 0.7rem;
            color: #6c757d;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>

     <div class="container-fluid py-3">
        <div class="main-container">
            <!-- Header Section -->
            <div class="header-section">
                <h2><i class="fas fa-chalkboard-teacher me-2"></i>Profesores dictando clases</h2>
                <div class="subtitle">Periodo {{ $periodoActual->nombre ?? 'Actual' }}</div>
            </div>
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
            <!-- Formulario para evaluar profesor -->
            <div class="evaluation-form">
                <form action="{{ route('admin.verprofesor.evaluar') }}" method="POST" id="evaluationForm">
                    @csrf
                    <div class="row align-items-end g-3">
                        <!-- Profesor con Select2 -->
                        <div class="col-md-5">
                            <label for="profesor_id" class="form-label">
                                <i class="fas fa-user-tie"></i>
                                Profesor
                            </label>
                            <select id="profesor_id" name="profesor_id" class="form-control" required>
                                <option value="">Seleccione profesor</option>
                                @foreach($profesores->unique('profesor_id') as $prof)
                                    <option value="{{ $prof->profesor_id }}">{{ $prof->profesor }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Estado -->
                        <div class="col-md-4">
                            <label for="estado_dictado" class="form-label">
                                <i class="fas fa-clipboard-check"></i>
                                Estado de Evaluación
                            </label>
                            <select id="estado_dictado" name="estado_dictado" class="form-select" required>
                                <option value="">Seleccione estado</option>
                                <option value="bien">✓ Bien</option>
                                <option value="mal">✗ Mal</option>
                            </select>
                        </div>

                        <!-- Botón -->
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary w-100" id="submitBtn">
                                <i class="fas fa-save me-1"></i>
                                Guardar
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Mensajes -->
            @if(!empty($mensaje))
                <div class="alert alert-info alert-dismissible fade show mx-3" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    {{ $mensaje }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @else
                <!-- Filtros y Estadísticas -->
                <div class="filters-section">
                    <div class="row g-3 align-items-end">
                        <!-- Filtros -->
                        <div class="col-md-3">
                            <label class="form-label">
                                <i class="fas fa-calendar-day"></i>
                                Filtrar por Día
                            </label>
                            <select id="filterDay" class="form-select">
                                <option value="">Todos los días</option>
                                <option value="1">Lunes</option>
                                <option value="2">Martes</option>
                                <option value="3">Miércoles</option>
                                <option value="4">Jueves</option>
                                <option value="5">Viernes</option>
                                <option value="6">Sábado</option>
                                <option value="7">Domingo</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">
                                <i class="fas fa-graduation-cap"></i>
                                Filtrar por Carrera
                            </label>
                            <select id="filterCarrera" class="form-select">
                                <option value="">Todas las carreras</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">
                                <i class="fas fa-search"></i>
                                Buscar Profesor
                            </label>
                            <input type="text" id="searchProfesor" class="form-control" placeholder="Nombre del profesor...">
                        </div>

                        <div class="col-md-3">
                            <button type="button" id="clearFilters" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>
                                Limpiar Filtros
                            </button>

                             <a href="{{ route('admin.dictadoprofe.index') }}" class="btn btn-primary ms-2">
        <i class="fas fa-eye me-1"></i>
        Ver dictado
    </a>

                        </div>
                    </div>

                    <!-- Filtros Activos -->
                    <div id="activeFilters" class="mt-2"></div>

                    <!-- Estadísticas -->
                    <div class="row g-2 mt-2">
                        <div class="col-6 col-md-3">
                            <div class="stats-card">
                                <p class="stats-number" id="totalClases">0</p>
                                <p class="stats-label">Total Clases</p>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stats-card">
                                <p class="stats-number" id="clasesVisibles">0</p>
                                <p class="stats-label">Mostrando</p>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stats-card">
                                <p class="stats-number" id="profesoresUnicos">0</p>
                                <p class="stats-label">Profesores</p>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stats-card">
                                <p class="stats-number" id="carrerasUnicas">0</p>
                                <p class="stats-label">Carreras</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabla de profesores -->
                <div class="table-container">
                    <table class="table table-hover mb-0" id="profesoresTable">
                        <thead>
                            <tr>
                                <th><i class="fas fa-user-tie me-1"></i>Profesor</th>
                                <th><i class="fas fa-book me-1"></i>Curso</th>
                                <th><i class="fas fa-users me-1"></i>Sección</th>
                                <th><i class="fas fa-graduation-cap me-1"></i>Carrera</th>
                                <th><i class="fas fa-calendar-alt me-1"></i>Día</th>
                                <th><i class="fas fa-clock me-1"></i>Inicio</th>
                                <th><i class="fas fa-clock me-1"></i>Fin</th>
                                <th><i class="fas fa-video me-1"></i>Aula Virtual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $dias = [
                                    1 => 'Lunes', 
                                    2 => 'Martes', 
                                    3 => 'Miércoles', 
                                    4 => 'Jueves', 
                                    5 => 'Viernes', 
                                    6 => 'Sábado', 
                                    7 => 'Domingo'
                                ];
                            @endphp
                            @foreach($profesores as $p)
                                <tr data-dia="{{ $p->dia_semana }}" data-carrera="{{ $p->carrera }}" data-profesor="{{ strtolower($p->profesor) }}">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle me-2">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <strong>{{ $p->profesor }}</strong>
                                        </div>
                                    </td>
                                    <td>{{ $p->curso }}</td>
                                    <td><span class="section-badge">{{ $p->seccion }}</span></td>
                                    <td>{{ $p->carrera }}</td>
                                    <td>
                                        <span class="day-badge">
                                            {{ $dias[$p->dia_semana] ?? '' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="time-display">
                                            {{ \Carbon\Carbon::parse($p->hora_inicio)->format('H:i') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="time-display">
                                            {{ \Carbon\Carbon::parse($p->hora_fin)->format('H:i') }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($p->url_clase_virtual)
                                            <a href="{{ $p->url_clase_virtual }}" target="_blank" class="virtual-link">
                                                <i class="fas fa-external-link-alt"></i>
                                                Ingresar
                                            </a>
                                        @else
                                            <span class="no-assigned">
                                                <i class="fas fa-times-circle me-1"></i>
                                                No asignado
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('#profesor_id').select2({
                placeholder: 'Buscar y seleccionar profesor...',
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return "No se encontraron resultados";
                    },
                    searching: function() {
                        return "Buscando...";
                    }
                }
            });

            // Populate filter options
            const carreras = new Set();
            $('#profesoresTable tbody tr').each(function() {
                carreras.add($(this).data('carrera'));
            });

            carreras.forEach(carrera => {
                $('#filterCarrera').append(`<option value="${carrera}">${carrera}</option>`);
            });

            // Filter functionality
            function applyFilters() {
                const dayFilter = $('#filterDay').val();
                const carreraFilter = $('#filterCarrera').val();
                const searchFilter = $('#searchProfesor').val().toLowerCase();

                let visibleCount = 0;
                const profesoresVisibles = new Set();

                $('#profesoresTable tbody tr').each(function() {
                    const row = $(this);
                    const dia = row.data('dia').toString();
                    const carrera = row.data('carrera');
                    const profesor = row.data('profesor');

                    let show = true;

                    if (dayFilter && dia !== dayFilter) show = false;
                    if (carreraFilter && carrera !== carreraFilter) show = false;
                    if (searchFilter && !profesor.includes(searchFilter)) show = false;

                    if (show) {
                        row.removeClass('hidden-row');
                        visibleCount++;
                        profesoresVisibles.add(profesor);
                    } else {
                        row.addClass('hidden-row');
                    }
                });

                updateStats(visibleCount, profesoresVisibles.size);
                updateActiveFilters();
            }

            function updateStats(visible, profesores) {
                const total = $('#profesoresTable tbody tr').length;
                const totalProfesores = new Set();
                const totalCarreras = new Set();

                $('#profesoresTable tbody tr').each(function() {
                    totalProfesores.add($(this).data('profesor'));
                    totalCarreras.add($(this).data('carrera'));
                });

                $('#totalClases').text(total);
                $('#clasesVisibles').text(visible);
                $('#profesoresUnicos').text(profesores || totalProfesores.size);
                $('#carrerasUnicas').text(totalCarreras.size);
            }

            function updateActiveFilters() {
                const activeFilters = $('#activeFilters');
                activeFilters.empty();

                const dayFilter = $('#filterDay').val();
                const carreraFilter = $('#filterCarrera').val();
                const searchFilter = $('#searchProfesor').val();

                if (dayFilter) {
                    const dayText = $('#filterDay option:selected').text();
                    activeFilters.append(`
                        <span class="filter-badge">
                            Día: ${dayText}
                            <i class="fas fa-times remove-filter" data-filter="day"></i>
                        </span>
                    `);
                }

                if (carreraFilter) {
                    activeFilters.append(`
                        <span class="filter-badge">
                            Carrera: ${carreraFilter}
                            <i class="fas fa-times remove-filter" data-filter="carrera"></i>
                        </span>
                    `);
                }

                if (searchFilter) {
                    activeFilters.append(`
                        <span class="filter-badge">
                            Búsqueda: ${searchFilter}
                            <i class="fas fa-times remove-filter" data-filter="search"></i>
                        </span>
                    `);
                }
            }

            // Event listeners
            $('#filterDay, #filterCarrera').change(applyFilters);
            $('#searchProfesor').on('input', applyFilters);

            $('#clearFilters').click(function() {
                $('#filterDay, #filterCarrera').val('');
                $('#searchProfesor').val('');
                applyFilters();
            });

            $(document).on('click', '.remove-filter', function() {
                const filterType = $(this).data('filter');
                switch(filterType) {
                    case 'day':
                        $('#filterDay').val('');
                        break;
                    case 'carrera':
                        $('#filterCarrera').val('');
                        break;
                    case 'search':
                        $('#searchProfesor').val('');
                        break;
                }
                applyFilters();
            });

            // Form submission
            $('#evaluationForm').on('submit', function() {
                const submitBtn = $('#submitBtn');
                submitBtn.prop('disabled', true);
                submitBtn.html('<i class="fas fa-spinner fa-spin me-1"></i>Guardando...');
            });

            // Initialize stats
            updateStats($('#profesoresTable tbody tr').length, 0);

            // Auto-dismiss alerts
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        });
    </script>

    <style>
        .avatar-circle {
            width: 28px;
            height: 28px;
            background: var(--primary-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.7rem;
        }
    </style>





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




    




    
