<div class="container mt-4">
    <h2 class="mb-4">Gestión de URLs de Clases Virtuales</h2>



    {{-- Filtro por periodo --}}
    <form method="GET" class="mb-4">
    <div class="row">
        <div class="col-md-3">
            <label>Facultad:</label>
            <select name="facultad_id" class="form-control" onchange="this.form.submit()">
                <option value="">-- Seleccione Facultad --</option>
                @foreach($facultades as $facultad)
                    <option value="{{ $facultad->id }}" {{ $facultad_id == $facultad->id ? 'selected' : '' }}>
                        {{ $facultad->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label>Carrera:</label>
            <select name="carrera_id" class="form-control" onchange="this.form.submit()">
                <option value="">-- Seleccione Carrera --</option>
                @foreach($carreras as $carrera)
                    <option value="{{ $carrera->id }}" {{ $carrera_id == $carrera->id ? 'selected' : '' }}>
                        {{ $carrera->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label>Periodo:</label>
            <select name="periodo_id" class="form-control">
                <option value="">-- Seleccione Periodo --</option>
                @foreach($periodos as $periodo)
                    <option value="{{ $periodo->id }}" {{ $periodo_id == $periodo->id ? 'selected' : '' }}>
                        {{ $periodo->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </div>
    </div>
</form>

    {{-- Mensaje si no hay periodo activo --}}
    @if(isset($mensaje))
        <div class="alert alert-info">
            {{ $mensaje }}
        </div>
    @endif

    {{-- Tabla de cursos por periodo --}}
    @if($cursosPeriodo->count())
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Curso</th>
                    <th>Sección</th>
                    <th>Periodo</th>
                    <th>URL Clase Virtual</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cursosPeriodo as $item)
                <tr>
                    <td>{{ $item->curso->nombre ?? 'Sin nombre' }}</td>
                    <td>{{ $item->seccion }}</td>
                    <td>{{ $item->periodo->nombre ?? 'Sin periodo' }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.clasesurl.update') }}">
                            @csrf
                            <input type="hidden" name="curso_periodo_id" value="{{ $item->id }}">
                            <input type="url" name="url_clase_virtual" class="form-control" value="{{ $item->url_clase_virtual }}" placeholder="https://...">
                    </td>
                    <td>
                            <button type="submit" class="btn btn-success btn-sm">Guardar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        @if(!isset($mensaje))
            <p>No hay cursos registrados para este periodo.</p>
        @endif
    @endif

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
</div>