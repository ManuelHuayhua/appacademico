<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dictado de Profesores</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(120deg, #0249BB 0%, #003bb1 100%);
            --primary-color: #0249BB;
            --primary-dark: #003bb1;
            --shadow-light: rgba(2, 73, 187, 0.1);
            --shadow-medium: rgba(2, 73, 187, 0.2);
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e8f4f8 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .main-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px var(--shadow-light);
            margin: 2rem auto;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .header-section {
            background: var(--primary-gradient);
            padding: 2rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .header-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .header-section::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .back-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            margin-bottom: 1.5rem;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.2);
            color: white;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .content-section {
            padding: 2rem;
        }

        .alert-info {
            background: linear-gradient(135deg, #e3f2fd 0%, #f8fbff 100%) !important;
            border: 1px solid var(--primary-color) !important;
            border-radius: 15px !important;
            color: var(--primary-dark) !important;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px var(--shadow-light);
        }

        .filter-form {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 8px 30px var(--shadow-light);
            border: 1px solid rgba(2, 73, 187, 0.1);
            margin-bottom: 2rem;
        }

        .form-label {
            color: var(--primary-dark);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            background: rgba(248, 249, 250, 0.8);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem var(--shadow-light);
            background: white;
        }

        .btn-primary {
            background: var(--primary-gradient) !important;
            border: none !important;
            border-radius: 12px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px var(--shadow-light);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px var(--shadow-medium);
        }

        .table-container {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 30px var(--shadow-light);
            border: 1px solid rgba(2, 73, 187, 0.05);
        }

        .table {
            margin: 0;
        }

        .table thead th {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 1.2rem 1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.85rem;
        }

        .table tbody td {
            padding: 1.2rem 1rem;
            border-color: rgba(2, 73, 187, 0.1);
            vertical-align: middle;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background: rgba(2, 73, 187, 0.03);
            transform: translateX(2px);
        }

        .badge {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 500;
            font-size: 0.85rem;
        }

        .badge.bg-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
            box-shadow: 0 3px 10px rgba(40, 167, 69, 0.3);
        }

        .badge.bg-danger {
            background: linear-gradient(135deg, #dc3545 0%, #e74c3c 100%) !important;
            box-shadow: 0 3px 10px rgba(220, 53, 69, 0.3);
        }

        .text-center {
            padding: 3rem;
            color: #6c757d;
            font-style: italic;
        }

        .text-center i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
            display: block;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-container {
                margin: 1rem;
                border-radius: 15px;
            }

            .header-section {
                padding: 1.5rem;
            }

            .page-title {
                font-size: 2rem;
            }

            .content-section {
                padding: 1.5rem;
            }

            .filter-form {
                padding: 1.5rem;
            }

            .table-container {
                overflow-x: auto;
            }

            .table {
                min-width: 600px;
            }

            .back-btn {
                padding: 0.4rem 1rem;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 576px) {
            .page-title {
                font-size: 1.75rem;
            }

            .header-section {
                padding: 1.2rem;
            }

            .content-section {
                padding: 1rem;
            }

            .filter-form {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="main-container">
            <!-- Header Section -->
            <div class="header-section">
                <a href="{{ route('admin.verprofesor') }}" class="back-btn">
                    <i class="fas fa-arrow-left"></i>
                    Atrás
                </a>
                <h1 class="page-title">
                    <i class="fas fa-chalkboard-teacher me-3"></i>
                    Dictado de Profesores
                </h1>
            </div>

            <!-- Content Section -->
            <div class="content-section">
                <!-- Tu código PHP original para las alertas -->
                @php
                    $fechaInicio = request('fecha_inicio');
                    $fechaFin = request('fecha_fin');
                @endphp

                @if(!$fechaInicio && !$fechaFin)
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Mostrando dictado del día {{ now()->format('d/m/Y') }}.
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Mostrando dictado desde {{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') ?? '' }} hasta {{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') ?? '' }}.
                    </div>
                @endif

                <!-- Tu formulario original con mejor diseño -->
                <div class="filter-form">
                    <h5 class="mb-3">
                        <i class="fas fa-filter me-2 text-primary"></i>
                        Filtrar por Fecha
                    </h5>
                    <form method="GET" action="{{ route('admin.dictadoprofe.index') }}">
                        <div class="row g-2">
                            <div class="col-md-3">
                                <label for="fecha_inicio" class="form-label">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    Fecha Inicio
                                </label>
                                <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ request('fecha_inicio') }}">
                            </div>
                            <div class="col-md-3">
                                <label for="fecha_fin" class="form-label">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    Fecha Fin
                                </label>
                                <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="{{ request('fecha_fin') }}">
                            </div>
                            <div class="col-md-2 align-self-end">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search me-2"></i>
                                    Filtrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Tu tabla original con mejor diseño -->
                <div class="table-container">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>
                                    <i class="fas fa-user-tie me-2"></i>
                                    Profesor
                                </th>
                                <th>
                                    <i class="fas fa-flag me-2"></i>
                                    Estado
                                </th>
                                <th>
                                    <i class="fas fa-calendar me-2"></i>
                                    Fecha Calificación
                                </th>
                                <th>
                                    <i class="fas fa-clock me-2"></i>
                                    Hora Calificación
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dictados as $dictado)
                                <tr>
                                    <td>{{ $dictado->profesor->name }} {{ $dictado->profesor->apellido_p }} {{ $dictado->profesor->apellido_m }}</td>
                                    <td>
                                        <span class="badge {{ $dictado->estado_dictado == 'bien' ? 'bg-success' : 'bg-danger' }}">
                                            <i class="fas {{ $dictado->estado_dictado == 'bien' ? 'fa-check' : 'fa-times' }} me-1"></i>
                                            {{ ucfirst($dictado->estado_dictado) }}
                                        </span>
                                    </td>
                                    <td>{{ $dictado->fecha_calificacion }}</td>
                                    <td>{{ $dictado->hora_calificacion }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <i class="fas fa-search"></i>
                                        <strong>No se encontraron registros</strong>
                                        <br>
                                        <small>Intenta ajustar los filtros de búsqueda</small>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animación de entrada
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.main-container, .filter-form, .table-container');
            elements.forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    el.style.transition = 'all 0.6s ease';
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>