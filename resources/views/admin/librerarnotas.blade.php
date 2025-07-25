
<h3>Filtrar Cursos por Facultad, Carrera y Periodo</h3>

<form method="GET" action="{{ route('admin.librerarnotas.index') }}">
    <div class="row">
        <div class="col-md-4">
            <label>Facultad</label>
            <select name="facultad_id" class="form-control" onchange="this.form.submit()">
                <option value="">Seleccione</option>
                @foreach ($facultades as $facultad)
                    <option value="{{ $facultad->id }}" {{ $request->facultad_id == $facultad->id ? 'selected' : '' }}>
                        {{ $facultad->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <label>Carrera</label>
            <select name="carrera_id" class="form-control" onchange="this.form.submit()">
                <option value="">Seleccione</option>
                @foreach ($carreras as $carrera)
                    <option value="{{ $carrera->id }}" {{ $request->carrera_id == $carrera->id ? 'selected' : '' }}>
                        {{ $carrera->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <label>Periodo</label>
            <select name="periodo_id" class="form-control" onchange="this.form.submit()">
                <option value="">Seleccione</option>
                @foreach ($periodos as $periodo)
                    <option value="{{ $periodo->id }}" {{ $request->periodo_id == $periodo->id ? 'selected' : '' }}>
                        {{ $periodo->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</form>

<hr>

@if ($cursos->count() > 0)
    <h4>Cursos dictados en el periodo seleccionado:</h4>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Curso</th>
                <th>Descripción</th>
                <th>Profesor</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cursos as $curso)
                @if (isset($cursoPeriodosPorCurso[$curso->id]))
                    @foreach ($cursoPeriodosPorCurso[$curso->id] as $info)
                        @foreach ($info['profesores'] as $profesor)
                            <tr>
                                <td>{{ $curso->nombre }}</td>
                                <td>{{ $curso->descripcion }}</td>
                                <td>{{ $profesor->name }}</td>
                                <td>
                                  <td>
    <form method="POST" action="{{ route('admin.librerarnotas.cambiarPermisoCurso') }}">
        @csrf
        <input type="hidden" name="curso_periodo_id" value="{{ $info['curso_periodo']->id }}">
        <input type="hidden" name="profesor_id" value="{{ $profesor->id }}">
        <div class="input-group">
            <select name="permiso" class="form-control" required>
                <option value="">-- Selecciona acción --</option>
                <option value="1">Desbloquear Primer Avance</option>
                <option value="2">Desbloquear Segundo Avance</option>
                <option value="3">Desbloquear Presentación Final</option>
                <option value="4">Desbloquear Oral 1</option>
                <option value="5">Desbloquear Oral 2</option>
                <option value="6">Desbloquear Oral 3</option>
                <option value="7">Desbloquear Oral 4</option>
                <option value="8">Desbloquear Oral 5</option>
                <option value="9">Desbloquear Examen Final</option>
                <option value="editable">Desbloquear Todos</option>
                <option value="denegado">Denegar</option>
            </select>
            <div class="input-group-append">
                <button type="submit" class="btn btn-sm btn-success">Aplicar</button>
            </div>
        </div>
    </form>
</td>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                @endif
            @endforeach
        </tbody>
    </table>
@elseif($request->filled(['facultad_id', 'carrera_id', 'periodo_id']))
    <div class="alert alert-warning mt-3">
        No se encontraron cursos para los filtros seleccionados.
    </div>
@endif

