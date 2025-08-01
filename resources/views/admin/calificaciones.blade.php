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
            /* MODIFICADO: Permite el scroll vertical */
            height: 100vh; /* Asegura que tenga una altura definida */
            overflow-y: auto; /* Habilita el scroll vertical */
            overflow-x: hidden; /* Evita scroll horizontal no deseado */
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
            flex-shrink: 0; /* Evita que se encoja si el contenido es muy largo */
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
            flex-grow: 1; /* Permite que la navegación ocupe el espacio restante */
        }
        .nav-item {
            margin-bottom: 5px;
            --bs-nav-link-hover-color: #ffffffff !important; /* Color blanco fuerte */
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
        /* MODIFICADO: Permite que el texto se envuelva */
        .nav-text {
            transition: all 0.3s ease;
            flex-grow: 1; /* Permite que el texto ocupe el espacio disponible */
            word-wrap: break-word; /* Rompe palabras largas */
            overflow-wrap: break-word; /* Alternativa moderna */
        }
        .sidebar-collapsed .nav-text {
            opacity: 0;
            width: 0;
            margin: 0;
            white-space: nowrap; /* Mantiene nowrap cuando está colapsado para la transición */
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
        .sidebar-collapsed .nav-link:hover .tooltip-custom,
        .sidebar-collapsed .nav-group-toggle:hover .tooltip-custom { /* Added for group toggles */
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
            flex-shrink: 0; /* Evita que se encoja */
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
            /* Hereda estilos de .nav-link */
        }
        /* NUEVO: Estilo para el toggle de grupo cuando está expandido */
        .nav-group-toggle[aria-expanded="true"] {
            background-color: rgba(255,255,255,0.1); /* Un azul más sutil */
            color: white;
            font-weight: 500; /* Menos negrita que el activo principal */
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .nav-group-icon {
            transition: transform 0.3s ease;
            margin-left: auto; /* Empuja el icono a la derecha */
        }
        .nav-group-toggle[aria-expanded="true"] .nav-group-icon {
            transform: rotate(180deg);
        }
        .nav-submenu {
            padding-left: 20px; /* Indentación para el primer nivel de submenú */
        }
        .nav-submenu-level-2 {
            padding-left: 15px; /* Indentación adicional para submenús anidados */
        }

        /* Ajustes para sidebar colapsado (modo icono) */
        .sidebar-collapsed .nav-group-toggle {
            justify-content: center; /* Centra el icono */
            padding: 15px 10px;
            margin-right: 5px;
        }
        .sidebar-collapsed .nav-group-toggle .nav-text {
            opacity: 0;
            width: 0;
            margin: 0;
            white-space: nowrap; /* Mantiene nowrap cuando está colapsado para la transición */
        }
        .sidebar-collapsed .nav-group-toggle .nav-group-icon {
            opacity: 0; /* Oculta el chevron cuando el sidebar está en modo icono */
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
                /* MODIFICADO: Asegura que el scroll funcione en móvil */
                height: 100vh;
                overflow-y: auto;
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
                white-space: normal !important; /* Asegura que el texto se envuelva en móvil */
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
                opacity: 1 !important; /* Show chevron on mobile */
                width: auto !important;
                margin-left: auto !important; /* Push to the right */
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
    <a class="nav-link active nav-group-toggle" href="#notasSubmenu" data-bs-toggle="collapse" aria-expanded="false" aria-controls="notasSubmenu">
        <i class="fas fa-file-alt"></i> <!-- Icono cambiado -->
        <span class="nav-text">Notas y Evaluaciones</span>
        <i class="fas fa-chevron-down nav-group-icon"></i>
        <div class="tooltip-custom">Notas y Evaluaciones</div>
    </a>
    <div class="collapse" id="notasSubmenu">
        <ul class="nav flex-column nav-submenu">

            <li class="nav-item">
                <a class="nav-link active" href="{{ route('admin.calificaciones.index') }}">
                    <i class="fas fa-pencil-alt"></i> <!-- Icono para calificar -->
                    <span class="nav-text">Reporte Calificaciones</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.notas_y_asistencias') }}">
                    <i class="fas fa-clipboard-list"></i> <!-- Icono para notas y asistencias -->
                    <span class="nav-text">Ver notas y asistencias</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.librerarnotas.index') }}">
                    <i class="fas fa-unlock"></i> <!-- Icono para liberar notas -->
                    <span class="nav-text">Liberar notas</span>
                </a>
            </li>

        </ul>
    </div>
</li>   


<!-- Menú: Comunicación -->
<li class="nav-item nav-group">
    <a class="nav-link nav-group-toggle" href="#comunicacionSubmenu" data-bs-toggle="collapse" aria-expanded="false" aria-controls="comunicacionSubmenu">
        <i class="fas fa-comments"></i> <!-- Icono actualizado para Comunicación -->
        <span class="nav-text">Comunicación</span>
        <i class="fas fa-chevron-down nav-group-icon"></i>
        <div class="tooltip-custom">Comunicación</div>
    </a>
    <div class="collapse" id="comunicacionSubmenu">
        <ul class="nav flex-column nav-submenu">

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.mensajes.crear') }}">
                    <i class="fas fa-envelope"></i> <!-- Icono actualizado para Enviar mensajes -->
                    <span class="nav-text">Enviar mensajes</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.clasesurl.index') }}">
                    <i class="fas fa-video"></i> <!-- Icono actualizado para links de clases virtuales -->
                    <span class="nav-text">Ingresar links de clases virtuales</span>
                </a>
            </li>

        </ul>
    </div>
</li>

<!-- Menú: Pagos -->
<li class="nav-item nav-group">
    <a class="nav-link nav-group-toggle" href="#pagosSubmenu" data-bs-toggle="collapse" aria-expanded="false" aria-controls="pagosSubmenu">
        <i class="fas fa-money-bill-wave"></i> <!-- Icono actualizado para Pagos -->
        <span class="nav-text">Pagos</span>
        <i class="fas fa-chevron-down nav-group-icon"></i>
        <div class="tooltip-custom">Pagos</div>
    </a>
    <div class="collapse" id="pagosSubmenu">
        <ul class="nav flex-column nav-submenu">

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.pagos') }}">
                    <i class="fas fa-receipt"></i> <!-- Icono actualizado para gestionar pagos -->
                    <span class="nav-text">Gestión de pagos</span>
                </a>
            </li>

        </ul>
    </div>
</li>





                    <!-- Grupo Colapsable Principal: Gestión Académica -->
                   
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
   <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
</a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            
  
            <!-- Content -->
            <div class="content-area">
<style>
  
    .main-container {
        padding: 0 2rem 3rem 2rem; /* Sin padding-top */
        max-width: 1400px;
        margin: 0 auto;
    }
    
    .gradient-header {
        background: linear-gradient(120deg, #0249BB 0%, #003bb1 100%);
        color: white;
        border-radius: 0 0 20px 20px; /* Solo bordes inferiores redondeados */
        padding: 2rem 2.5rem 3rem 2.5rem;
        margin-bottom: 3rem;
        box-shadow: 0 15px 40px rgba(2, 73, 187, 0.3);
        position: relative;
        overflow: hidden;
        margin-left: -2rem;
        margin-right: -2rem;
    }
    
    .gradient-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: translate(50%, -50%);
    }
    
    .gradient-header h2 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 2;
    }
    
    .gradient-header p {
        font-size: 1.1rem;
        position: relative;
        z-index: 2;
    }
    
    .filter-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        border: none;
        transition: all 0.3s ease;
        margin-bottom: 3rem;
        padding: 1rem;
    }
    
    .filter-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.12);
    }
    
    .filter-card .card-body {
        padding: 2.5rem !important;
    }
    
    .form-select {
        border-radius: 12px;
        border: 2px solid #e9ecef;
        padding: 1rem 1.25rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background-color: #fafbfc;
        min-height: 50px;
    }
    
    .form-select:focus {
        border-color: #0249BB;
        box-shadow: 0 0 0 0.25rem rgba(2, 73, 187, 0.15);
        background-color: white;
    }
    
    .form-select:hover {
        border-color: #0249BB;
        background-color: white;
    }
    
    .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.75rem;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .results-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        border: none;
        overflow: hidden;
        margin-bottom: 2rem;
    }
    
    .results-card .card-header {
        background: linear-gradient(120deg, #0249BB 0%, #003bb1 100%);
        color: white;
        padding: 2rem 2.5rem !important;
        border: none;
    }
    
    .results-card .card-body {
        padding: 0 !important;
    }
    
    /* Tabla con scroll horizontal mejorado */
    .table-container {
        margin: 1.5rem;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0,0,0,0.05);
        position: relative;
    }
    
    .table-responsive {
        max-height: 70vh;
        overflow-x: auto;
        overflow-y: auto;
        border-radius: 15px;
    }
    
    /* Scrollbar personalizado */
    .table-responsive::-webkit-scrollbar {
        height: 12px;
        width: 12px;
    }
    
    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .table-responsive::-webkit-scrollbar-thumb {
        background: linear-gradient(120deg, #0249BB 0%, #003bb1 100%);
        border-radius: 10px;
    }
    
    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(120deg, #003bb1 0%, #0249BB 100%);
    }
    
    .table {
        margin-bottom: 0;
        font-size: 0.95rem;
        min-width: 1200px; /* Ancho mínimo para forzar scroll horizontal */
    }
    
    .table thead th {
        background: linear-gradient(120deg, #0249BB 0%, #003bb1 100%);
        color: white;
        border: none;
        font-weight: 600;
        text-align: center;
        vertical-align: middle;
        padding: 1.25rem 1rem;
        font-size: 0.9rem;
        white-space: nowrap;
        position: sticky;
        top: 0;
        z-index: 10;
    }
    
    .table tbody td {
        vertical-align: middle;
        padding: 1rem 0.75rem;
        border-color: #e9ecef;
        text-align: center;
        font-weight: 500;
        white-space: nowrap;
    }
    
    .table tbody tr {
        transition: all 0.2s ease;
    }
    
    .table tbody tr:hover {
        background: linear-gradient(90deg, rgba(2, 73, 187, 0.05) 0%, rgba(0, 59, 177, 0.05) 100%);
    }
    
    .student-name {
        font-weight: 600;
        color: #2c3e50;
        text-align: left !important;
        padding-left: 1.5rem !important;
        min-width: 200px;
        max-width: 250px;
        white-space: normal !important;
        word-wrap: break-word;
        position: sticky;
        left: 0;
        background: white;
        z-index: 5;
        box-shadow: 2px 0 5px rgba(0,0,0,0.1);
    }
    
    .table tbody tr:hover .student-name {
        background: linear-gradient(90deg, rgba(2, 73, 187, 0.05) 0%, rgba(0, 59, 177, 0.05) 100%);
    }
    
    .grade-cell {
        font-weight: 600;
        color: #495057;
        font-size: 1rem;
        min-width: 80px;
    }
    
    .final-grade {
        background: linear-gradient(120deg, #28a745 0%, #20c997 100%);
        color: white;
        font-weight: 700;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        display: inline-block;
        min-width: 60px;
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    }
    
    .oral-grades {
        min-width: 150px;
    }
    
    .oral-grades .badge {
        margin: 0.125rem;
        padding: 0.4rem 0.6rem;
        font-size: 0.8rem;
        border-radius: 6px;
        background: linear-gradient(120deg, #6c757d 0%, #495057 100%) !important;
        color: white !important;
        font-weight: 500;
        display: inline-block;
    }
    
    .section-title {
        color: #2c3e50;
        font-weight: 700;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 1.25rem;
    }
    
    .section-title.white {
        color: white;
        margin-bottom: 0.5rem;
    }
    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #6c757d;
    }
    
    .empty-state i {
        font-size: 5rem;
        margin-bottom: 1.5rem;
        opacity: 0.3;
        color: #0249BB;
    }
    
    .empty-state h5 {
        font-size: 1.5rem;
        margin-bottom: 1rem;
        color: #2c3e50;
    }
    
    .stats-badge {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.9rem;
        font-weight: 500;
        display: inline-block;
        margin-top: 0.5rem;
    }
    
    .icon-primary { color: #0249BB; }
    .icon-success { color: #28a745; }
    .icon-warning { color: #ffc107; }
    .icon-info { color: #17a2b8; }
    .icon-danger { color: #dc3545; }
    
    /* Indicador de scroll */
    .scroll-indicator {
        position: absolute;
        bottom: 10px;
        right: 20px;
        background: rgba(2, 73, 187, 0.8);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        z-index: 20;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { opacity: 0.7; }
        50% { opacity: 1; }
        100% { opacity: 0.7; }
    }
    
    /* Responsive Design Mejorado */
    @media (max-width: 1200px) {
        .main-container {
            padding: 0 1.5rem 2rem 1.5rem;
        }
        
        .gradient-header {
            margin-left: -1.5rem;
            margin-right: -1.5rem;
            padding: 1.5rem 2rem 2.5rem 2rem;
        }
    }
    
    @media (max-width: 992px) {
        .gradient-header h2 {
            font-size: 2rem;
        }
        
        .filter-card .card-body {
            padding: 2rem !important;
        }
        
        .table-container {
            margin: 1rem;
        }
    }
    
    @media (max-width: 768px) {
        .main-container {
            padding: 0 1rem 1.5rem 1rem;
        }
        
        .gradient-header {
            margin-left: -1rem;
            margin-right: -1rem;
            padding: 1rem 1.5rem 2rem 1.5rem;
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .gradient-header h2 {
            font-size: 1.75rem;
        }
        
        .gradient-header p {
            font-size: 1rem;
        }
        
        .filter-card .card-body {
            padding: 1.5rem !important;
        }
        
        .results-card .card-header {
            padding: 1.5rem !important;
        }
        
        .table-container {
            margin: 0.5rem;
        }
        
        .table {
            font-size: 0.85rem;
        }
        
        .table thead th {
            font-size: 0.8rem;
            padding: 1rem 0.5rem;
        }
        
        .table tbody td {
            padding: 0.75rem 0.5rem;
        }
        
        .student-name {
            min-width: 150px;
            max-width: 180px;
            padding-left: 1rem !important;
        }
        
        .oral-grades .badge {
            font-size: 0.7rem;
            padding: 0.3rem 0.5rem;
            margin: 0.1rem;
        }
        
        .section-title {
            font-size: 1.1rem;
        }
        
        .form-select {
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
        }
        
        .scroll-indicator {
            bottom: 5px;
            right: 10px;
            padding: 0.3rem 0.8rem;
            font-size: 0.7rem;
        }
    }
    
    @media (max-width: 576px) {
        .gradient-header h2 {
            font-size: 1.5rem;
        }
        
        .gradient-header p {
            font-size: 0.9rem;
        }
        
        .filter-card .card-body {
            padding: 1rem !important;
        }
        
        .form-select {
            padding: 0.6rem 0.8rem;
            font-size: 0.85rem;
            min-height: 45px;
        }
        
        .form-label {
            font-size: 0.9rem;
        }
        
        .table {
            font-size: 0.8rem;
        }
        
        .student-name {
            min-width: 120px;
            max-width: 150px;
            font-size: 0.8rem;
        }
        
        .grade-cell {
            font-size: 0.85rem;
        }
        
        .final-grade {
            padding: 0.5rem 0.75rem;
            font-size: 0.85rem;
        }
    }
    
    @media (max-width: 400px) {
        .gradient-header {
            padding: 1rem;
        }
        
        .gradient-header h2 {
            font-size: 1.3rem;
        }
        
        .table-container {
            margin: 0.25rem;
        }
        
        .student-name {
            min-width: 100px;
            max-width: 120px;
        }
    }
</style>


 <div class="main-container">
    <!-- Header -->
    <div class="gradient-header">
        <h2 class="mb-0">
            <i class="fas fa-chart-bar me-3"></i>
            Reporte de Calificaciones
        </h2>
        <p class="mb-0 mt-2 opacity-90">Sistema integral de consulta y análisis de calificaciones académicas</p>
    </div>

    <!-- Filtros -->
    <div class="card filter-card">
        <div class="card-body">
            <h5 class="section-title">
                <i class="fas fa-filter icon-primary"></i>
                Filtros de Búsqueda
            </h5>
            
            <form method="GET" action="{{ route('admin.calificaciones.index') }}">
                <div class="row g-4">
                    <!-- Facultad -->
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <label class="form-label">
                            <i class="fas fa-university icon-primary"></i>
                            Facultad
                        </label>
                        <select name="facultad_id" class="form-select" onchange="this.form.submit()">
                            <option value="">-- Seleccionar Facultad --</option>
                            @foreach($facultades as $fac)
                                <option value="{{ $fac->id }}" {{ $request->facultad_id == $fac->id ? 'selected' : '' }}>
                                    {{ $fac->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Carrera -->
                    @if($carreras->isNotEmpty())
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <label class="form-label">
                            <i class="fas fa-graduation-cap icon-success"></i>
                            Carrera
                        </label>
                        <select name="carrera_id" class="form-select" onchange="this.form.submit()">
                            <option value="">-- Seleccionar Carrera --</option>
                            @foreach($carreras as $carr)
                                <option value="{{ $carr->id }}" {{ $request->carrera_id == $carr->id ? 'selected' : '' }}>
                                    {{ $carr->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <!-- Periodo -->
                    @if($periodos->isNotEmpty() && $request->filled('carrera_id'))
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <label class="form-label">
                            <i class="fas fa-calendar-alt icon-warning"></i>
                            Periodo Académico
                        </label>
                        <select name="periodo_id" class="form-select" onchange="this.form.submit()">
                            <option value="">-- Seleccionar Periodo --</option>
                            @foreach($periodos as $periodo)
                                <option value="{{ $periodo->id }}" {{ $request->periodo_id == $periodo->id ? 'selected' : '' }}>
                                    {{ $periodo->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <!-- Curso -->
                    @if($cursos->isNotEmpty())
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <label class="form-label">
                            <i class="fas fa-book icon-info"></i>
                            Curso y Sección
                        </label>
                        <select name="curso_periodo_id" class="form-select" onchange="this.form.submit()">
                            <option value="">-- Seleccionar Curso --</option>
                            @foreach($cursos as $curso)
                                <option value="{{ $curso->id }}" {{ $request->curso_periodo_id == $curso->id ? 'selected' : '' }}>
                                    {{ $curso->nombre }} (Sección {{ $curso->seccion }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <!-- Profesor -->
                    @if($profesores->isNotEmpty())
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <label class="form-label">
                            <i class="fas fa-chalkboard-teacher icon-danger"></i>
                            Profesor Asignado
                        </label>
                        <select name="profesor_id" class="form-select" onchange="this.form.submit()">
                            <option value="">-- Seleccionar Profesor --</option>
                            @foreach($profesores as $prof)
                                <option value="{{ $prof->id }}" {{ $request->profesor_id == $prof->id ? 'selected' : '' }}>
                                    {{ $prof->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Resultados -->
    @if($calificaciones->isNotEmpty() && $request->filled('profesor_id'))
        <div class="card results-card">
            <div class="card-header">
                <h5 class="section-title white mb-0">
                    <i class="fas fa-user-graduate"></i>
                    Registro de Calificaciones del Curso
                </h5>
                <div class="stats-badge">
                    <i class="fas fa-users me-2"></i>
                    Total de estudiantes: {{ $calificaciones->count() }}
                </div>
            </div>
            
            <div class="card-body">
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="student-name">
                                        <i class="fas fa-user me-2"></i>
                                        Estudiante
                                    </th>
                                    <th>
                                        <i class="fas fa-clipboard-check me-1"></i>
                                        1er Avance
                                    </th>
                                    <th>
                                        <i class="fas fa-clipboard-check me-1"></i>
                                        2do Avance
                                    </th>
                                    <th>
                                        <i class="fas fa-presentation me-1"></i>
                                        Presentación Final
                                    </th>
                                    <th>
                                        <i class="fas fa-calculator me-1"></i>
                                        Prom. Avance
                                    </th>
                                    <th>
                                        <i class="fas fa-microphone me-1"></i>
                                        Evaluaciones Orales
                                    </th>
                                    <th>
                                        <i class="fas fa-chart-line me-1"></i>
                                        Promedio
                                    </th>
                                    <th>
                                        <i class="fas fa-tasks me-1"></i>
                                        Eval. Permanente
                                    </th>
                                    <th>
                                        <i class="fas fa-file-alt me-1"></i>
                                        Examen Final
                                    </th>
                                    <th>
                                        <i class="fas fa-trophy me-1"></i>
                                        Promedio Final
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($calificaciones as $cal)
                                    <tr>
                                        <td class="student-name">
                                            <i class="fas fa-user-circle me-2 icon-primary"></i>
                                            {{ $cal->alumno }}
                                        </td>
                                        <td class="grade-cell">{{ $cal->primer_avance ?: '-' }}</td>
                                        <td class="grade-cell">{{ $cal->segundo_avance ?: '-' }}</td>
                                        <td class="grade-cell">{{ $cal->presentacion_final ?: '-' }}</td>
                                        <td class="grade-cell">{{ $cal->promedio_avance ?: '-' }}</td>
                                        <td class="oral-grades">
                                            <div class="d-flex flex-wrap gap-1 justify-content-center">
                                                <span class="badge">{{ $cal->oral_1 ?: '-' }}</span>
                                                <span class="badge">{{ $cal->oral_2 ?: '-' }}</span>
                                                <span class="badge">{{ $cal->oral_3 ?: '-' }}</span>
                                                <span class="badge">{{ $cal->oral_4 ?: '-' }}</span>
                                                <span class="badge">{{ $cal->oral_5 ?: '-' }}</span>
                                            </div>
                                        </td>
                                        <td class="grade-cell">{{ $cal->promedio ?: '-' }}</td>
                                        <td class="grade-cell">{{ $cal->promedio_evaluacion_permanente ?: '-' }}</td>
                                        <td class="grade-cell">{{ $cal->examen_final ?: '-' }}</td>
                                        <td>
                                            <div class="final-grade">
                                                <i class="fas fa-star me-1"></i>
                                                {{ $cal->promedio_final ?: '-' }}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="scroll-indicator">
                        <i class="fas fa-arrows-alt-h me-1"></i>
                        Desliza para ver más
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card results-card">
            <div class="card-body">
                <div class="empty-state">
                    <i class="fas fa-search-plus"></i>
                    <h5>No hay calificaciones disponibles</h5>
                    <p class="text-muted">Completa todos los filtros necesarios para visualizar las calificaciones del curso seleccionado.</p>
                </div>
            </div>
        </div>
    @endif
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
            const navLinks = document.querySelectorAll('.nav-link'); // Selecciona todos los enlaces de navegación

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
                        // Si es un toggle de submenú en móvil, previene el comportamiento por defecto
                        // y detiene la propagación para que no cierre el sidebar principal.
                        e.preventDefault();
                        e.stopPropagation();
                        return; // No hagas nada más para este clic
                    }

                    // Para enlaces de navegación normales (no toggles) o toggles en escritorio:
                    // Si es un enlace que tiene un href real (no solo un #)
                    if (this.href && !this.href.includes('#')) {
                        // Deja que el navegador maneje la navegación
                        return;
                    }
                    e.preventDefault(); // Previene el comportamiento por defecto para enlaces con #

                    // Actualiza el estado activo solo para enlaces que NO son toggles de submenú
                    if (!isSubmenuToggle) {
                        navLinks.forEach(l => l.classList.remove('active'));
                        this.classList.add('active');
                    }

                    // Cierra el sidebar móvil si es un enlace de navegación normal
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
                    e.stopPropagation(); // Evita que el clic se propague y cierre otros elementos
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