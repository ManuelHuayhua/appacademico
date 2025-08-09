<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VerprofesorController extends Controller
{


        //evista de los horarios que maneja el profesor
    public function index()
    {
        $hoy = Carbon::now()->toDateString();

        // 1. Buscar el periodo actual
        $periodoActual = DB::table('periodos')
            ->where('fecha_inicio', '<=', $hoy)
            ->where('fecha_fin', '>=', $hoy)
            ->first();

        if (!$periodoActual) {
            return view('admin.verprofesor', [
                'profesores' => [],
                'mensaje' => 'No hay un periodo activo en este momento.'
            ]);
        }

        // 2. Buscar horarios con profesores para este periodo
      $profesores = DB::table('horarios')
    ->join('curso_periodo', 'horarios.curso_periodo_id', '=', 'curso_periodo.id')
    ->join('cursos', 'curso_periodo.curso_id', '=', 'cursos.id')
    ->join('carreras', 'cursos.carrera_id', '=', 'carreras.id')
    ->join('users', 'horarios.profesor_id', '=', 'users.id')
    ->where('curso_periodo.periodo_id', $periodoActual->id)
    ->where('curso_periodo.fecha_inicio_clases', '<=', $hoy) // 👈 clases ya empezaron
    ->where('curso_periodo.fecha_fin_clases', '>=', $hoy)   // 👈 clases aún no terminan
    ->select(
        'users.id AS profesor_id',
        'users.name AS profesor',
        'cursos.nombre AS curso',
        'curso_periodo.seccion',
        'curso_periodo.url_clase_virtual',
        'carreras.nombre AS carrera',
        'horarios.dia_semana',
        'horarios.hora_inicio',
        'horarios.hora_fin'
    )
    ->orderBy('users.name')
    ->orderBy('horarios.dia_semana')
    ->get();

        return view('admin.verprofesor', compact('profesores', 'periodoActual'));
    }



    //evaluar al profesor 
     public function storeEvaluacion(Request $request)
    {
        $request->validate([
            'profesor_id' => 'required|exists:users,id',
            'estado_dictado' => 'required|in:bien,mal',
        ]);

        DB::table('dictado_profesor')->insert([
            'profesor_id' => $request->profesor_id,
            'estado_dictado' => $request->estado_dictado,
            'fecha_calificacion' => now()->toDateString(),
            'hora_calificacion' => now()->format('H:i:s'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Evaluación registrada correctamente.');
    }

  

}


