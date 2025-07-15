<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tomar Asistencia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .semanas-collapse, .fechas-collapse {
            transition: all 0.3s ease;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <h2>👨‍🏫 Cursos Asignados</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @foreach($cursos as $curso)
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>{{ $curso->curso }} - {{ $curso->periodo }} (Sección {{ $curso->seccion }})</strong>
                <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#semanas{{ $curso->curso_periodo_id }}">
                    Ver semanas
                </button>
            </div>

            <div class="collapse semanas-collapse" id="semanas{{ $curso->curso_periodo_id }}">
                <div class="card-body">
                    @foreach($fechasPorSemana[$curso->curso_periodo_id] as $semana => $fechas)
                        <div class="mb-3 border p-2 rounded">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">📅 Semana que inicia el {{ \Carbon\Carbon::parse($semana)->format('d/m/Y') }}</h6>
                                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#fechas{{ $curso->curso_periodo_id }}_{{ $loop->index }}">
                                    Ver detalle
                                </button>
                            </div>

                            <div class="collapse fechas-collapse mt-2" id="fechas{{ $curso->curso_periodo_id }}_{{ $loop->index }}">
                                @foreach($fechas as $fecha)
                                    <form action="{{ route('profesor.asistencia.guardar') }}" method="POST" class="mb-3 border p-3 rounded shadow-sm">
                                        @csrf
                                        <input type="hidden" name="curso_periodo_id" value="{{ $curso->curso_periodo_id }}">
                                        <input type="hidden" name="fecha" value="{{ $fecha }}">

                                        <strong class="text-primary">{{ \Carbon\Carbon::parse($fecha)->locale('es')->translatedFormat('l d \d\e F') }}</strong>

                                        <table class="table table-sm table-bordered mt-2">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Alumno</th>
                                                    <th>Asistencia</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($alumnosPorCurso[$curso->curso_periodo_id] as $alumno)
                                                    <tr>
                                                        <td>{{ $alumno->name }}</td>
                                                        <td>
                                                            <select name="asistencias[{{ $alumno->id }}]" class="form-select form-select-sm">
                                                                <option value="1">Asistió</option>
                                                                <option value="0">Faltó</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <button type="submit" class="btn btn-success btn-sm">Guardar asistencia</button>
                                    </form>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
