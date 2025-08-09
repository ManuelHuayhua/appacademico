<?php

namespace App\Http\Controllers\Profesor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Periodo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class ProfesorController extends Controller
{
public function index(Request $request)
{
    $profesorId = Auth::id();

    // 1. Obtener todos los periodos
    $periodos = DB::table('periodos')->orderBy('fecha_inicio', 'desc')->get();
    $hoy = Carbon::now('America/Lima');

// Buscar periodo actual basado en fecha
$periodoActual = $periodos->firstWhere(function ($periodo) use ($hoy) {
    return $hoy->between(Carbon::parse($periodo->fecha_inicio), Carbon::parse($periodo->fecha_fin));
});

$periodo_id = $request->get('periodo_id') ?? ($periodoActual->id ?? $periodos->first()->id);



    // 2. Cursos del profesor en el periodo
    $cursos = DB::table('horarios')
        ->join('curso_periodo', 'horarios.curso_periodo_id', '=', 'curso_periodo.id')
        ->join('cursos', 'curso_periodo.curso_id', '=', 'cursos.id')
        ->where('horarios.profesor_id', $profesorId)
        ->where('curso_periodo.periodo_id', $periodo_id)
        ->select('cursos.nombre', 'curso_periodo.seccion', 'curso_periodo.id as curso_periodo_id')
        ->distinct()
        ->get();

    // 3. Conteo de alumnos por curso
    $conteoAlumnos = [];
    foreach ($cursos as $curso) {
        $conteoAlumnos[$curso->nombre . ' - ' . $curso->seccion] = DB::table('matriculas')
            ->where('curso_periodo_id', $curso->curso_periodo_id)
            ->count();
    }

    // 4. Total de alumnos distintos
    $totalAlumnos = DB::table('matriculas')
        ->join('curso_periodo', 'matriculas.curso_periodo_id', '=', 'curso_periodo.id')
        ->join('horarios', 'curso_periodo.id', '=', 'horarios.curso_periodo_id')
        ->where('horarios.profesor_id', $profesorId)
        ->where('curso_periodo.periodo_id', $periodo_id)
        ->distinct('matriculas.user_id')
        ->count('matriculas.user_id');

    // 5. Distribución por género
    $generos = DB::table('matriculas')
        ->join('users', 'matriculas.user_id', '=', 'users.id')
        ->join('curso_periodo', 'matriculas.curso_periodo_id', '=', 'curso_periodo.id')
        ->join('horarios', 'curso_periodo.id', '=', 'horarios.curso_periodo_id')
        ->where('horarios.profesor_id', $profesorId)
        ->where('curso_periodo.periodo_id', $periodo_id)
        ->select('users.genero', DB::raw('count(distinct users.id) as total'))
        ->groupBy('users.genero')
        ->pluck('total', 'genero');

    // 6. Vacantes por curso
    $vacantesPorCurso = [];
    foreach ($cursos as $curso) {
        $info = DB::table('curso_periodo')->where('id', $curso->curso_periodo_id)->first();
        $matriculados = DB::table('matriculas')->where('curso_periodo_id', $curso->curso_periodo_id)->count();
        $vacantesPorCurso[$curso->nombre . ' - ' . $curso->seccion] = [
            'ocupadas' => $matriculados,
            'disponibles' => $info->vacantes - $matriculados,
        ];
    }

    // 7. Edad promedio, mínima y máxima
    $edadEstadistica = DB::table('matriculas')
        ->join('users', 'matriculas.user_id', '=', 'users.id')
        ->join('curso_periodo', 'matriculas.curso_periodo_id', '=', 'curso_periodo.id')
        ->join('horarios', 'curso_periodo.id', '=', 'horarios.curso_periodo_id')
        ->where('horarios.profesor_id', $profesorId)
        ->where('curso_periodo.periodo_id', $periodo_id)
        ->selectRaw('
            AVG(TIMESTAMPDIFF(YEAR, users.fecha_nacimiento, CURDATE())) as promedio,
            MIN(TIMESTAMPDIFF(YEAR, users.fecha_nacimiento, CURDATE())) as minima,
            MAX(TIMESTAMPDIFF(YEAR, users.fecha_nacimiento, CURDATE())) as maxima
        ')
        ->first();

    // 8. Cantidad de cursos
    $cantidadCursos = count($cursos);

    // 9. Días de la semana que enseña
    $diasSemana = DB::table('horarios')
        ->join('curso_periodo', 'horarios.curso_periodo_id', '=', 'curso_periodo.id')
        ->where('horarios.profesor_id', $profesorId)
        ->where('curso_periodo.periodo_id', $periodo_id)
        ->select('dia_semana')
        ->distinct()
        ->pluck('dia_semana')
        ->map(function ($dia) {
            return match ($dia) {
                1 => 'Lunes',
                2 => 'Martes',
                3 => 'Miércoles',
                4 => 'Jueves',
                5 => 'Viernes',
                6 => 'Sábado',
                7 => 'Domingo',
                default => 'Desconocido',
            };
        });

    // 10. Horas semanales
    $horasTotales = DB::table('horarios')
        ->join('curso_periodo', 'horarios.curso_periodo_id', '=', 'curso_periodo.id')
        ->where('horarios.profesor_id', $profesorId)
        ->where('curso_periodo.periodo_id', $periodo_id)
        ->selectRaw('SUM(TIMESTAMPDIFF(MINUTE, hora_inicio, hora_fin)) as minutos')
        ->value('minutos');

    $horasSemanales = round($horasTotales / 60, 2);

    // 11. 📅 Clases de HOY
    $hoy = Carbon::now('America/Lima');
    $diaHoy = $hoy->dayOfWeekIso;
    $horaActual = $hoy->format('H:i:s');

    $clasesHoy = DB::table('horarios')
        ->join('curso_periodo', 'horarios.curso_periodo_id', '=', 'curso_periodo.id')
        ->join('cursos', 'curso_periodo.curso_id', '=', 'cursos.id')
        ->where('horarios.profesor_id', $profesorId)
        ->where('curso_periodo.periodo_id', $periodo_id)
        ->where('horarios.dia_semana', $diaHoy)
        ->where('horarios.hora_fin', '>=', $horaActual)
        ->select('cursos.nombre', 'curso_periodo.seccion', 'horarios.hora_inicio', 'horarios.hora_fin')
        ->orderBy('horarios.hora_inicio')
        ->get();
        $inicioSemana = $hoy->copy()->startOfWeek(Carbon::MONDAY);
$finSemana = $hoy->copy()->endOfWeek(Carbon::SUNDAY);

$diasSemanaActual = collect(range($inicioSemana->dayOfWeekIso, $finSemana->dayOfWeekIso));

$clasesSemana = DB::table('horarios')
    ->join('curso_periodo', 'horarios.curso_periodo_id', '=', 'curso_periodo.id')
    ->join('cursos', 'curso_periodo.curso_id', '=', 'cursos.id')
    ->where('horarios.profesor_id', $profesorId)
    ->where('curso_periodo.periodo_id', $periodo_id)
     ->where('curso_periodo.fecha_inicio_clases', '<=', $hoy->toDateString()) // 👈 filtro extra
    ->where('curso_periodo.fecha_fin_clases', '>=', $hoy->toDateString())     // 👈 filtro extra
    ->whereIn('horarios.dia_semana', $diasSemanaActual)
    ->select('cursos.nombre', 'curso_periodo.seccion', 'horarios.hora_inicio', 'horarios.hora_fin', 'horarios.dia_semana')
    ->orderBy('horarios.dia_semana')
    ->orderBy('horarios.hora_inicio')
    ->get();

    // 12. 📅 Próximas clases (7 días)
    $diasProximos = collect(range(1, 7))
        ->map(fn($i) => $hoy->copy()->addDays($i));

    $clasesProximas = DB::table('horarios')
        ->join('curso_periodo', 'horarios.curso_periodo_id', '=', 'curso_periodo.id')
        ->join('cursos', 'curso_periodo.curso_id', '=', 'cursos.id')
        ->where('horarios.profesor_id', $profesorId)
        ->where('curso_periodo.periodo_id', $periodo_id)
        ->whereIn('horarios.dia_semana', $diasProximos->pluck('dayOfWeekIso'))
        ->select('cursos.nombre', 'curso_periodo.seccion', 'horarios.hora_inicio', 'horarios.hora_fin', 'horarios.dia_semana')
        ->get()
        ->sortBy([
            ['dia_semana', 'asc'],
            ['hora_inicio', 'asc'],
        ]);

    // Retorno final
    return view('profesor.profesor', compact(
        'periodos',
        'periodo_id',
        'cursos',
        'conteoAlumnos',
        'totalAlumnos',
        'generos',
        'vacantesPorCurso',
        'edadEstadistica',
        'cantidadCursos',
        'diasSemana',
        'horasSemanales',
        'clasesHoy',
        'clasesProximas',
        'clasesSemana' 
    ));
}
}