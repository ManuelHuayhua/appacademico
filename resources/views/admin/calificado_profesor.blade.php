
<h2>Calificaciones de Profesores</h2>

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

{{-- Filtros de Periodo y Profesor --}}
<form method="GET" action="{{ route('admin.calificado_profesor.index') }}" class="mb-4 d-flex gap-3 align-items-center flex-wrap">
    <div>
        <label for="periodo_id" class="form-label">Periodo:</label>
        <select name="periodo_id" id="periodo_id" class="form-select" onchange="this.form.submit()">
            @foreach($periodos as $periodo)
                <option value="{{ $periodo->id }}" @if($periodo->id == $periodo_id) selected @endif>{{ $periodo->nombre }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="profesor_id" class="form-label">Profesor:</label>
        <select name="profesor_id" id="profesor_id" class="form-select" onchange="this.form.submit()">
            @foreach($profesores as $profesor)
                <option value="{{ $profesor->id }}" @if($profesor->id == $profesor_id) selected @endif>{{ $profesor->name }}</option>
            @endforeach
        </select>
    </div>
</form>

{{-- Promedio general del profesor --}}
<h4>
    Promedio general para 
    <strong>{{ $profesores->firstWhere('id', $profesor_id)->name ?? 'Profesor' }}</strong> 
    en periodo 
    <strong>{{ $periodos->firstWhere('id', $periodo_id)->nombre ?? 'Periodo' }}</strong>:
</h4>
<p><strong>{{ number_format($promedioGeneral, 2) ?? 'N/A' }}</strong></p>

{{-- Promedios por curso --}}
<h4>Promedios por curso:</h4>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Curso</th>
            <th>Total de Calificaciones</th>
            <th>Promedio Preguntas</th>
        </tr>
    </thead>
    <tbody>
        @forelse($promediosPorCurso as $curso)
            <tr>
                <td>{{ $curso['curso_nombre'] }}</td>
                <td>{{ $curso['cantidad_calificaciones'] }}</td>
                <td>{{ number_format($curso['promedio_preguntas'], 2) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3">No hay calificaciones para este profesor en este periodo.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{-- Detalle de calificaciones --}}
<h4>Detalle de calificaciones:</h4>
<table class="table table-striped table-sm">
    <thead>
        <tr>
            <th>ID Calificación</th>
            <th>Curso</th>
            <th>Promedio Preguntas</th>
            <th>Preguntas (1-5)</th>
            <th>Comentario</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        @foreach($calificaciones as $cal)
        <tr>
            <td>{{ $cal->calificacion_id }}</td>
            <td>{{ $cal->curso_nombre }}</td>
            <td>{{ $cal->promedio_preguntas }}</td>
            <td>{{ $cal->pregunta_1 }}, {{ $cal->pregunta_2 }}, {{ $cal->pregunta_3 }}, {{ $cal->pregunta_4 }}, {{ $cal->pregunta_5 }}</td>
            <td>{{ $cal->comentario ?? '-' }}</td>
            <td>{{ \Carbon\Carbon::parse($cal->created_at)->format('Y-m-d') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- Profesores con promedio menor a 3 --}}
<h3>Profesores con promedio menor a 3 en periodo {{ $periodos->firstWhere('id', $periodo_id)->nombre ?? '' }}:</h3>

@if($profesoresMalCalificados->isEmpty())
    <p>No hay profesores con promedio menor a 3 en este periodo.</p>
@else
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Profesor</th>
                <th>Promedio Preguntas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($profesoresMalCalificados as $prof)
                <tr>
                    <td>{{ $prof->name }}</td>
                    <td>{{ number_format($prof->promedio_preguntas, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

