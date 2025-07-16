<h2>📊 Reporte de Calificaciones</h2>

<form method="GET" action="{{ route('admin.calificaciones.index') }}">
    <div class="row mb-3">
        {{-- Facultad --}}
        <div class="col-md-3">
            <label>Facultad:</label>
            <select name="facultad_id" class="form-control" onchange="this.form.submit()">
                <option value="">-- Seleccionar --</option>
                @foreach($facultades as $fac)
                    <option value="{{ $fac->id }}" {{ $request->facultad_id == $fac->id ? 'selected' : '' }}>
                        {{ $fac->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Carrera --}}
        @if($carreras->isNotEmpty())
        <div class="col-md-3">
            <label>Carrera:</label>
            <select name="carrera_id" class="form-control" onchange="this.form.submit()">
                <option value="">-- Seleccionar --</option>
                @foreach($carreras as $carr)
                    <option value="{{ $carr->id }}" {{ $request->carrera_id == $carr->id ? 'selected' : '' }}>
                        {{ $carr->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        @endif

        {{-- Periodo --}}
        @if($periodos->isNotEmpty() && $request->filled('carrera_id'))
        <div class="col-md-3">
            <label>Periodo:</label>
            <select name="periodo_id" class="form-control" onchange="this.form.submit()">
                <option value="">-- Seleccionar --</option>
                @foreach($periodos as $periodo)
                    <option value="{{ $periodo->id }}" {{ $request->periodo_id == $periodo->id ? 'selected' : '' }}>
                        {{ $periodo->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        @endif

        {{-- Curso --}}
        @if($cursos->isNotEmpty())
        <div class="col-md-3">
            <label>Curso:</label>
            <select name="curso_periodo_id" class="form-control" onchange="this.form.submit()">
                <option value="">-- Seleccionar --</option>
                @foreach($cursos as $curso)
                    <option value="{{ $curso->id }}" {{ $request->curso_periodo_id == $curso->id ? 'selected' : '' }}>
                        {{ $curso->nombre }} (Sección {{ $curso->seccion }})
                    </option>
                @endforeach
            </select>
        </div>
        @endif

        {{-- Profesor --}}
        @if($profesores->isNotEmpty())
        <div class="col-md-3 mt-2">
            <label>Profesor:</label>
            <select name="profesor_id" class="form-control" onchange="this.form.submit()">
                <option value="">-- Seleccionar --</option>
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

{{-- Tabla de calificaciones --}}
@if($calificaciones->isNotEmpty() && $request->filled('profesor_id'))
    <hr>
    <h4>🧑‍🎓 Calificaciones del curso</h4>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Alumno</th>
                <th>1er Avance</th>
                <th>2do Avance</th>
                <th>Presentación Final</th>
                <th>Prom. Avance</th>
                <th>Orales</th>
                <th>Promedio</th>
                <th>Eval. Permanente</th>
                <th>Examen Final</th>
                <th>Prom. Final</th>
            </tr>
        </thead>
        <tbody>
            @foreach($calificaciones as $cal)
                <tr>
                    <td>{{ $cal->alumno }}</td>
                    <td>{{ $cal->primer_avance }}</td>
                    <td>{{ $cal->segundo_avance }}</td>
                    <td>{{ $cal->presentacion_final }}</td>
                    <td>{{ $cal->promedio_avance }}</td>
                    <td>
                        {{ $cal->oral_1 }} | {{ $cal->oral_2 }} | {{ $cal->oral_3 }} | {{ $cal->oral_4 }} | {{ $cal->oral_5 }}
                    </td>
                    <td>{{ $cal->promedio }}</td>
                    <td>{{ $cal->promedio_evaluacion_permanente }}</td>
                    <td>{{ $cal->examen_final }}</td>
                    <td><strong>{{ $cal->promedio_final }}</strong></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
