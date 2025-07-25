<?php

namespace App\Http\Controllers\Profesor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CursoPeriodo;
use App\Models\Horario;
use App\Models\Calificacion;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Periodo;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
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
            ->select('users.*', 'calificaciones.id as calificacion_id', 'calificaciones.primer_avance', 'calificaciones.segundo_avance', 'calificaciones.presentacion_final', 'calificaciones.oral_1', 'calificaciones.oral_2', 'calificaciones.oral_3', 'calificaciones.oral_4', 'calificaciones.oral_5', 'calificaciones.examen_final', 'calificaciones.permiso')
            ->get();
    }

    return view('profesor.calificacionesprofesor', compact('cursos', 'alumnos', 'cursoSeleccionado', 'periodoSeleccionado', 'periodos'));
}

public function guardar(Request $request)
{
    $cursoId = $request->input('curso_periodo_id');

    foreach ($request->input('notas', []) as $userId => $nota) {
        $calificacion = Calificacion::where('user_id', $userId)
            ->where('curso_periodo_id', $cursoId)
            ->first();

        $permiso = $calificacion?->permiso ?? 'denegado';

        if (!$calificacion) {
            $calificacion = new Calificacion([
                'user_id' => $userId,
                'curso_periodo_id' => $cursoId,
                'permiso' => $permiso
            ]);
        }

        // Campos que puede editar según permiso
       $camposPermitidos = match ($permiso) {
    '1' => ['primer_avance'],
    '2' => ['segundo_avance'],
    '3' => ['presentacion_final'],
    '4' => ['oral_1'],
    '5' => ['oral_2'],
    '6' => ['oral_3'],
    '7' => ['oral_4'],
    '8' => ['oral_5'],
    '9' => ['examen_final'],
    'editable' => ['primer_avance', 'segundo_avance', 'presentacion_final', 'oral_1', 'oral_2', 'oral_3', 'oral_4', 'oral_5', 'examen_final'],
    default => []
};

        // Validar si hay campos permitidos
        if (empty($camposPermitidos)) {
            Session::flash('error', "No tienes permiso para editar la calificación del usuario ID $userId.");
            continue;
        }

        // Asignar solo los campos permitidos
        foreach ($camposPermitidos as $campo) {
            $calificacion->$campo = $nota[$campo] ?? null;
        }

        // Calcular promedios
        $promedioAvance = collect([
            $calificacion->primer_avance,
            $calificacion->segundo_avance,
            $calificacion->presentacion_final
        ])->filter()->avg();

        $promedioOrales = collect([
            $calificacion->oral_1,
            $calificacion->oral_2,
            $calificacion->oral_3,
            $calificacion->oral_4,
            $calificacion->oral_5
        ])->filter()->avg();

        $promedioEvaluacionPermanente = null;
        $promedioFinal = null;

        if (!is_null($promedioAvance) && !is_null($promedioOrales)) {
            $promedioEvaluacionPermanente = collect([$promedioAvance, $promedioOrales])->avg();

            if (!is_null($calificacion->examen_final)) {
                $promedioFinal = collect([$promedioEvaluacionPermanente, $calificacion->examen_final])->avg();
            }
        }

        // Si ya tiene código, mantenerlo
        $codigoCertificado = $calificacion->codigo_certificado;

        // Generar nuevo solo si no tenía y cumple condición
        if (is_null($codigoCertificado) && !is_null($promedioFinal) && $promedioFinal >= 10.5) {
            $codigoCertificado = 'CERT-' . strtoupper(Str::random(10));
        }

        // Guardar todo
        $calificacion->profesor_id = Auth::id();
        $calificacion->promedio_avance = $promedioAvance;
        $calificacion->promedio = $promedioOrales;
        $calificacion->promedio_evaluacion_permanente = $promedioEvaluacionPermanente;
        $calificacion->promedio_final = $promedioFinal;
        $calificacion->codigo_certificado = $codigoCertificado;

        $calificacion->save();
    }

    return back()->with('success', 'Calificaciones guardadas correctamente.');
}
}
