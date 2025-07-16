<?php

namespace App\Http\Controllers\Alumnos;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CalificacionalumnoController extends Controller
{
  public function index(Request $request)
{
    $userId = Auth::id();

    // Si el alumno seleccionó un periodo, lo usamos; si no, usamos el activo por fecha
    if ($request->filled('periodo_id')) {
        $periodo = DB::table('periodos')->where('id', $request->periodo_id)->first();
    } else {
        $hoy = Carbon::now()->toDateString();
        $periodo = DB::table('periodos')
            ->where('fecha_inicio', '<=', $hoy)
            ->where('fecha_fin', '>=', $hoy)
            ->first();
    }

    // Obtener todos los periodos donde el alumno ha tenido cursos
    $periodosDisponibles = DB::table('calificaciones')
        ->join('curso_periodo', 'calificaciones.curso_periodo_id', '=', 'curso_periodo.id')
        ->join('periodos', 'curso_periodo.periodo_id', '=', 'periodos.id')
        ->where('calificaciones.user_id', $userId)
        ->select('periodos.id', 'periodos.nombre')
        ->distinct()
        ->orderBy('periodos.fecha_inicio', 'desc')
        ->get();

    $calificaciones = collect(); // valor por defecto

    if ($periodo) {
        $calificaciones = DB::table('calificaciones')
            ->join('curso_periodo', 'calificaciones.curso_periodo_id', '=', 'curso_periodo.id')
            ->join('cursos', 'curso_periodo.curso_id', '=', 'cursos.id')
            ->join('periodos', 'curso_periodo.periodo_id', '=', 'periodos.id')
            ->leftJoin('users as profesores', 'calificaciones.profesor_id', '=', 'profesores.id')
            ->where('calificaciones.user_id', $userId)
            ->where('curso_periodo.periodo_id', $periodo->id)
            ->select(
                'cursos.nombre as curso',
                'periodos.nombre as periodo',
                'curso_periodo.seccion',
                'profesores.name as profesor',
                'calificaciones.*'
            )
            ->get();
    }

    return view('calificaciones', [
        'calificaciones' => $calificaciones,
        'periodos' => $periodosDisponibles,
        'periodoSeleccionado' => $periodo
    ]);
}
}
