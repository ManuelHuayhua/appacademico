<?php

namespace App\Http\Controllers\Profesor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Horario;
use Carbon\Carbon;
class CalendarioController extends Controller
{
 public function index()
    {
        $profesorId = Auth::id();

        $horarios = Horario::with(['cursoPeriodo.curso'])
            ->where('profesor_id', $profesorId)
            ->get();

        $eventos = [];

        foreach ($horarios as $horario) {
            $cursoPeriodo = $horario->cursoPeriodo;
            $curso = $cursoPeriodo->curso->nombre;
            $inicioClases = Carbon::parse($cursoPeriodo->fecha_inicio_clases);
            $finClases = Carbon::parse($cursoPeriodo->fecha_fin_clases);
            $horaInicio = $horario->hora_inicio;
            $horaFin = $horario->hora_fin;
            $diaSemana = $horario->dia_semana; // 1 = lunes

            // Recorremos todas las semanas desde inicio hasta fin
            $fecha = $inicioClases->copy()->startOfWeek(); // lunes de esa semana
            while ($fecha <= $finClases) {
                $fechaClase = $fecha->copy()->addDays($diaSemana - 1); // Día específico

                if ($fechaClase >= $inicioClases && $fechaClase <= $finClases) {
                    $eventos[] = [
                        'title' => $curso,
                        'start' => $fechaClase->format('Y-m-d') . 'T' . $horaInicio,
                        'end'   => $fechaClase->format('Y-m-d') . 'T' . $horaFin,
                        'extendedProps' => [
                            'curso'        => $curso,
                            'seccion'      => $cursoPeriodo->seccion,
                            'url'          => $cursoPeriodo->url_clase_virtual,
                            'monto'        => $cursoPeriodo->monto_total,
                            'horario'      => $horaInicio . ' - ' . $horaFin,
                            'fecha_inicio' => $cursoPeriodo->fecha_inicio_clases,
                            'fecha_fin'    => $cursoPeriodo->fecha_fin_clases,
                        ]
                    ];
                }

                $fecha->addWeek(); // siguiente semana
            }
        }

        return view('profesor.calendario', compact('eventos'));
    }

    
}
