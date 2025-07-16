<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 CSS y JS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<div class="container">
    <h2>📚 Matricular Alumnos</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('admin.matricula.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="user_ids">Alumnos</label>
            <select name="user_ids[]" class="form-control select-alumnos" multiple required>
                @foreach($alumnos as $alumno)
                    <option value="{{ $alumno->id }}">{{ $alumno->name }} {{ $alumno->apellido_p }} {{ $alumno->apellido_m }} - DNI: {{ $alumno->dni }}</option>
                @endforeach
            </select>
            <small class="form-text text-muted">Puedes buscar y seleccionar varios alumnos.</small>
        </div>

        <div class="mb-3">
    <label for="curso_periodo_id">Curso</label>
    <select name="curso_periodo_id" class="form-control select-curso" required>
        @foreach($cursos as $curso)
            <option value="{{ $curso->id }}">
                {{ $curso->curso->nombre }} ({{ $curso->periodo->nombre }} - Sección {{ $curso->seccion }})
            </option>
        @endforeach
    </select>
</div>

        <button type="submit" class="btn btn-primary">Matricular</button>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('.select-alumnos').select2({
            placeholder: "Selecciona los alumnos",
            allowClear: true,
            width: '100%'
        });
        $('.select-curso').select2({
            placeholder: "Selecciona el curso",
            allowClear: true,
            width: '100%'
        });
    });
</script>



<hr>
<h3>📋 Alumnos matriculados</h3>

@if($matriculas->isEmpty())
    <p>No hay alumnos matriculados aún.</p>
@else
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Alumno</th>
                <th>Curso</th>
                <th>Periodo</th>
                <th>Sección</th>
                <th>Fecha de matrícula</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($matriculas as $m)
                <tr>
                    <td>{{ $m->alumno }}</td>
                    <td>{{ $m->curso }}</td>
                    <td>{{ $m->periodo }}</td>
                    <td>{{ $m->seccion }}</td>
                    <td>{{ $m->fecha_matricula }}</td>
                    <td>{{ ucfirst($m->estado) }}</td>
                    <td>
                        {{-- Aquí podrías agregar botón de retirar o editar --}}
                        <form method="POST" action="{{ route('admin.matricula.destroy', $m->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de retirar esta matrícula?')">Retirar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif