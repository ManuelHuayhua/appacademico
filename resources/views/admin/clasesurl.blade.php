<div class="container mt-4">
    <h2 class="mb-4">Gestión de URLs de Clases Virtuales</h2>



    {{-- Filtro por periodo --}}
    <form method="GET" class="mb-4">
        <label for="periodo_id">Filtrar por Periodo:</label>
        <select name="periodo_id" id="periodo_id" class="form-control w-25 d-inline-block">
            <option value="">-- Todos los periodos --</option>
            @foreach ($periodos as $periodo)
                <option value="{{ $periodo->id }}" {{ $periodoSeleccionado == $periodo->id ? 'selected' : '' }}>
                    {{ $periodo->nombre }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary ml-2">Filtrar</button>
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