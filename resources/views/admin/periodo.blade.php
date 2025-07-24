
<div class="container">
    <h2 class="mb-4">Gestión de Periodos Académicos</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Botón para abrir modal de nuevo periodo -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCrearPeriodo">
        Nuevo Periodo
    </button>
@error('fecha_inicio')
    <div class="text-danger small">{{ $message }}</div>
@enderror
    <!-- Tabla de periodos -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($periodos as $periodo)
            <tr>
                <td>{{ $periodo->nombre }}</td>
                <td>{{ $periodo->fecha_inicio }}</td>
                <td>{{ $periodo->fecha_fin }}</td>
                <td>
                    <!-- Botón para editar -->
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditarPeriodo{{ $periodo->id }}">
                        Editar
                    </button>

                    <!-- Formulario de eliminar -->
                    <form action="{{ route('admin.periodos.destroy', $periodo->id) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este periodo?')">Eliminar</button>
                    </form>
                </td>
            </tr>

            <!-- Modal de editar -->
            <!-- Modal para editar periodo -->
<div class="modal fade" id="modalEditarPeriodo{{ $periodo->id }}" tabindex="-1" aria-labelledby="modalEditarLabel{{ $periodo->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('admin.periodos.update', $periodo->id) }}">
        @csrf
        @method('PUT')
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalEditarLabel{{ $periodo->id }}">Editar Periodo</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" value="{{ $periodo->nombre }}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="fecha_inicio">Fecha Inicio</label>
                <input type="date" name="fecha_inicio" value="{{ $periodo->fecha_inicio }}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="fecha_fin">Fecha Fin</label>
                <input type="date" name="fecha_fin" value="{{ $periodo->fecha_fin }}" class="form-control" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Actualizar</button>
          </div>
        </div>
    </form>
  </div>
</div>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal para crear nuevo periodo -->
<div class="modal fade" id="modalCrearPeriodo" tabindex="-1" aria-labelledby="modalCrearLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('admin.periodos.store') }}">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalCrearLabel">Nuevo Periodo</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="fecha_inicio">Fecha Inicio</label>
                <input type="date" name="fecha_inicio" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="fecha_fin">Fecha Fin</label>
                <input type="date" name="fecha_fin" class="form-control" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </div>
    </form>
  </div>
</div>


<!-- Asegúrate de tener Bootstrap cargado -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>