<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Cursos Matriculados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2>📘 Mis cursos matriculados</h2>

    @if($cursos->isEmpty())
        <p>No estás matriculado en ningún curso actualmente.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Curso</th>
                    <th>Descripción</th>
                    <th>Periodo</th>
                    <th>Sección</th>
                    <th>Fecha de matrícula</th>
                    <th>Estado</th>
                    <th>Asistencias</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cursos as $curso)
                <tr>
                    <td>{{ $curso->curso }}</td>
                    <td>{{ $curso->descripcion ?? '—' }}</td>
                    <td>{{ $curso->periodo }}</td>
                    <td>{{ $curso->seccion }}</td>
                    <td>{{ \Carbon\Carbon::parse($curso->fecha_matricula)->format('d/m/Y') }}</td>
                    <td>{{ ucfirst($curso->estado) }}</td>
                    <td>
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalAsistencia{{ $curso->curso_periodo_id }}">
                            Ver Asistencias
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

{{-- MODALES DE ASISTENCIA --}}
@foreach($cursos as $curso)
<div class="modal fade" id="modalAsistencia{{ $curso->curso_periodo_id }}" tabindex="-1" aria-labelledby="label{{ $curso->curso_periodo_id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="label{{ $curso->curso_periodo_id }}">
            Asistencias - {{ $curso->curso }} (Sección {{ $curso->seccion }})
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        @php
            $asistencias = DB::table('asistencias')
                ->where('user_id', auth()->id())
                ->where('curso_periodo_id', $curso->curso_periodo_id)
                ->orderBy('fecha')
                ->get();
        @endphp

        @if($asistencias->isEmpty())
            <p>No hay asistencias registradas para este curso.</p>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Asistencia</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($asistencias as $asistencia)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}</td>
                        <td>
                            @if(is_null($asistencia->asistio))
                                <span class="badge bg-secondary">Pendiente</span>
                            @elseif($asistencia->asistio)
                                <span class="badge bg-success">Asistió</span>
                            @else
                                <span class="badge bg-danger">Faltó</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
      </div>
    </div>
  </div>
</div>
@endforeach

{{-- Bootstrap JS para modales --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
