 <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<div class="container mt-4">
    <h3 class="mb-4">Notas y Asistencias de Alumnos</h3>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <label>Facultad</label>
            <select name="facultad_id" class="form-select" onchange="this.form.submit()">
                <option value="">-- Seleccionar --</option>
                @foreach($facultades as $fac)
                    <option value="{{ $fac->id }}" {{ request('facultad_id') == $fac->id ? 'selected' : '' }}>
                        {{ $fac->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label>Carrera</label>
            <select name="carrera_id" class="form-select" onchange="this.form.submit()">
                <option value="">-- Seleccionar --</option>
                @foreach(\App\Models\Carrera::where('facultad_id', request('facultad_id'))->get() as $car)
                    <option value="{{ $car->id }}" {{ request('carrera_id') == $car->id ? 'selected' : '' }}>
                        {{ $car->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label>Curso</label>
            <select name="curso_id" class="form-select" onchange="this.form.submit()">
                <option value="">-- Seleccionar --</option>
                @foreach(\App\Models\Curso::where('carrera_id', request('carrera_id'))->get() as $cur)
                    <option value="{{ $cur->id }}" {{ request('curso_id') == $cur->id ? 'selected' : '' }}>
                        {{ $cur->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label>Periodo</label>
            <select name="periodo_id" class="form-select" onchange="this.form.submit()">
                <option value="">-- Seleccionar --</option>
                @foreach($periodos as $per)
                    <option value="{{ $per->id }}" {{ request('periodo_id') == $per->id ? 'selected' : '' }}>
                        {{ $per->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    @if($matriculas->count())
    <div class="mb-3">
        <a href="{{ route('admin.notas.exportar', request()->query()) }}" class="btn btn-success">
            <i class="fas fa-file-excel"></i> Exportar a Excel
        </a>
    </div>
@endif

    @if($matriculas->count())
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Alumno</th>
                    <th>DNI</th>
                    <th>Primer Avance</th>
                    <th>Segundo Avance</th>
                    <th>Final</th>
                    <th>Promedio Final</th>
                    <th>Asistencias</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($matriculas as $matricula)
                    @php
                        $calificacion = $matricula->user->calificaciones->first();
                        $asistencias = $matricula->user->asistencias;
                        $asistenciasCount = $asistencias->count();
                        $asistenciasAsistio = $asistencias->where('asistio', true)->count();
                    @endphp
                    <tr>
                        <td>{{ $matricula->user->name }}</td>
                        <td>{{ $matricula->user->dni }}</td>
                        <td>{{ $calificacion->primer_avance ?? '-' }}</td>
                        <td>{{ $calificacion->segundo_avance ?? '-' }}</td>
                        <td>{{ $calificacion->presentacion_final ?? '-' }}</td>
                        <td>{{ $calificacion->promedio_final ?? '-' }}</td>
                        <td>
                            {{ $asistenciasAsistio }}/{{ $asistenciasCount }}
                            ({{ $asistenciasCount > 0 ? round(($asistenciasAsistio / $asistenciasCount) * 100, 1) : 0 }}%)
                        </td>
                        <td>
    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalNotas{{ $matricula->id }}">
        Editar
    </button>
</td>

                    </tr>
                @endforeach

                @foreach($matriculas as $matricula)
    @php
        $calificacion = $matricula->user->calificaciones->first();
    @endphp

    <!-- Modal -->
    <div class="modal fade" id="modalNotas{{ $matricula->id }}" tabindex="-1" aria-labelledby="modalNotasLabel{{ $matricula->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
             <form method="POST" action="{{ route('admin.notas.actualizar', $calificacion->id) }}">
    @csrf
    @method('PUT')

    <div class="modal-body">
        <div class="container-fluid">
            {{-- === Avances Académicos === --}}
            <div class="row mb-3">
                <div class="col-12">
                    <h5 class="text-primary">Avances Académicos</h5>
                    <hr>
                </div>
                <div class="col-md-4 mb-2">
                    <label class="form-label">Primer Avance</label>
                    <input type="number" step="0.01" name="primer_avance" class="form-control calc" value="{{ $calificacion->primer_avance }}">
                </div>
                <div class="col-md-4 mb-2">
                    <label class="form-label">Segundo Avance</label>
                    <input type="number" step="0.01" name="segundo_avance" class="form-control calc" value="{{ $calificacion->segundo_avance }}">
                </div>
                <div class="col-md-4 mb-2">
                    <label class="form-label">Presentación Final</label>
                    <input type="number" step="0.01" name="presentacion_final" class="form-control calc" value="{{ $calificacion->presentacion_final }}">
                </div>
                <div class="col-md-4 mb-2">
                    <label class="form-label fw-bold">Promedio Avance</label>
                    <input type="number" step="0.01" name="promedio_avance" class="form-control bg-light" id="promedio_avance{{ $matricula->id }}" readonly>
                </div>
            </div>

            {{-- === Evaluaciones Orales === --}}
            <div class="row mb-3">
                <div class="col-12">
                    <h5 class="text-primary">Evaluaciones Orales</h5>
                    <hr>
                </div>
                @for ($i = 1; $i <= 5; $i++)
                    <div class="col-md-2 mb-2">
                        <label class="form-label">Oral {{ $i }}</label>
                        <input type="number" step="0.01" name="oral_{{ $i }}" class="form-control calc" value="{{ $calificacion->{'oral_'.$i} }}">
                    </div>
                @endfor
                <div class="col-md-4 mt-3">
                    <label class="form-label fw-bold">Promedio Orales</label>
                    <input type="number" step="0.01" name="promedio" class="form-control bg-light" id="promedio_orales{{ $matricula->id }}" readonly>
                </div>
            </div>

            {{-- === Evaluación Permanente y Examen === --}}
            <div class="row mb-3">
                <div class="col-12">
                    <h5 class="text-primary">Evaluación Permanente y Final</h5>
                    <hr>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label fw-bold">Promedio Evaluación Permanente</label>
                    <input type="number" step="0.01" name="promedio_evaluacion_permanente" class="form-control bg-light" id="promedio_evaluacion_permanente{{ $matricula->id }}" readonly>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label">Examen Final</label>
                    <input type="number" step="0.01" name="examen_final" class="form-control calc" value="{{ $calificacion->examen_final }}">
                </div>
            </div>

            {{-- === Promedio Final === --}}
            <div class="row">
                <div class="col-md-12">
                    <label class="form-label fw-bold text-success">Promedio Final</label>
                    <input type="number" step="0.01" name="promedio_final" class="form-control bg-light" id="promedio_final{{ $matricula->id }}" readonly>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-success">
            <i class="fas fa-save me-1"></i> Guardar
        </button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i> Cancelar
        </button>
    </div>
</form>


<script>
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('input', function () {
            const id = this.id.replace('modalNotas', '');
            const getValue = (name) => {
                const input = modal.querySelector(`[name="${name}"]`);
                return input ? parseFloat(input.value) || 0 : 0;
            };

            const promAvance = (
                getValue('primer_avance') + getValue('segundo_avance') + getValue('presentacion_final')
            ) / 3;

            const orales = ['oral_1', 'oral_2', 'oral_3', 'oral_4', 'oral_5'];
            const promOrales = orales.reduce((sum, n) => sum + getValue(n), 0) / orales.length;

            const promEvalPermanente = (promAvance + promOrales) / 2;
            const promFinal = (promEvalPermanente + getValue('examen_final')) / 2;

            modal.querySelector(`#promedio_avance${id}`).value = promAvance.toFixed(2);
            modal.querySelector(`#promedio_orales${id}`).value = promOrales.toFixed(2);
            modal.querySelector(`#promedio_evaluacion_permanente${id}`).value = promEvalPermanente.toFixed(2);
            modal.querySelector(`#promedio_final${id}`).value = promFinal.toFixed(2);
        });

        // Dispara una vez al abrir
        modal.addEventListener('shown.bs.modal', () => modal.dispatchEvent(new Event('input')));
    });
</script>


            </div>
        </div>
    </div>
@endforeach

            </tbody>
        </table>
    @elseif(request()->filled(['facultad_id', 'carrera_id', 'curso_id', 'periodo_id']))
        <div class="alert alert-warning">No hay alumnos matriculados en este curso y periodo.</div>
    @endif
</div>

   <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>