<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalificacionesController extends Controller
{
 public function index(Request $request)
    {
        // 1. Obtener todas las facultades y periodos para los filtros iniciales
        $facultades = DB::table('facultades')->get();
        $periodos = DB::table('periodos')->get();

        // 2. Inicializar colecciones vacías
        $carreras = collect();
        $cursos = collect();
        $profesores = collect();
        $calificaciones = collect();

        // 3. Si se seleccionó facultad, obtener sus carreras
        if ($request->filled('facultad_id')) {
            $carreras = DB::table('carreras')
                ->where('facultad_id', $request->facultad_id)
                ->get();
        }

        // 4. Si se seleccionó carrera y periodo, obtener cursos relacionados
        if ($request->filled('carrera_id') && $request->filled('periodo_id')) {
            $cursos = DB::table('curso_periodo')
                ->join('cursos', 'curso_periodo.curso_id', '=', 'cursos.id')
                ->join('carreras', 'cursos.carrera_id', '=', 'carreras.id')
                ->where('carreras.id', $request->carrera_id)
                ->where('curso_periodo.periodo_id', $request->periodo_id)
                ->select('curso_periodo.id as id', 'cursos.nombre as nombre', 'curso_periodo.seccion')
                ->get();
        }

        // 5. Si se seleccionó curso_periodo, obtener profesores que dictan ese curso
        if ($request->filled('curso_periodo_id')) {
            $profesores = DB::table('horarios')
                ->join('users', 'horarios.profesor_id', '=', 'users.id')
                ->where('horarios.curso_periodo_id', $request->curso_periodo_id)
                ->select('users.id', 'users.name')
                ->distinct()
                ->get();
        }

        // 6. Si se seleccionó curso_periodo y profesor, obtener calificaciones
        if ($request->filled('curso_periodo_id') && $request->filled('profesor_id')) {
            $calificaciones = DB::table('calificaciones')
                ->join('users', 'calificaciones.user_id', '=', 'users.id')
                ->where('calificaciones.curso_periodo_id', $request->curso_periodo_id)
                ->where('calificaciones.profesor_id', $request->profesor_id)
                ->select('users.name as alumno', 'calificaciones.*')
                ->get();
        }

        return view('admin.calificaciones', compact(
            'facultades', 'carreras', 'periodos', 'cursos', 'profesores', 'calificaciones', 'request'
        ));
    }
}
