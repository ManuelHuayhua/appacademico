<div class="container">
    <h2>📘 Mis cursos matriculados</h2>

    @if($cursos->isEmpty())
        <p>No estás matriculado en ningún curso actualmente.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Curso</th>
                    <th>Descripción</th>
                    <th>Periodo</th>
                    <th>Sección</th>
                    <th>Fecha de matrícula</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cursos as $curso)
                    <tr>
                        <td>{{ $curso->curso }}</td>
                        <td>{{ $curso->descripcion ?? '—' }}</td>
                        <td>{{ $curso->periodo }}</td>
                        <td>{{ $curso->seccion }}</td>
                        <td>{{ \Carbon\Carbon::parse($curso->fecha_matricula)->format('d/m/Y') }}</td>
                        <td>{{ ucfirst($curso->estado) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>