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
                        <a class="nav-link " href="{{ route('admin.dashboard') }}" data-page="general">
                            <i class="fas fa-home"></i>
                            <span class="nav-text">Inicio</span>
                            <div class="tooltip-custom">Inicio</div>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link "  href="{{ route('admin.usuarios.create') }}" data-page="perfil">
                            <i class="fas fa-user"></i>
                            <span class="nav-text">Usuarios y Roles</span>
                            <div class="tooltip-custom">Usuarios y Roles</div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active"    href="{{ route('admin.cursos.create') }}" data-page="cursos">
                            <i class="fas fa-book"></i>
                            <span class="nav-text">Crear Curso</span>
                            <div class="tooltip-custom">Crear Curso</div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"  href="{{ route('admin.matricula.create') }}" data-page="calificaciones">
                            <i class="fas fa-chart-line"></i>
                            <span class="nav-text">Matricula</span>
                            <div class="tooltip-custom">Matricula</div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('admin.calificaciones.index') }}" data-page="calendario">
                            <i class="fas fa-chart-line"></i>
                            <span class="nav-text">Calificaciones</span>
                            <div class="tooltip-custom">Calificaciones</div>
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
            
{{-- CSS de Select2 --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



@if (session('success'))
    <div class="alert alert-success">
        <ul>
            @foreach (session('success') as $msg)
                <li>{{ $msg }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('warning'))
    <div class="alert alert-warning">
        <ul>
            @foreach (session('warning') as $msg)
                <li>{{ $msg }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<form action="{{ route('admin.cursos.store') }}" method="POST">
    @csrf

<h3>Facultad</h3>
<select class="facultad-select" name="facultad_nombre" style="width: 100%;">
    <option value="">-- Escribe o selecciona una facultad --</option>
    @foreach($facultades as $facultad)
        <option value="{{ $facultad->nombre }}">{{ $facultad->nombre }}</option>
    @endforeach
</select>

<h3>Carrera</h3>
<select class="carrera-select" name="carrera_nombre" style="width: 100%;">
    <option value="">-- Escribe o selecciona una carrera --</option>
    {{-- Se llenará dinámicamente --}}
</select>

<script>
$(document).ready(function () {

 
    $('.curso-select').select2({
    tags: true,
    placeholder: 'Escribe o selecciona un curso',
    allowClear: true
});



    $('.carrera-select').on('change', function () {
    const carreraNombre = $(this).val();
    const $cursoSelect = $('#cursos-container .curso').first().find('.curso-select');

    $cursoSelect.empty().append('<option value="">-- Escribe o selecciona un curso --</option>');

    if (carreraNombre) {
        fetch(`/admin/cursos-por-nombre-carrera/${carreraNombre}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(curso => {
                    const option = new Option(curso.nombre, curso.nombre, false, false);
                    $cursoSelect.append(option);
                });
                $cursoSelect.val(null).trigger('change');
            });
    }
});

    // Inicializa Select2 con opción de ingresar nuevo texto
    $('.facultad-select').select2({
        tags: true,
        placeholder: 'Escribe o selecciona una facultad',
        allowClear: true
    });

    $('.carrera-select').select2({
        tags: true,
        placeholder: 'Escribe o selecciona una carrera',
        allowClear: true
    });

    
    
    // Al cambiar la facultad, cargar las carreras relacionadas
    $('.facultad-select').on('change', function () {
        const facultadNombre = $(this).val();
        const $carreraSelect = $('.carrera-select');

        // Limpiar carreras anteriores
        $carreraSelect.empty().append('<option value="">-- Escribe o selecciona una carrera --</option>');

        if (facultadNombre) {
            fetch(`/admin/carreras-por-nombre-facultad/${facultadNombre}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(carrera => {
                        const option = new Option(carrera.nombre, carrera.nombre, false, false);
                        $carreraSelect.append(option);
                    });
                });
        }
        

        $carreraSelect.val(null).trigger('change'); // Reiniciar selección
    });
});
</script>


<h3>Periodo académico</h3>
    <select name="periodo_id" required>
        <option value="">-- Selecciona un periodo --</option>
        @foreach ($periodos as $periodo)
            <option value="{{ $periodo->id }}">{{ $periodo->nombre }} ({{ $periodo->fecha_inicio }} al {{ $periodo->fecha_fin }})</option>
        @endforeach
    </select>

<h3>Cursos</h3>
<div id="cursos-container">
    <div class="curso">
        <select class="curso-select" name="cursos[0][nombre]" required style="width: 100%;">
    <option value="">-- Escribe o selecciona un curso --</option>
    {{-- antes tenía todos los cursos, ahora debe estar vacío --}}
</select>


            <textarea name="cursos[0][descripcion]" placeholder="Descripción del curso"></textarea>

            {{-- PROFESOR DEL CURSO (solo uno) --}}
            <label>Profesor:</label>
            <select class="profesor-select" name="cursos[0][profesor_id]" required style="width: 100%;">
    <option value="">-- Selecciona un profesor --</option>
    @foreach ($profesores as $profesor)
        <option value="{{ $profesor->id }}">{{ $profesor->name }}</option>
    @endforeach
</select>
<script>
    $('.profesor-select').select2({
    placeholder: 'Selecciona un profesor',
    allowClear: true
});
</script>

            <label>Turno:</label>
<select name="cursos[0][turno]" required>
    <option value="">-- Selecciona un turno --</option>
    <option value="mañana">Mañana</option>
    <option value="tarde">Tarde</option>
    <option value="noche">Noche</option>
</select>

            <h4>Sección</h4>
<input type="text" name="cursos[0][seccion]" required placeholder="Ej: A">

<h4>Vacantes</h4>
<input type="number" name="cursos[0][vacantes]" required min="1">

<h4>Fechas de matrícula</h4>
<input type="date" name="cursos[0][fecha_apertura_matricula]" required>
<input type="date" name="cursos[0][fecha_cierre_matricula]" required>

<h4>Fechas de clases</h4>
<input type="date" name="cursos[0][fecha_inicio_clases]" required>
<input type="date" name="cursos[0][fecha_fin_clases]" required>


            <h4>Horarios</h4>
            <div class="horarios-container">
                <div class="horario">
                    <select name="cursos[0][horarios][0][dia_semana]">
                        <option value="1">Lunes</option>
                        <option value="2">Martes</option>
                        <option value="3">Miércoles</option>
                        <option value="4">Jueves</option>
                        <option value="5">Viernes</option>
                        <option value="6">Sábado</option>
                        <option value="7">Domingo</option>
                    </select>
                    <input type="time" name="cursos[0][horarios][0][hora_inicio]" required>
                    <input type="time" name="cursos[0][horarios][0][hora_fin]" required>
                </div>
            </div>

            <button type="button" onclick="agregarHorario(this)">+ Agregar horario</button>
        </div>
    </div>

    <button type="button" onclick="agregarCurso()">+ Agregar curso</button>
    <br><br>
    <button type="submit">Guardar todo</button>
</form>

{{-- Variables JS generadas desde Blade --}}
<script>
    const diasSemanaOptions = `
        <option value="1">Lunes</option>
        <option value="2">Martes</option>
        <option value="3">Miércoles</option>
        <option value="4">Jueves</option>
        <option value="5">Viernes</option>
        <option value="6">Sábado</option>
        <option value="7">Domingo</option>
    `;

    const profesoresOptions = `
        @foreach ($profesores as $profesor)
            <option value="{{ $profesor->id }}">{{ $profesor->name }}</option>
        @endforeach
    `;
</script>

<script>
let cursoIndex = 1;

function agregarCurso() {
    const container = document.getElementById('cursos-container');

    const cursoHtml = `
        <div class="curso">
            <label>Curso:</label>
            <select class="curso-select" name="cursos[${cursoIndex}][nombre]" required style="width: 100%;">
    <option value="">-- Escribe o selecciona un curso --</option>
</select>

            <textarea name="cursos[${cursoIndex}][descripcion]" placeholder="Descripción del curso"></textarea>

            <label>Profesor:</label>
            <select class="profesor-select" name="cursos[${cursoIndex}][profesor_id]" required style="width: 100%;">
                <option value="">-- Selecciona un profesor --</option>
                ${profesoresOptions}
            </select>

            <label>Turno:</label>
            <select name="cursos[${cursoIndex}][turno]" required>
                <option value="">-- Selecciona un turno --</option>
                <option value="mañana">Mañana</option>
                <option value="tarde">Tarde</option>
                <option value="noche">Noche</option>
            </select>

            <h4>Sección</h4>
            <input type="text" name="cursos[${cursoIndex}][seccion]" required placeholder="Ej: A">

            <h4>Vacantes</h4>
            <input type="number" name="cursos[${cursoIndex}][vacantes]" required min="1">

            <h4>Fechas de matrícula</h4>
            <input type="date" name="cursos[${cursoIndex}][fecha_apertura_matricula]" required>
            <input type="date" name="cursos[${cursoIndex}][fecha_cierre_matricula]" required>

            <h4>Fechas de clases</h4>
            <input type="date" name="cursos[${cursoIndex}][fecha_inicio_clases]" required>
            <input type="date" name="cursos[${cursoIndex}][fecha_fin_clases]" required>

            <h4>Horarios</h4>
            <div class="horarios-container">
                <div class="horario">
                    <select name="cursos[${cursoIndex}][horarios][0][dia_semana]">
                        ${diasSemanaOptions}
                    </select>
                    <input type="time" name="cursos[${cursoIndex}][horarios][0][hora_inicio]" required>
                    <input type="time" name="cursos[${cursoIndex}][horarios][0][hora_fin]" required>
                </div>
            </div>

            <button type="button" onclick="agregarHorario(this)">+ Agregar horario</button>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', cursoHtml);

    const carreraNombre = $('.carrera-select').val();

// Llenar cursos solo si hay carrera seleccionada
if (carreraNombre) {
    const $nuevoCursoSelect = $('#cursos-container .curso').last().find('.curso-select');

    fetch(`/admin/cursos-por-nombre-carrera/${carreraNombre}`)
        .then(response => response.json())
        .then(data => {
            $nuevoCursoSelect.empty().append('<option value="">-- Escribe o selecciona un curso --</option>');
            data.forEach(curso => {
                const option = new Option(curso.nombre, curso.nombre, false, false);
                $nuevoCursoSelect.append(option);
            });
            $nuevoCursoSelect.val(null).trigger('change');
        });
}

    // Inicializa Select2 para los nuevos selects añadidos
    $('.curso-select').last().select2({
        tags: true,
        placeholder: 'Escribe o selecciona un curso',
        allowClear: true
    });

    $('.profesor-select').last().select2({
        placeholder: 'Selecciona un profesor',
        allowClear: true
    });

    cursoIndex++;
}

function agregarHorario(button) {
    const cursoDiv = button.closest('.curso');
    const horariosContainer = cursoDiv.querySelector('.horarios-container');
    const indexCurso = Array.from(document.querySelectorAll('.curso')).indexOf(cursoDiv);
    const indexHorario = horariosContainer.querySelectorAll('.horario').length;

    const horarioHtml = `
        <div class="horario">
            <select name="cursos[${indexCurso}][horarios][${indexHorario}][dia_semana]">
                ${diasSemanaOptions}
            </select>
            <input type="time" name="cursos[${indexCurso}][horarios][${indexHorario}][hora_inicio]" required>
            <input type="time" name="cursos[${indexCurso}][horarios][${indexHorario}][hora_fin]" required>
        </div>
    `;
    horariosContainer.insertAdjacentHTML('beforeend', horarioHtml);
}
</script>

<hr>
<h2>📋 Cursos ya creados</h2>

@if ($cursos->isEmpty())
    <p>No hay cursos registrados aún.</p>
@else
    @php
        $agrupadoPorFacultad = $cursos->groupBy(function($curso) {
            return $curso->carrera->facultad->nombre;
        });
    @endphp

    @foreach ($agrupadoPorFacultad as $nombreFacultad => $cursosFacultad)
        <h3 style="margin-top: 30px; color: navy;">🎓 Facultad: {{ $nombreFacultad }}</h3>

        @php
            $agrupadoPorCarrera = $cursosFacultad->groupBy(function($curso) {
                return $curso->carrera->nombre;
            });
        @endphp

        @foreach ($agrupadoPorCarrera as $nombreCarrera => $cursosCarrera)
            <h4 style="margin-left: 20px; color: teal;">📚 Carrera: {{ $nombreCarrera }}</h4>

            @foreach ($cursosCarrera as $curso)
                @foreach ($curso->cursoPeriodos as $cursoPeriodo)
                    <div style="margin: 10px 40px 20px; border: 1px solid #ccc; padding: 10px; border-radius: 8px;">
                        <h5>📘 Curso: {{ $curso->nombre }} - Sección {{ $cursoPeriodo->seccion }}</h5>
                        <p><strong>Turno:</strong> {{ ucfirst($cursoPeriodo->turno) }}</p>
                        <form action="{{ route('admin.cursos.destroy', $curso->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Estás seguro de eliminar este curso?')" class="btn btn-danger btn-sm">
                                ❌ Eliminar curso
                            </button>
                        </form>

                        <p><strong>Descripción:</strong> {{ $curso->descripcion ?? 'Sin descripción' }}</p>
                        <p><strong>Periodo:</strong> {{ $cursoPeriodo->periodo->nombre }}</p>
                        <p><strong>Vacantes:</strong> {{ $cursoPeriodo->vacantes }}</p>
                        <p><strong>Fechas de matrícula:</strong> {{ $cursoPeriodo->fecha_apertura_matricula }} al {{ $cursoPeriodo->fecha_cierre_matricula }}</p>
                        <p><strong>Fechas de clases:</strong> {{ $cursoPeriodo->fecha_inicio_clases }} al {{ $cursoPeriodo->fecha_fin_clases }}</p>

                        <p><strong>Horarios:</strong></p>
                        <ul>
                            @forelse ($cursoPeriodo->horarios as $horario)
                                <li>
                                    Profesor: {{ $horario->profesor->name ?? 'No asignado' }} |
                                    Día: {{ ['Lun','Mar','Mié','Jue','Vie','Sáb','Dom'][$horario->dia_semana - 1] }} |
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $horario->hora_inicio)->format('H:i') }}
                                    -
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $horario->hora_fin)->format('H:i') }}
                                </li>
                            @empty
                                <li>No hay horarios asignados</li>
                            @endforelse
                        </ul>
                    </div>
                @endforeach
            @endforeach
        @endforeach
    @endforeach
@endif



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


