<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CursoPeriodo;
use Illuminate\Support\Facades\DB;
class MatriculaController extends Controller

{
    public function create()
    {
        $alumnos = User::where('usuario', true)->get();
        $cursos = CursoPeriodo::with('curso', 'periodo')->get();

       // Obtener las matrículas actuales
    $matriculas = DB::table('matriculas')
        ->join('users', 'matriculas.user_id', '=', 'users.id')
        ->join('curso_periodo', 'matriculas.curso_periodo_id', '=', 'curso_periodo.id')
        ->join('cursos', 'curso_periodo.curso_id', '=', 'cursos.id')
        ->join('periodos', 'curso_periodo.periodo_id', '=', 'periodos.id')
        ->select(
            'matriculas.id',
            'users.name as alumno',
            'cursos.nombre as curso',
            'periodos.nombre as periodo',
            'curso_periodo.seccion',
            'matriculas.fecha_matricula',
            'matriculas.estado'
        )
        ->orderBy('matriculas.fecha_matricula', 'desc')
        ->get();

    return view('admin.matricula', compact('alumnos', 'cursos', 'matriculas'));
    }



public function store(Request $request)
{
    $request->validate([
        'user_ids' => 'required|array',
        'user_ids.*' => 'exists:users,id',
        'curso_periodo_id' => 'required|exists:curso_periodo,id',
    ]);

    // Obtener información del curso_periodo, incluyendo vacantes
    $cursoPeriodo = DB::table('curso_periodo')->where('id', $request->curso_periodo_id)->first();

    // Contar cuántos alumnos ya están matriculados en ese curso
    $matriculadosActuales = DB::table('matriculas')
        ->where('curso_periodo_id', $request->curso_periodo_id)
        ->count();

    // Calcular cuántas vacantes quedan
    $vacantesDisponibles = $cursoPeriodo->vacantes - $matriculadosActuales;

    // Filtrar alumnos que aún no están matriculados
    $alumnosParaMatricular = collect($request->user_ids)->reject(function ($user_id) use ($request) {
        return DB::table('matriculas')
            ->where('user_id', $user_id)
            ->where('curso_periodo_id', $request->curso_periodo_id)
            ->exists();
    });

    // Verificar si hay vacantes suficientes
    if ($alumnosParaMatricular->count() > $vacantesDisponibles) {
        return back()->with('error', 'No hay suficientes vacantes para matricular a todos los alumnos seleccionados. Quedan solo ' . $vacantesDisponibles . ' vacante(s).');
    }

    // Obtener días de clase
    $diasClase = DB::table('horarios')
        ->where('curso_periodo_id', $request->curso_periodo_id)
        ->pluck('dia_semana')
        ->toArray();

    // Fechas de clases
    $fechaInicio = \Carbon\Carbon::parse($cursoPeriodo->fecha_inicio_clases);
    $fechaFin = \Carbon\Carbon::parse($cursoPeriodo->fecha_fin_clases);
    $fechasClase = [];

    for ($fecha = $fechaInicio->copy(); $fecha <= $fechaFin; $fecha->addDay()) {
        if (in_array($fecha->dayOfWeekIso, $diasClase)) {
            $fechasClase[] = $fecha->toDateString();
        }
    }

    // Obtener profesor del curso
    $profesorId = DB::table('horarios')
        ->where('curso_periodo_id', $request->curso_periodo_id)
        ->value('profesor_id');

    // Matricular alumnos
    $contador = 0;
    foreach ($alumnosParaMatricular as $user_id) {

        DB::table('matriculas')->insert([
            'user_id' => $user_id,
            'curso_periodo_id' => $request->curso_periodo_id,
            'fecha_matricula' => now(),
            'estado' => 'activo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        foreach ($fechasClase as $fecha) {
            DB::table('asistencias')->insert([
                'user_id' => $user_id,
                'curso_periodo_id' => $request->curso_periodo_id,
                'fecha' => $fecha,
                'asistio' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::table('calificaciones')->insert([
            'user_id' => $user_id,
            'curso_periodo_id' => $request->curso_periodo_id,
            'profesor_id' => $profesorId,
            'carrera_id' => $cursoPeriodo->carrera_id ?? null,
            'primer_avance' => null,
            'segundo_avance' => null,
            'presentacion_final' => null,
            'promedio_avance' => null,
            'oral_1' => null,
            'oral_2' => null,
            'oral_3' => null,
            'oral_4' => null,
            'oral_5' => null,
            'promedio' => null,
            'promedio_evaluacion_permanente' => null,
            'examen_final' => null,
            'promedio_final' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $contador++;
    }

    if ($contador > 0) {
        return back()->with('success', "$contador alumno(s) matriculado(s) correctamente.");
    } else {
        return back()->with('error', 'Ningún alumno fue matriculado (posiblemente ya estaban inscritos).');
    }
}


    //eliminar matricula
public function destroy($id)
{
    // Buscar la matrícula primero
    $matricula = DB::table('matriculas')->where('id', $id)->first();

    if ($matricula) {
        // Eliminar asistencias relacionadas
        DB::table('asistencias')
            ->where('user_id', $matricula->user_id)
            ->where('curso_periodo_id', $matricula->curso_periodo_id)
            ->delete();

        // Eliminar calificación relacionada
        DB::table('calificaciones')
            ->where('user_id', $matricula->user_id)
            ->where('curso_periodo_id', $matricula->curso_periodo_id)
            ->delete();

        // Eliminar matrícula
        DB::table('matriculas')->where('id', $id)->delete();

        return back()->with('success', 'Matrícula, asistencias y calificación eliminadas correctamente.');
    }

    return back()->with('error', 'La matrícula no fue encontrada.');
}
}