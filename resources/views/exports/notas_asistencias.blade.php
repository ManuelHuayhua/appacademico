<table>
    <thead>
        <tr>
            <th>Alumno</th>
            <th>DNI</th>
            <th>Primer Avance</th>
            <th>Segundo Avance</th>
            <th>Presentación Final</th>
            <th>Promedio Avance</th>
            <th>Orales (1-5)</th>
            <th>Promedio Orales</th>
            <th>Evaluación Permanente</th>
            <th>Examen Final</th>
            <th>Promedio Final</th>

            {{-- Fechas dinámicas --}}
            @foreach($fechasClases as $fecha)
                <th>{{ \Carbon\Carbon::parse($fecha)->format('d/m') }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($matriculas as $matricula)
            @php
                $cal = $matricula->user->calificaciones->first();
                // Indexamos asistencias por fecha para acceso rápido
                $asistencias = $matricula->user->asistencias->keyBy(function($item) {
                    return \Carbon\Carbon::parse($item->fecha)->format('Y-m-d');
                });
            @endphp
            <tr>
                <td>{{ $matricula->user->name }}</td>
                <td>{{ $matricula->user->dni }}</td>
                <td>{{ $cal->primer_avance ?? '-' }}</td>
                <td>{{ $cal->segundo_avance ?? '-' }}</td>
                <td>{{ $cal->presentacion_final ?? '-' }}</td>
                <td>{{ $cal->promedio_avance ?? '-' }}</td>
                <td>
                    {{ $cal->oral_1 }}, {{ $cal->oral_2 }}, {{ $cal->oral_3 }},
                    {{ $cal->oral_4 }}, {{ $cal->oral_5 }}
                </td>
                <td>{{ $cal->promedio ?? '-' }}</td>
                <td>{{ $cal->promedio_evaluacion_permanente ?? '-' }}</td>
                <td>{{ $cal->examen_final ?? '-' }}</td>
                <td>{{ $cal->promedio_final ?? '-' }}</td>

                {{-- Por cada fecha, marcar asistencia --}}
                @foreach($fechasClases as $fecha)
                    @php
                        $asistio = $asistencias->has($fecha) ? $asistencias[$fecha]->asistio : false;
                    @endphp
                    <td style="text-align: center;">{{ $asistio ? '✓' : '✗' }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
