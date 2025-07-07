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
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* Sidebar Styles */
        .sidebar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            min-height: 100vh;
            position: relative;
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
            border-bottom: 1px solid rgba(255,255,255,0.1);
            position: relative;
        }

        .sidebar-header h4 {
            color: white;
            margin: 0;
            font-weight: 600;
            transition: opacity 0.3s ease;
        }

        .sidebar-collapsed .sidebar-header h4 {
            opacity: 0;
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
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 0 25px 25px 0;
            margin-right: 10px;
            position: relative;
        }

        .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
            color: white;
            transform: translateX(5px);
        }

        .nav-link.active {
            background-color: rgba(255,255,255,0.2);
            color: white;
            font-weight: 600;
        }

        .nav-link i {
            font-size: 18px;
            width: 20px;
            text-align: center;
            margin-right: 15px;
        }

        .nav-text {
            transition: opacity 0.3s ease;
        }

        .sidebar-collapsed .nav-text {
            opacity: 0;
            width: 0;
        }

        .sidebar-collapsed .nav-link {
            justify-content: center;
            padding: 12px 10px;
        }

        .sidebar-collapsed .nav-link i {
            margin-right: 0;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            width: 100%;
        }

        .top-navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 20px;
            flex-shrink: 0;
            width: 100%;
        }

        .content-area {
            flex: 1;
            padding: 20px;
            width: 100%;
            overflow-y: auto;
        }

        .toggle-btn {
            background: none;
            border: none;
            font-size: 18px;
            color: #667eea;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 8px;
            border-radius: 4px;
        }

        .toggle-btn:hover {
            color: #764ba2;
            background-color: rgba(102, 126, 234, 0.1);
        }

        .user-info {
            display: flex;
            align-items: center;
            margin-left: auto;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            margin-right: 10px;
        }

        /* Tooltip para menú colapsado */
        .tooltip-custom {
            position: absolute;
            left: 70px;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0,0,0,0.8);
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1001;
        }

        .sidebar-collapsed .nav-link:hover .tooltip-custom {
            opacity: 1;
            visibility: visible;
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
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: center;
            width: 100%;
            max-width: 100%;
        }

        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .app-container {
                position: relative;
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

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .sidebar-close-btn {
                display: flex !important;
            }

            .main-content {
                width: 100% !important;
                flex: 1 !important;
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
        }

        /* Animaciones mejoradas */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Mejoras en dropdown */
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        .dropdown-item {
            padding: 10px 15px;
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
        }
    </style>

</head>
<body>
    <!-- Overlay para móvil -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <div class="app-container">
        <!-- Sidebar -->
        <div class="sidebar sidebar-expanded" id="sidebar">
            <div class="sidebar-header">
                <h4>Portal Estudiante</h4>
                <button class="sidebar-close-btn" id="sidebarClose">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <nav class="sidebar-nav">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="" data-page="general">
                            <i class="fas fa-home"></i>
                            <span class="nav-text">General</span>
                            <div class="tooltip-custom">General</div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="" data-page="perfil">
                            <i class="fas fa-user"></i>
                            <span class="nav-text">Perfil</span>
                            <div class="tooltip-custom">Perfil</div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="" data-page="cursos">
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
                        <a class="nav-link" href="" data-page="calendario">
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
                            <a class="dropdown-toggle text-decoration-none text-dark" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Bienvenido, {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="">
                                        <i class="fas fa-user me-2"></i>Mi Perfil
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="">
                                        <i class="fas fa-cog me-2"></i>Configuración
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}" 
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Content -->
            <div class="content-area">
               <div class="welcome-card">
    <h2 class="text-primary mb-3">¡Bienvenido a tu Portal Estudiantil!</h2>
    <p class="lead text-muted">Accede a todas las herramientas y recursos que necesitas para tu éxito académico.</p>
    
    <div class="row mt-4">
        <div class="col-md-4 mb-3">
            <div class="text-center p-3">
                <i class="fas fa-graduation-cap fa-3x text-primary mb-2"></i>
                <h5>Cursos Activos</h5>
                <p class="text-muted">Gestiona tus materias</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="text-center p-3">
                <i class="fas fa-trophy fa-3x text-success mb-2"></i>
                <h5>Calificaciones</h5>
                <p class="text-muted">Revisa tu progreso</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="text-center p-3">
                <i class="fas fa-calendar-check fa-3x text-info mb-2"></i>
                <h5>Calendario</h5>
                <p class="text-muted">Organiza tu tiempo</p>
            </div>
        </div>
    </div>
</div>

<!-- Estadísticas Académicas -->
<div class="row mt-4">
    <div class="col-12">
        <div class="stat-card">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Estadísticas Académicas</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="bg-primary text-white rounded p-3 text-center">
                            <h3 class="mb-1">8</h3>
                            <p class="mb-0 small">Cursos Activos</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="bg-success text-white rounded p-3 text-center">
                            <h3 class="mb-1">92%</h3>
                            <p class="mb-0 small">Promedio General</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="bg-info text-white rounded p-3 text-center">
                            <h3 class="mb-1">15</h3>
                            <p class="mb-0 small">Tareas Pendientes</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="bg-warning text-white rounded p-3 text-center">
                            <h3 class="mb-1">3</h3>
                            <p class="mb-0 small">Próximos Exámenes</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Actividad Reciente -->
<div class="row mt-4">
    <div class="col-md-8">
        <div class="stat-card">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Actividad Reciente</h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item border-0 px-0">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary rounded-circle p-2 me-3">
                                <i class="fas fa-book text-white"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Nueva tarea asignada</h6>
                                <p class="mb-0 text-muted small">Matemáticas Avanzadas - Hace 2 horas</p>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item border-0 px-0">
                        <div class="d-flex align-items-center">
                            <div class="bg-success rounded-circle p-2 me-3">
                                <i class="fas fa-check text-white"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Calificación publicada</h6>
                                <p class="mb-0 text-muted small">Historia Universal - Hace 1 día</p>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item border-0 px-0">
                        <div class="d-flex align-items-center">
                            <div class="bg-info rounded-circle p-2 me-3">
                                <i class="fas fa-calendar text-white"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Recordatorio de examen</h6>
                                <p class="mb-0 text-muted small">Física Cuántica - Mañana 10:00 AM</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="stat-card">
            <div class="card-header bg-transparent border-0">
                <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Próximos Eventos</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-danger text-white rounded p-2 me-3">
                        <small>15</small><br>
                        <small>ENE</small>
                    </div>
                    <div>
                        <h6 class="mb-0">Examen Final</h6>
                        <small class="text-muted">Cálculo Diferencial</small>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-warning text-white rounded p-2 me-3">
                        <small>18</small><br>
                        <small>ENE</small>
                    </div>
                    <div>
                        <h6 class="mb-0">Entrega de Proyecto</h6>
                        <small class="text-muted">Programación Web</small>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="bg-info text-white rounded p-2 me-3">
                        <small>22</small><br>
                        <small>ENE</small>
                    </div>
                    <div>
                        <h6 class="mb-0">Presentación</h6>
                        <small class="text-muted">Metodología</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

            </div>
        </div>
    </div>

    <!-- Formulario de logout -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

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
        });
    </script>
    @stack('scripts')
</body>
</html>
