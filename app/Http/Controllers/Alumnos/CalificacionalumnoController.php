<?php

namespace App\Http\Controllers\Alumnos;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\CalificacionProfesor;
use App\Models\Calificacion;

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
            ->get()
        ->map(function ($cal) {
            if (!($cal->pago_realizado && $cal->califica_profesor)) {
                $cal->codigo_certificado = null; // 🔐 Seguridad aquí
            }
            return $cal;
        });
    }

    return view('calificaciones', [
        'calificaciones' => $calificaciones,
        'periodos' => $periodosDisponibles,
        'periodoSeleccionado' => $periodo
    ]);
}


   public function guardarCalificacion(Request $request, $id)
    {
        $request->validate([
            'pregunta_1' => 'required|integer|min:1|max:5',
            'pregunta_2' => 'required|integer|min:1|max:5',
            'pregunta_3' => 'required|integer|min:1|max:5',
            'pregunta_4' => 'required|integer|min:1|max:5',
            'pregunta_5' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string',
        ]);

        $calificacion = Calificacion::findOrFail($id);

        // Evita duplicado si ya se calificó
        if ($calificacion->califica_profesor) {
            return redirect()->back()->with('info', 'Ya has calificado a este profesor.');
        }

        // Si no hay comentario, usar "calificado"
        $comentario = $request->comentario ?: 'calificado';

        // Guardar la calificación del profesor
        CalificacionProfesor::create([
            'calificacion_id' => $id,
            'profesor_id' => $calificacion->profesor_id,
            'pregunta_1' => $request->pregunta_1,
            'pregunta_2' => $request->pregunta_2,
            'pregunta_3' => $request->pregunta_3,
            'pregunta_4' => $request->pregunta_4,
            'pregunta_5' => $request->pregunta_5,
            'comentario' => $comentario,
        ]);

        // Actualizar estado en calificaciones
        $calificacion->update(['califica_profesor' => true]);

        return redirect()->back()->with('success', 'Gracias por calificar al profesor.');
    }

}
