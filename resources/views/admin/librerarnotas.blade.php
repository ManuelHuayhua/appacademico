<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Cursos</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-gradient: linear-gradient(120deg, #0249BB 0%, #003bb1 100%);
            --primary-color: #0249BB;
            --secondary-color: #003bb1;
            --light-bg: #f8f9fa;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-hover: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }

        .main-container {
            background: white;
            border-radius: 20px;
            box-shadow: var(--shadow);
            margin: 2rem auto;
            max-width: 1200px;
            overflow: hidden;
        }

        .header-section {
            background: var(--primary-gradient);
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(180deg); }
        }

        .header-section h3 {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
            position: relative;
            z-index: 1;
        }

        .header-section .subtitle {
            margin-top: 0.5rem;
            opacity: 0.9;
            font-size: 1.1rem;
            position: relative;
            z-index: 1;
        }

        .filter-section {
            padding: 2rem;
            background: white;
        }

        .filter-card {
            background: var(--light-bg);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(2, 73, 187, 0.1);
            transition: all 0.3s ease;
        }

        .filter-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }

        .form-label {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-select {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(2, 73, 187, 0.25);
            transform: translateY(-1px);
        }

        .results-section {
            padding: 0 2rem 2rem;
        }

        .results-header {
            background: var(--primary-gradient);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 10px 10px 0 0;
            margin-bottom: 0;
            font-size: 1.25rem;
            font-weight: 600;
        }

        .table-container {
            background: white;
            border-radius: 0 0 10px 10px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .table {
            margin: 0;
            font-size: 0.95rem;
        }

        .table thead th {
            background: linear-gradient(45deg, #f8f9fa, #e9ecef);
            border: none;
            font-weight: 600;
            color: var(--primary-color);
            padding: 1rem;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .table tbody td {
            padding: 1rem;
            border-color: #f1f3f4;
            vertical-align: middle;
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background: rgba(2, 73, 187, 0.05);
            transform: scale(1.01);
        }

        .action-form {
            display: flex;
            gap: 0.5rem;
            align-items: stretch;
        }

        .action-select {
            flex: 1;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 0.5rem;
            font-size: 0.9rem;
        }

        .btn-apply {
            background: var(--primary-gradient);
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .btn-apply:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(2, 73, 187, 0.3);
            color: white;
        }

        .alert-custom {
            border: none;
            border-radius: 15px;
            padding: 1.5rem;
            margin: 1rem 0;
            background: linear-gradient(45deg, #fff3cd, #ffeaa7);
            color: #856404;
            border-left: 4px solid #ffc107;
        }

        .divider {
            height: 2px;
            background: var(--primary-gradient);
            border: none;
            margin: 2rem 0;
            border-radius: 2px;
        }

        .icon-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 0.25rem 0.5rem;
            border-radius: 50px;
            font-size: 0.8rem;
        }

        @media (max-width: 768px) {
            .main-container {
                margin: 1rem;
                border-radius: 15px;
            }
            
            .header-section {
                padding: 1.5rem 1rem;
            }
            
            .header-section h3 {
                font-size: 1.5rem;
            }
            
            .filter-section, .results-section {
                padding: 1rem;
            }
            
            .table-responsive {
                border-radius: 10px;
            }
            
            .action-form {
                flex-direction: column;
                gap: 0.25rem;
            }
            
            .btn-apply {
                width: 100%;
            }
        }

        .loading-spinner {
            display: none;
            text-align: center;
            padding: 2rem;
        }

        .course-badge {
            background: var(--primary-gradient);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .professor-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .professor-avatar {
            width: 32px;
            height: 32px;
            background: var(--primary-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="main-container">
            <!-- Header Section -->
            <div class="header-section">
                <h3><i class="fas fa-graduation-cap me-3"></i>Gestión de Cursos</h3>
                <p class="subtitle mb-0">Filtrar cursos por facultad, carrera y periodo académico</p>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <div class="filter-card">
                    <form method="GET" action="{{ route('admin.librerarnotas.index') }}" id="filterForm">
                        <div class="row g-4">
                            <div class="col-lg-4 col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-university"></i>
                                    Facultad
                                </label>
                                <select name="facultad_id" class="form-select" onchange="this.form.submit()">
                                    <option value="">🏛️ Seleccione una facultad</option>
                                    @foreach ($facultades as $facultad)
                                        <option value="{{ $facultad->id }}" {{ $request->facultad_id == $facultad->id ? 'selected' : '' }}>
                                            {{ $facultad->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-lg-4 col-md-6">
                                <label class="form-label">
                                    <i class="fas fa-book-open"></i>
                                    Carrera
                                </label>
                                <select name="carrera_id" class="form-select" onchange="this.form.submit()">
                                    <option value="">📚 Seleccione una carrera</option>
                                    @foreach ($carreras as $carrera)
                                        <option value="{{ $carrera->id }}" {{ $request->carrera_id == $carrera->id ? 'selected' : '' }}>
                                            {{ $carrera->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-lg-4 col-md-12">
                                <label class="form-label">
                                    <i class="fas fa-calendar-alt"></i>
                                    Periodo Académico
                                </label>
                                <select name="periodo_id" class="form-select" onchange="this.form.submit()">
                                    <option value="">📅 Seleccione un periodo</option>
                                    @foreach ($periodos as $periodo)
                                        <option value="{{ $periodo->id }}" {{ $request->periodo_id == $periodo->id ? 'selected' : '' }}>
                                            {{ $periodo->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <hr class="divider">

            <!-- Results Section -->
            <div class="results-section">
                @if ($cursos->count() > 0)
                    <div class="results-header">
                        <i class="fas fa-list-ul me-2"></i>
                        Cursos disponibles en el periodo seleccionado
                        <span class="icon-badge ms-2">{{ $cursos->count() }} cursos</span>
                    </div>
                    
                    <div class="table-container">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th><i class="fas fa-book me-2"></i>Curso</th>
                                        <th><i class="fas fa-info-circle me-2"></i>Descripción</th>
                                        <th><i class="fas fa-chalkboard-teacher me-2"></i>Profesor</th>
                                        <th>Estado</th>
                                        <th><i class="fas fa-cogs me-2"></i>Gestión de Permisos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cursos as $curso)
                                        @if (isset($cursoPeriodosPorCurso[$curso->id]))
                                            @foreach ($cursoPeriodosPorCurso[$curso->id] as $info)
                                                @foreach ($info['profesores'] as $profesor)
                                                    <tr>
                                                        <td>
                                                            <div class="course-badge">
                                                                {{ $curso->nombre }}
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <small class="text-muted">{{ $curso->descripcion }}</small>
                                                        </td>
                                                        <td>
                                                            <div class="professor-info">
                                                                <div class="professor-avatar">
                                                                    {{ substr($profesor->name, 0, 1) }}
                                                                </div>
                                                                <span>{{ $profesor->name }}</span>
                                                                @php
    $permiso = $info['permisos']->get($profesor->id)?->first()?->permiso ?? 'N/A';

    $estados = [
        '1' => '1er Avance',
        '2' => '2do Avance',
        '3' => 'Final',
        '4' => 'Oral 1',
        '5' => 'Oral 2',
        '6' => 'Oral 3',
        '7' => 'Oral 4',
        '8' => 'Oral 5',
        '9' => 'Examen Final',
        'editable' => 'Todos',
        'denegado' => 'Denegado',
    ];
@endphp

<td>
    <span class="badge {{ $permiso == 'denegado' ? 'bg-danger' : 'bg-success' }}">
        {{ $estados[$permiso] ?? 'Sin Estado' }}
    </span>
</td>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <form method="POST" action="{{ route('admin.librerarnotas.cambiarPermisoCurso') }}">
                                                                @csrf
                                                                <input type="hidden" name="curso_periodo_id" value="{{ $info['curso_periodo']->id }}">
                                                                <input type="hidden" name="profesor_id" value="{{ $profesor->id }}">
                                                                <div class="action-form">
                                                                    <select name="permiso" class="action-select" required>
                                                                        <option value="">-- Selecciona acción --</option>
                                                                        <option value="1">🔓 Desbloquear Primer Avance</option>
                                                                        <option value="2">🔓 Desbloquear Segundo Avance</option>
                                                                        <option value="3">🔓 Desbloquear Presentación Final</option>
                                                                        <option value="4">🗣️ Desbloquear Oral 1</option>
                                                                        <option value="5">🗣️ Desbloquear Oral 2</option>
                                                                        <option value="6">🗣️ Desbloquear Oral 3</option>
                                                                        <option value="7">🗣️ Desbloquear Oral 4</option>
                                                                        <option value="8">🗣️ Desbloquear Oral 5</option>
                                                                        <option value="9">📝 Desbloquear Examen Final</option>
                                                                        <option value="editable">✅ Desbloquear Todos</option>
                                                                        <option value="denegado">❌ Denegar Acceso</option>
                                                                    </select>
                                                                    <button type="submit" class="btn-apply">
                                                                        <i class="fas fa-check me-1"></i>Aplicar
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @elseif($request->filled(['facultad_id', 'carrera_id', 'periodo_id']))
                    <div class="alert-custom">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-3 fs-4"></i>
                            <div>
                                <strong>No se encontraron cursos</strong><br>
                                <small>No hay cursos disponibles para los filtros seleccionados. Intenta con otros criterios de búsqueda.</small>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add loading state when form is submitted
        document.getElementById('filterForm').addEventListener('submit', function() {
            const selects = this.querySelectorAll('select');
            selects.forEach(select => {
                select.disabled = true;
            });
        });

        // Add smooth animations
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.filter-card, .table-container');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>