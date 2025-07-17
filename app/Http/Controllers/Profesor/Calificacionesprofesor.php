<?php

namespace App\Http\Controllers\Profesor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CursoPeriodo;
use App\Models\Horario;
use App\Models\Calificacion;
use Illuminate\Support\Facades\DB;
use App\Models\Periodo;
use Carbon\Carbon;
use App\Models\User;
class Calificacionesprofesor extends Controller
{
  public function index(Request $request)
{
    $profesorId = Auth::id();
    $periodos = Periodo::orderByDesc('fecha_inicio')->get();

    // Si no se seleccionó periodo, usar el actual (por fecha)
    $periodoSeleccionado = $request->input('periodo_id');
    if (!$periodoSeleccionado) {
        $hoy = Carbon::now()->toDateString();
        $periodoActual = Periodo::where('fecha_inicio', '<=', $hoy)
            ->where('fecha_fin', '>=', $hoy)
            ->first();

        if ($periodoActual) {
            $periodoSeleccionado = $periodoActual->id;
        }
    }

    // Cursos del profesor en ese periodo
    $cursos = Horario::with('cursoPeriodo.curso')
        ->whereHas('cursoPeriodo', function ($q) use ($periodoSeleccionado) {
            $q->where('periodo_id', $periodoSeleccionado);
        })
        ->where('profesor_id', $profesorId)
        ->get()
        ->unique('curso_periodo_id');

    // Si se seleccionó un curso, buscar alumnos
    $cursoSeleccionado = $request->input('curso_periodo_id');
    $alumnos = [];

    if ($cursoSeleccionado) {
        $alumnos = DB::table('matriculas')
            ->join('users', 'users.id', '=', 'matriculas.user_id')
            ->leftJoin('calificaciones', function ($join) use ($cursoSeleccionado) {
                $join->on('users.id', '=', 'calificaciones.user_id')
                     ->where('calificaciones.curso_periodo_id', '=', $cursoSeleccionado);
            })
            ->where('matriculas.curso_periodo_id', $cursoSeleccionado)
            ->select('users.*', 'calificaciones.id as calificacion_id', 'calificaciones.primer_avance', 'calificaciones.segundo_avance', 'calificaciones.presentacion_final', 'calificaciones.oral_1', 'calificaciones.oral_2', 'calificaciones.oral_3', 'calificaciones.oral_4', 'calificaciones.oral_5', 'calificaciones.examen_final')
            ->get();
    }

    return view('profesor.calificacionesprofesor', compact('cursos', 'alumnos', 'cursoSeleccionado', 'periodoSeleccionado', 'periodos'));
}

public function guardar(Request $request)
{
    $cursoId = $request->input('curso_periodo_id');

    foreach ($request->input('notas', []) as $userId => $nota) {
        $primerAvance = $nota['primer_avance'];
        $segundoAvance = $nota['segundo_avance'];
        $presentacionFinal = $nota['presentacion_final'];

        $oral1 = $nota['oral_1'];
        $oral2 = $nota['oral_2'];
        $oral3 = $nota['oral_3'];
        $oral4 = $nota['oral_4'];
        $oral5 = $nota['oral_5'];

        $examenFinal = $nota['examen_final'];

        // Calcular promedios
        $promedioAvance = collect([$primerAvance, $segundoAvance, $presentacionFinal])->avg();
        $promedioOrales = collect([$oral1, $oral2, $oral3, $oral4, $oral5])->avg();

        $promedioEvaluacionPermanente = null;
        $promedioFinal = null;

        if (!is_null($promedioAvance) && !is_null($promedioOrales)) {
            $promedioEvaluacionPermanente = collect([$promedioAvance, $promedioOrales])->avg();

            if (!is_null($examenFinal)) {
                $promedioFinal = collect([$promedioEvaluacionPermanente, $examenFinal])->avg();
            }
        }

        Calificacion::updateOrCreate(
            [
                'user_id' => $userId,
                'curso_periodo_id' => $cursoId
            ],
            [
                'profesor_id' => Auth::id(),
                'primer_avance' => $primerAvance,
                'segundo_avance' => $segundoAvance,
                'presentacion_final' => $presentacionFinal,
                'oral_1' => $oral1,
                'oral_2' => $oral2,
                'oral_3' => $oral3,
                'oral_4' => $oral4,
                'oral_5' => $oral5,
                'examen_final' => $examenFinal,
                'promedio_avance' => $promedioAvance,
                'promedio' => $promedioOrales,
                'promedio_evaluacion_permanente' => $promedioEvaluacionPermanente,
                'promedio_final' => $promedioFinal,
            ]
        );
    }

    return back()->with('success', 'Calificaciones guardadas correctamente.');
}
}
