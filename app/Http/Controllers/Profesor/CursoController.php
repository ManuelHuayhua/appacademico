<?php

namespace App\Http\Controllers\Profesor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class CursoController extends Controller
{
   public function index(Request $request)
{
    $profesorId = Auth::id();

    // Si no se pasa un periodo, se selecciona el actual (último cronológicamente)
    $periodoSeleccionado = $request->input('periodo_id');

    // Obtener todos los periodos (para el select)
    $periodos = DB::table('periodos')->orderBy('fecha_inicio', 'desc')->get();

    if (!$periodoSeleccionado && $periodos->isNotEmpty()) {
        $periodoSeleccionado = $periodos->first()->id;
    }

    // Obtener cursos asignados del profesor en ese periodo
    $cursos = DB::table('curso_periodo')
        ->join('cursos', 'curso_periodo.curso_id', '=', 'cursos.id')
        ->join('periodos', 'curso_periodo.periodo_id', '=', 'periodos.id')
        ->join('horarios', 'curso_periodo.id', '=', 'horarios.curso_periodo_id')
        ->where('horarios.profesor_id', $profesorId)
        ->where('curso_periodo.periodo_id', $periodoSeleccionado)
        ->select(
            'curso_periodo.id as curso_periodo_id',
            'cursos.nombre as curso',
            'periodos.nombre as periodo',
            'curso_periodo.seccion'
        )
        ->distinct()
        ->get();

    // Obtener alumnos
    $alumnosPorCurso = [];
    $fechasPorSemana = [];

    foreach ($cursos as $curso) {
        // Alumnos
        $alumnos = DB::table('matriculas')
            ->join('users', 'matriculas.user_id', '=', 'users.id')
            ->where('matriculas.curso_periodo_id', $curso->curso_periodo_id)
            ->select('users.id', 'users.name')
            ->get();

        $alumnosPorCurso[$curso->curso_periodo_id] = $alumnos;

        // Fechas por semana (esto ya lo tienes)
        $fechas = DB::table('asistencias')
            ->where('curso_periodo_id', $curso->curso_periodo_id)
            ->select('fecha')
            ->distinct()
            ->orderBy('fecha')
            ->pluck('fecha')
            ->map(fn($f) => Carbon::parse($f));

        $agrupadas = [];

        foreach ($fechas as $fecha) {
            $inicioSemana = $fecha->copy()->startOfWeek()->toDateString();
            $agrupadas[$inicioSemana][] = $fecha->toDateString();
        }

        $fechasPorSemana[$curso->curso_periodo_id] = $agrupadas;
    }

    return view('profesor.cursos', compact('cursos', 'alumnosPorCurso', 'fechasPorSemana', 'periodos', 'periodoSeleccionado'));
}

  public function guardarAsistencia(Request $request)
{
    $request->validate([
        'curso_periodo_id' => 'required|exists:curso_periodo,id',
        'asistencias' => 'required|array',
    ]);

    foreach ($request->asistencias as $userId => $asistenciasPorFecha) {
        foreach ($asistenciasPorFecha as $fecha => $asistio) {
            DB::table('asistencias')
                ->where('user_id', $userId)
                ->where('curso_periodo_id', $request->curso_periodo_id)
                ->where('fecha', $fecha)
                ->update([
                    'asistio' => $asistio,
                    'updated_at' => now(),
                ]);
        }
    }

    return back()->with('success', 'Asistencia guardada correctamente.');
}

}
