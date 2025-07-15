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
    public function index()
{
    $profesorId = Auth::id();

    $cursos = DB::table('curso_periodo')
        ->join('cursos', 'curso_periodo.curso_id', '=', 'cursos.id')
        ->join('periodos', 'curso_periodo.periodo_id', '=', 'periodos.id')
        ->join('horarios', 'curso_periodo.id', '=', 'horarios.curso_periodo_id')
        ->where('horarios.profesor_id', $profesorId)
        ->select(
            'curso_periodo.id as curso_periodo_id',
            'curso_periodo.fecha_inicio_clases',
            'curso_periodo.fecha_fin_clases',
            'cursos.nombre as curso',
            'periodos.nombre as periodo',
            'curso_periodo.seccion'
        )
        ->distinct()
        ->get();

    $alumnosPorCurso = [];
    $fechasPorSemana = [];

    foreach ($cursos as $curso) {
        // Alumnos matriculados
        $alumnos = DB::table('matriculas')
            ->join('users', 'matriculas.user_id', '=', 'users.id')
            ->where('matriculas.curso_periodo_id', $curso->curso_periodo_id)
            ->select('users.id', 'users.name')
            ->get();
        $alumnosPorCurso[$curso->curso_periodo_id] = $alumnos;

        // Fechas de clase por semana
        $diasClase = DB::table('horarios')
            ->where('curso_periodo_id', $curso->curso_periodo_id)
            ->pluck('dia_semana')
            ->toArray(); // [1, 3, 5]

        $inicio = Carbon::parse($curso->fecha_inicio_clases);
        $fin = Carbon::parse($curso->fecha_fin_clases);
        $periodo = CarbonPeriod::create($inicio, $fin);

        $semanas = [];

        foreach ($periodo as $fecha) {
            if (in_array($fecha->dayOfWeekIso, $diasClase)) {
                $semana = $fecha->copy()->startOfWeek(Carbon::MONDAY)->format('Y-m-d');
                $semanas[$semana][] = $fecha->format('Y-m-d');
            }
        }

        $fechasPorSemana[$curso->curso_periodo_id] = $semanas;
    }

    return view('profesor.cursos', compact('cursos', 'alumnosPorCurso', 'fechasPorSemana'));
}

    public function guardarAsistencia(Request $request)
{
    $request->validate([
        'fecha' => 'required|date',
        'curso_periodo_id' => 'required|exists:curso_periodo,id',
        'asistencias' => 'required|array',
    ]);

    foreach ($request->asistencias as $userId => $asistio) {
        DB::table('asistencias')
            ->where('user_id', $userId)
            ->where('curso_periodo_id', $request->curso_periodo_id)
            ->where('fecha', $request->fecha)
            ->update([
                'asistio' => $asistio,
                'updated_at' => now(),
            ]);
    }

    return back()->with('success', 'Asistencia guardada correctamente.');
}

}
