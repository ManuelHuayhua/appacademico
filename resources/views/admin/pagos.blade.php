

<!-- Bootstrap 5.3.2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container py-4">
    <h2 class="mb-4 text-primary fw-bold">Control de Pagos de Alumnos</h2>


    <!-- Filtro de Periodo Académico -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.pagos') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="periodo_id" class="form-label">Periodo Académico</label>
                    <select name="periodo_id" id="periodo_id" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Todos los periodos --</option>
                        @foreach ($periodos as $periodo)
                            <option value="{{ $periodo->id }}" {{ $periodo->id == $periodoId ? 'selected' : '' }}>
                                {{ $periodo->nombre }} ({{ \Carbon\Carbon::parse($periodo->fecha_inicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($periodo->fecha_fin)->format('d/m/Y') }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
@endif


<!-- Filtro por Curso -->
<!-- Filtro por Curso -->
<div class="container mt-4">
    <div class="row justify-content-end">
        <div class="col-md-4">
            <input type="text" id="filtro-curso" class="form-control" placeholder="Buscar por curso">
        </div>
    </div>
</div>

<!-- Resultados -->
@forelse($datos as $curso)
    <div class="card mb-4 border-0 shadow-sm tarjeta-curso">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <strong>Curso:</strong> <span class="nombre-curso">{{ $curso->curso->nombre ?? 'Sin nombre' }}</span><br>
                    <strong>Sección:</strong> {{ $curso->seccion }}
                </div>
                <div>
                    <strong>Periodo:</strong> {{ $curso->periodo->nombre ?? 'Sin periodo' }}
                </div>
            </div>
        </div>

        <!-- Filtros de búsqueda -->
        <div class="row m-3">
            <div class="col-md-3">
                <input type="text" id="filtro-alumno" class="form-control" placeholder="Buscar por alumno">
            </div>
            <div class="col-md-3">
                <input type="text" id="filtro-dni" class="form-control" placeholder="Buscar por DNI">
            </div>
            <div class="col-md-3">
                <select id="filtro-estado" class="form-select">
                    <option value="">-- Estado --</option>
                    <option value="Pagado">Pagado</option>
                    <option value="Pendiente">Pendiente</option>
                </select>
            </div>
        </div>

        <div class="card-body">
            <p class="mb-3"><strong>Monto Total del Curso:</strong> S/ {{ number_format($curso->monto_total, 2) }}</p>

            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle tabla-pagos">
                    <thead class="table-light">
                        <tr>
                            <th>Alumno</th>
                            <th>DNI</th>
                            <th>Email</th>
                            <th class="text-end">Monto Pagado</th>
                            <th class="text-end">Deuda</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($curso->calificaciones as $cal)
                            @php
                                $pagado = $cal->monto_pago ?? 0;
                                $deuda = max(0, $curso->monto_total - $pagado);
                                $estado = ($cal->pago_realizado || $deuda <= 0) ? 'Pagado' : 'Pendiente';
                            @endphp
                            @if($cal->alumno && $cal->alumno->usuario)
                                <tr>
                                    <td class="alumno-nombre">{{ $cal->alumno->name }} {{ $cal->alumno->apellido_p }} {{ $cal->alumno->apellido_m }}</td>
                                    <td class="alumno-dni">{{ $cal->alumno->dni }}</td>
                                    <td>{{ $cal->alumno->email }}</td>
                                    <td class="text-end">S/ {{ number_format($pagado, 2) }}</td>
                                    <td class="text-end">S/ {{ number_format($deuda, 2) }}</td>
                                    <td class="text-center alumno-estado">
                                        @if($estado == 'Pagado')
                                            <span class="badge bg-success">Pagado</span>
                                        @else
                                            <span class="badge bg-danger">Pendiente</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalPago{{$cal->id}}">
                                            Registrar Pago
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal de pago -->
                                <div class="modal fade" id="modalPago{{$cal->id}}" tabindex="-1" aria-labelledby="modalPagoLabel{{$cal->id}}" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <form method="POST" action="{{ route('admin.registrarPago') }}">
                                        @csrf
                                        <input type="hidden" name="calificacion_id" value="{{ $cal->id }}">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalPagoLabel{{$cal->id}}">Registrar Pago - {{ $cal->alumno->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="monto" class="form-label">Monto a Registrar</label>
                                                    <input type="number" step="0.01" name="monto" class="form-control" required>
                                                </div>
                                                <p><strong>Deuda actual:</strong> S/ {{ number_format($deuda, 2) }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Guardar Pago</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            </div>
                                        </div>
                                    </form>
                                  </div>
                                </div>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@empty
    <div class="alert alert-warning text-center">
        No se encontraron cursos para el periodo seleccionado.
    </div>
@endforelse

<!-- Filtro JS -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Filtro por nombre del curso
    const inputCurso = document.getElementById('filtro-curso');
    inputCurso.addEventListener('input', function () {
        const filtro = inputCurso.value.toLowerCase();
        document.querySelectorAll('.tarjeta-curso').forEach(function (tarjeta) {
            const nombreCurso = tarjeta.querySelector('.nombre-curso')?.textContent.toLowerCase() || '';
            tarjeta.style.display = nombreCurso.includes(filtro) ? '' : 'none';
        });
    });

    // Filtros internos por alumno, dni, estado
    const inputAlumno = document.getElementById('filtro-alumno');
    const inputDNI = document.getElementById('filtro-dni');
    const selectEstado = document.getElementById('filtro-estado');

    function filtrarTabla() {
        const nombreFiltro = inputAlumno.value.toLowerCase();
        const dniFiltro = inputDNI.value.toLowerCase();
        const estadoFiltro = selectEstado.value;

        document.querySelectorAll('.tabla-pagos tbody tr').forEach(function (fila) {
            const nombre = fila.querySelector('.alumno-nombre')?.textContent.toLowerCase() || '';
            const dni = fila.querySelector('.alumno-dni')?.textContent.toLowerCase() || '';
            const estado = fila.querySelector('.alumno-estado')?.textContent.trim() || '';

            const coincideNombre = nombre.includes(nombreFiltro);
            const coincideDNI = dni.includes(dniFiltro);
            const coincideEstado = !estadoFiltro || estado === estadoFiltro;

            fila.style.display = (coincideNombre && coincideDNI && coincideEstado) ? '' : 'none';
        });
    }

    inputAlumno.addEventListener('input', filtrarTabla);
    inputDNI.addEventListener('input', filtrarTabla);
    selectEstado.addEventListener('change', filtrarTabla);
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>