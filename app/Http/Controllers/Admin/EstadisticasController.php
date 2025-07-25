<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Periodo;
use App\Models\Facultad;
use App\Models\Matricula;
use App\Models\Curso;
use App\Models\CursoPeriodo;
use App\Models\Asistencia;
use App\Models\User;
use Illuminate\Support\Facades\DB;
class EstadisticasController extends Controller
{
public function index(Request $request)
    {
        $periodos = Periodo::orderBy('fecha_inicio', 'desc')->get();
        $periodoId = $request->input('periodo_id') ?? $periodos->first()?->id;

        // Facultades con relaciones
        $facultades = Facultad::with([
            'carreras.cursos.cursoPeriodos' => function ($q) use ($periodoId) {
                $q->where('periodo_id', $periodoId)->withCount('matriculas');
            }
        ])->get();

        // Totales
        $totalMatriculas = Matricula::whereHas('cursoPeriodo', fn($q) => $q->where('periodo_id', $periodoId))->count();

        $totalCursos = CursoPeriodo::where('periodo_id', $periodoId)->count();

        $totalProfesores = DB::table('horarios')
            ->join('curso_periodo', 'horarios.curso_periodo_id', '=', 'curso_periodo.id')
            ->where('curso_periodo.periodo_id', $periodoId)
            ->distinct('profesor_id')
            ->count('profesor_id');

     

        // Distribución por género
        $generos = Matricula::whereHas('cursoPeriodo', fn($q) => $q->where('periodo_id', $periodoId))
            ->join('users', 'matriculas.user_id', '=', 'users.id')
            ->selectRaw('genero, COUNT(*) as total')
            ->groupBy('genero')->pluck('total', 'genero');

        // Top cursos con más alumnos
        $topCursos = CursoPeriodo::with('curso')
            ->where('periodo_id', $periodoId)
            ->withCount('matriculas')
            ->orderByDesc('matriculas_count')
            ->take(5)
            ->get();

        return view('admin.admin', compact(
            'periodos', 'periodoId', 'facultades', 'totalMatriculas',
            'totalCursos', 'totalProfesores',
            'generos', 'topCursos'
        ));
    }
}
