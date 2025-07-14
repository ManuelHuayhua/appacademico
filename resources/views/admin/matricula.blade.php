<div class="container">
    <h2>📚 Matricular Alumno</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('admin.matricula.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="user_id">Alumno</label>
            <select name="user_id" class="form-control" required>
                @foreach($alumnos as $alumno)
                    <option value="{{ $alumno->id }}">{{ $alumno->name }} - {{ $alumno->email }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="curso_periodo_id">Curso</label>
            <select name="curso_periodo_id" class="form-control" required>
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