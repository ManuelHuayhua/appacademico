<div class="container">
    <h2>Enviar Mensaje</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

   <form method="POST" action="{{ route('admin.mensajes.enviar') }}">
        @csrf

        <div class="mb-3">
            <label for="tipo_envio">Tipo de envío:</label>
            <select class="form-control" name="tipo_envio" id="tipo_envio" onchange="toggleCampos()">
                <option value="individual">Individual</option>
                <option value="curso">Por Curso</option>
            </select>
        </div>

        <div class="mb-3" id="campoAlumno">
            <label>Alumno:</label>
            <select name="alumno_id" class="form-control">
                @foreach($alumnos as $alumno)
                    <option value="{{ $alumno->id }}">{{ $alumno->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3 d-none" id="campoCurso">
            <label>Curso:</label>
            <select name="curso_periodo_id" class="form-control">
                @foreach($cursos as $curso)
                    <option value="{{ $curso->id }}">{{ $curso->curso->nombre }} ({{ $curso->seccion }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Título:</label>
            <input type="text" class="form-control" name="titulo" required>
        </div>

        <div class="mb-3">
            <label>Contenido:</label>
            <textarea name="contenido" class="form-control" rows="5" required></textarea>
        </div>

        <div class="mb-3">
            <label>Fecha de inicio:</label>
            <input type="date" class="form-control" name="fecha_inicio" required>
        </div>

        <div class="mb-3">
            <label>Fecha de fin:</label>
            <input type="date" class="form-control" name="fecha_fin" required>
        </div>

        <button class="btn btn-primary">Enviar</button>
    </form>
</div>

<script>
    function toggleCampos() {
        const tipo = document.getElementById('tipo_envio').value;

        const campoAlumno = document.getElementById('campoAlumno');
        const selectAlumno = campoAlumno.querySelector('select');
        campoAlumno.classList.toggle('d-none', tipo !== 'individual');
        selectAlumno.disabled = tipo !== 'individual';

        const campoCurso = document.getElementById('campoCurso');
        const selectCurso = campoCurso.querySelector('select');
        campoCurso.classList.toggle('d-none', tipo !== 'curso');
        selectCurso.disabled = tipo !== 'curso';
    }

    window.onload = toggleCampos;
</script>