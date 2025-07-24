<div class="container mt-4">
    <h2>Gestión de Sílabos</h2>
    @if(session('success'))
    <div class="alert alert-success mt-2">
        {{ session('success') }}
    </div>
@endif

    <form method="GET" action="{{ route('curso_silabo.index') }}" class="row g-3 mb-4">
        <div class="col-md-4">
            <label for="facultad_id">Facultad</label>
            <select name="facultad_id" id="facultad_id" class="form-control" onchange="this.form.submit()">
                <option value="">Seleccione Facultad</option>
                @foreach($facultades as $facultad)
                    <option value="{{ $facultad->id }}" {{ $facultadSeleccionada == $facultad->id ? 'selected' : '' }}>
                        {{ $facultad->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        @if(!empty($carreras))
        <div class="col-md-4">
            <label for="carrera_id">Carrera</label>
            <select name="carrera_id" id="carrera_id" class="form-control" onchange="this.form.submit()">
                <option value="">Seleccione Carrera</option>
                @foreach($carreras as $carrera)
                    <option value="{{ $carrera->id }}" {{ $carreraSeleccionada == $carrera->id ? 'selected' : '' }}>
                        {{ $carrera->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        @endif
    </form>

    @if(!empty($cursos))
        <div class="card">
            <div class="card-header bg-primary text-white">
                Cursos de la Carrera Seleccionada
            </div>
            <div class="card-body">
                <table class="table table-bordered mb-4">
                    <thead>
                        <tr>
                            <th>Curso</th>
                            <th>URL Sílabo</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cursos as $curso)
                            <tr>
                                <td>{{ $curso->nombre }}</td>
                                <td>
                                    <form action="{{ route('curso_silabo.update', $curso->id) }}" method="POST" class="d-flex">
                                        @csrf
                                        <input type="text" name="silabus_url" value="{{ $curso->silabus_url }}" class="form-control me-2">
                                        <button type="submit" class="btn btn-success">Guardar</button>
                                    </form>
                                </td>
                                <td>
                                    @if($curso->silabus_url)
                                        <a href="{{ $curso->silabus_url }}" target="_blank" class="btn btn-outline-primary btn-sm">Ver</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>