{{-- CSS de Select2 --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<form action="{{ route('admin.cursos.store') }}" method="POST">
    @csrf

<h3>Facultad</h3>
<select class="facultad-select" name="facultad_nombre" style="width: 100%;">
    <option value="">-- Escribe o selecciona una facultad --</option>
    @foreach($facultades as $facultad)
        <option value="{{ $facultad->nombre }}">{{ $facultad->nombre }}</option>
    @endforeach
</select>

<h3>Carrera</h3>
<select class="carrera-select" name="carrera_nombre" style="width: 100%;">
    <option value="">-- Escribe o selecciona una carrera --</option>
    {{-- Se llenará dinámicamente --}}
</select>

<script>
$(document).ready(function () {
    // Inicializa Select2 con opción de ingresar nuevo texto
    $('.facultad-select').select2({
        tags: true,
        placeholder: 'Escribe o selecciona una facultad',
        allowClear: true
    });

    $('.carrera-select').select2({
        tags: true,
        placeholder: 'Escribe o selecciona una carrera',
        allowClear: true
    });

    // Al cambiar la facultad, cargar las carreras relacionadas
    $('.facultad-select').on('change', function () {
        const facultadNombre = $(this).val();
        const $carreraSelect = $('.carrera-select');

        // Limpiar carreras anteriores
        $carreraSelect.empty().append('<option value="">-- Escribe o selecciona una carrera --</option>');

        if (facultadNombre) {
            fetch(`/admin/carreras-por-nombre-facultad/${facultadNombre}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(carrera => {
                        const option = new Option(carrera.nombre, carrera.nombre, false, false);
                        $carreraSelect.append(option);
                    });
                });
        }

        $carreraSelect.val(null).trigger('change'); // Reiniciar selección
    });
});
</script>



<h3>Periodo académico</h3>
    <select name="periodo_id" required>
        <option value="">-- Selecciona un periodo --</option>
        @foreach ($periodos as $periodo)
            <option value="{{ $periodo->id }}">{{ $periodo->nombre }} ({{ $periodo->fecha_inicio }} al {{ $periodo->fecha_fin }})</option>
        @endforeach
    </select>

    <h3>Cursos</h3>
    <div id="cursos-container">
        <div class="curso">
            <input type="text" name="cursos[0][nombre]" required placeholder="Nombre del curso">
            <textarea name="cursos[0][descripcion]" placeholder="Descripción del curso"></textarea>

            {{-- PROFESOR DEL CURSO (solo uno) --}}
            <label>Profesor:</label>
            <select name="cursos[0][profesor_id]">
                @foreach ($profesores as $profesor)
                    <option value="{{ $profesor->id }}">{{ $profesor->name }}</option>
                @endforeach
            </select>

            <h4>Horarios</h4>
            <div class="horarios-container">
                <div class="horario">
                    <select name="cursos[0][horarios][0][dia_semana]">
                        <option value="1">Lunes</option>
                        <option value="2">Martes</option>
                        <option value="3">Miércoles</option>
                        <option value="4">Jueves</option>
                        <option value="5">Viernes</option>
                        <option value="6">Sábado</option>
                        <option value="7">Domingo</option>
                    </select>
                    <input type="time" name="cursos[0][horarios][0][hora_inicio]" required>
                    <input type="time" name="cursos[0][horarios][0][hora_fin]" required>
                </div>
            </div>

            <button type="button" onclick="agregarHorario(this)">+ Agregar horario</button>
        </div>
    </div>

    <button type="button" onclick="agregarCurso()">+ Agregar curso</button>
    <br><br>
    <button type="submit">Guardar todo</button>
</form>

{{-- Variables JS generadas desde Blade --}}
<script>
    const diasSemanaOptions = `
        <option value="1">Lunes</option>
        <option value="2">Martes</option>
        <option value="3">Miércoles</option>
        <option value="4">Jueves</option>
        <option value="5">Viernes</option>
        <option value="6">Sábado</option>
        <option value="7">Domingo</option>
    `;

    const profesoresOptions = `
        @foreach ($profesores as $profesor)
            <option value="{{ $profesor->id }}">{{ $profesor->name }}</option>
        @endforeach
    `;
</script>

<script>
let cursoIndex = 1;

function agregarCurso() {
    const container = document.getElementById('cursos-container');
    const cursoHtml = `
        <div class="curso">
            <input type="text" name="cursos[${cursoIndex}][nombre]" required placeholder="Nombre del curso">
            <textarea name="cursos[${cursoIndex}][descripcion]" placeholder="Descripción del curso"></textarea>

            <label>Profesor:</label>
            <select name="cursos[${cursoIndex}][profesor_id]">
                ${profesoresOptions}
            </select>

            <h4>Horarios</h4>
            <div class="horarios-container">
                <div class="horario">
                    <select name="cursos[${cursoIndex}][horarios][0][dia_semana]">
                        ${diasSemanaOptions}
                    </select>
                    <input type="time" name="cursos[${cursoIndex}][horarios][0][hora_inicio]" required>
                    <input type="time" name="cursos[${cursoIndex}][horarios][0][hora_fin]" required>
                </div>
            </div>
            <button type="button" onclick="agregarHorario(this)">+ Agregar horario</button>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', cursoHtml);
    cursoIndex++;
}

function agregarHorario(button) {
    const cursoDiv = button.closest('.curso');
    const horariosContainer = cursoDiv.querySelector('.horarios-container');
    const indexCurso = Array.from(document.querySelectorAll('.curso')).indexOf(cursoDiv);
    const indexHorario = horariosContainer.querySelectorAll('.horario').length;

    const horarioHtml = `
        <div class="horario">
            <select name="cursos[${indexCurso}][horarios][${indexHorario}][dia_semana]">
                ${diasSemanaOptions}
            </select>
            <input type="time" name="cursos[${indexCurso}][horarios][${indexHorario}][hora_inicio]" required>
            <input type="time" name="cursos[${indexCurso}][horarios][${indexHorario}][hora_fin]" required>
        </div>
    `;
    horariosContainer.insertAdjacentHTML('beforeend', horarioHtml);
}
</script>

<hr>
<h2>📋 Cursos ya creados</h2>

@if ($cursos->isEmpty())
    <p>No hay cursos registrados aún.</p>
@else
    @php
        // Agrupar cursos primero por nombre de facultad
        $agrupadoPorFacultad = $cursos->groupBy(function($curso) {
            return $curso->carrera->facultad->nombre;
        });
    @endphp

    @foreach ($agrupadoPorFacultad as $nombreFacultad => $cursosFacultad)
        <h3 style="margin-top: 30px; color: navy;">🎓 Facultad: {{ $nombreFacultad }}</h3>

        @php
            // Agrupar por carrera dentro de la facultad
            $agrupadoPorCarrera = $cursosFacultad->groupBy(function($curso) {
                return $curso->carrera->nombre;
            });
        @endphp

        @foreach ($agrupadoPorCarrera as $nombreCarrera => $cursosCarrera)
            <h4 style="margin-left: 20px; color: teal;">📚 Carrera: {{ $nombreCarrera }}</h4>

            @foreach ($cursosCarrera as $curso)
                <div style="margin: 10px 40px 20px; border: 1px solid #ccc; padding: 10px; border-radius: 8px;">
                    <h5>📘 Curso: {{ $curso->nombre }}</h5>

                    <form action="{{ route('admin.cursos.destroy', $curso->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('¿Estás seguro de eliminar este curso?')" class="btn btn-danger btn-sm">
                            ❌ Eliminar curso
                        </button>
                    </form>

                    <p><strong>Descripción:</strong> {{ $curso->descripcion ?? 'Sin descripción' }}</p>

                    <p><strong>Horarios:</strong></p>
                    <ul>
                        @forelse ($curso->horarios as $horario)
                            <li>
                                Profesor: {{ $horario->profesor->name ?? 'No asignado' }} |
                                Día: {{ ['Lun','Mar','Mié','Jue','Vie','Sáb','Dom'][$horario->dia_semana - 1] }} |
                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $horario->hora_inicio)->format('H:i') }}
                                -
                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $horario->hora_fin)->format('H:i') }}
                                <strong> Periodo:</strong> {{ $horario->periodo->nombre ?? 'Sin periodo' }}
                            </li>
                        @empty
                            <li>No hay horarios asignados</li>
                        @endforelse
                    </ul>
                </div>
            @endforeach
        @endforeach
    @endforeach
@endif


