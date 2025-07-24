<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Periodo;
use App\Models\Calificacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\CalificacionProfesor;

class CalificadoProfesorController extends Controller
{
 public function index(Request $request)
{
    $periodos = Periodo::orderBy('fecha_inicio', 'desc')->get();
    $profesores = User::where('profesor', true)->orderBy('name')->get();

    $periodo_id = $request->get('periodo_id') ?? ($periodos->first()->id ?? null);
    $profesor_id = $request->get('profesor_id') ?? ($profesores->first()->id ?? null);

    if (!$periodo_id || !$profesor_id) {
        return view('admin.calificado_profesor', compact('periodos', 'profesores'))
            ->with('error', 'No hay periodos o profesores disponibles');
    }

    // Calificaciones del profesor y periodo seleccionado (detalle)
    $calificaciones = CalificacionProfesor::select(
        'calificaciones_profesor.*',
        'curso_periodo.curso_id',
        'cursos.nombre as curso_nombre',
        'users.name as profesor_nombre'
    )
    ->join('calificaciones', 'calificaciones_profesor.calificacion_id', '=', 'calificaciones.id')
    ->join('curso_periodo', 'calificaciones.curso_periodo_id', '=', 'curso_periodo.id')
    ->join('cursos', 'curso_periodo.curso_id', '=', 'cursos.id')
    ->join('users', 'calificaciones_profesor.profesor_id', '=', 'users.id')
    ->where('calificaciones_profesor.profesor_id', $profesor_id)
    ->where('curso_periodo.periodo_id', $periodo_id)
    ->get();

    foreach ($calificaciones as $cal) {
        $cal->promedio_preguntas = round((
            ($cal->pregunta_1 + $cal->pregunta_2 + $cal->pregunta_3 + $cal->pregunta_4 + $cal->pregunta_5) / 5
        ), 2);
    }

    $promediosPorCurso = $calificaciones
        ->groupBy('curso_id')
        ->map(function ($items) {
            return [
                'curso_nombre' => $items->first()->curso_nombre,
                'promedio_preguntas' => round($items->avg('promedio_preguntas'), 2),
                'cantidad_calificaciones' => $items->count(),
            ];
        });

    $promedioGeneral = round($calificaciones->avg('promedio_preguntas'), 2);

    // Profesores con promedio bajo en ese periodo
    $profesoresConPromedio = $profesores->map(function ($profesor) use ($periodo_id) {
        $calificaciones = CalificacionProfesor::select(
            'calificaciones_profesor.*',
            'curso_periodo.periodo_id'
        )
        ->join('calificaciones', 'calificaciones_profesor.calificacion_id', '=', 'calificaciones.id')
        ->join('curso_periodo', 'calificaciones.curso_periodo_id', '=', 'curso_periodo.id')
        ->where('calificaciones_profesor.profesor_id', $profesor->id)
        ->where('curso_periodo.periodo_id', $periodo_id)
        ->get();

        if ($calificaciones->isEmpty()) {
            $profesor->promedio_preguntas = null;
            return $profesor;
        }

        $promedios = $calificaciones->map(function ($cal) {
            return ($cal->pregunta_1 + $cal->pregunta_2 + $cal->pregunta_3 + $cal->pregunta_4 + $cal->pregunta_5) / 5;
        });

        $profesor->promedio_preguntas = round($promedios->avg(), 2);

        return $profesor;
    });

    $profesoresMalCalificados = $profesoresConPromedio
        ->filter(fn($p) => $p->promedio_preguntas !== null && $p->promedio_preguntas < 4)
        ->sortBy('promedio_preguntas');

    return view('admin.calificado_profesor', compact(
        'periodos', 'profesores', 'periodo_id', 'profesor_id',
        'promediosPorCurso', 'promedioGeneral', 'calificaciones', 'profesoresMalCalificados'
    ));
}
}
