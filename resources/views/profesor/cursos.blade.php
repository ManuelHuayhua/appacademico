<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tomar Asistencia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">

    <h2>👨‍🏫 Cursos Asignados</h2>

    {{-- Filtro por periodo --}}
    <form method="GET" action="{{ route('profesor.cursos') }}" class="mb-4">
        <div class="row g-2 align-items-end">
            <div class="col-md-4">
                <label for="periodo_id" class="form-label">Seleccionar periodo:</label>
                <select class="form-select" name="periodo_id" id="periodo_id" onchange="this.form.submit()">
                    @foreach($periodos as $periodo)
                        <option value="{{ $periodo->id }}" {{ $periodo->id == $periodoSeleccionado ? 'selected' : '' }}>
                            {{ $periodo->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @foreach($cursos as $curso)
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>{{ $curso->curso }} - {{ $curso->periodo }} (Sección {{ $curso->seccion }})</strong>
            </div>
            <div class="card-body">

                @php $semanas = $fechasPorSemana[$curso->curso_periodo_id] ?? []; @endphp

                @if(count($semanas) == 0)
                    <p>No hay fechas registradas para este curso.</p>
                @else
                    @foreach($semanas as $inicioSemana => $fechas)
                        <div class="mb-3 border p-3 rounded">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">📅 Semana que inicia el {{ \Carbon\Carbon::parse($inicioSemana)->format('d/m/Y') }}</h5>
                                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#semana{{ $curso->curso_periodo_id }}_{{ $inicioSemana }}">
                                    Ver detalles
                                </button>
                            </div>

                            <div class="collapse mt-3" id="semana{{ $curso->curso_periodo_id }}_{{ $inicioSemana }}">
                                <form action="{{ route('profesor.asistencia.guardar') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="curso_periodo_id" value="{{ $curso->curso_periodo_id }}">

                                    @foreach($fechas as $fecha)
                                        <h6 class="mt-3">📌 Fecha: {{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}</h6>

                                        <table class="table table-sm table-bordered">
                                            <thead>
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
                                                            @php
                                                                $registro = DB::table('asistencias')
                                                                    ->where('user_id', $alumno->id)
                                                                    ->where('curso_periodo_id', $curso->curso_periodo_id)
                                                                    ->where('fecha', $fecha)
                                                                    ->first();
                                                            @endphp
                                                            <div class="btn-group" role="group">
    <input type="radio" class="btn-check"
           name="asistencias[{{ $alumno->id }}][{{ $fecha }}]"
           id="asistio_{{ $alumno->id }}_{{ $fecha }}"
           value="1"
           {{ optional($registro)->asistio === 1 ? 'checked' : '' }}>
    <label class="btn btn-outline-success btn-sm"
           for="asistio_{{ $alumno->id }}_{{ $fecha }}">✅ Asistió</label>

    <input type="radio" class="btn-check"
           name="asistencias[{{ $alumno->id }}][{{ $fecha }}]"
           id="falto_{{ $alumno->id }}_{{ $fecha }}"
           value="0"
           {{ optional($registro)->asistio === 0 ? 'checked' : '' }}>
    <label class="btn btn-outline-danger btn-sm"
           for="falto_{{ $alumno->id }}_{{ $fecha }}">❌ Faltó</label>

    <input type="radio" class="btn-check"
           name="asistencias[{{ $alumno->id }}][{{ $fecha }}]"
           id="pendiente_{{ $alumno->id }}_{{ $fecha }}"
           value=""
           {{ is_null(optional($registro)->asistio) ? 'checked' : '' }}>
    <label class="btn btn-outline-secondary btn-sm"
           for="pendiente_{{ $alumno->id }}_{{ $fecha }}">⏳ Pendiente</label>
</div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endforeach

                                    <button class="btn btn-success btn-sm mt-2">Guardar asistencias de esta semana</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    @endforeach
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
