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
        'user_id' => 'required|exists:users,id',
        'curso_periodo_id' => 'required|exists:curso_periodo,id',
    ]);

    // Verificar si ya existe la matrícula
    $existe = DB::table('matriculas')
        ->where('user_id', $request->user_id)
        ->where('curso_periodo_id', $request->curso_periodo_id)
        ->exists();

    if ($existe) {
        return back()->with('error', 'Este alumno ya está matriculado en este curso.');
    }

    try {
        // Insertar la matrícula y obtener su ID
        $matricula_id = DB::table('matriculas')->insertGetId([
            'user_id' => $request->user_id,
            'curso_periodo_id' => $request->curso_periodo_id,
            'fecha_matricula' => now(),
            'estado' => 'activo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Obtener fechas de clase del curso_periodo
        $cursoPeriodo = DB::table('curso_periodo')->where('id', $request->curso_periodo_id)->first();

        // Obtener los días de la semana en que hay clase
        $diasClase = DB::table('horarios')
            ->where('curso_periodo_id', $request->curso_periodo_id)
            ->pluck('dia_semana')
            ->toArray(); // Ej: [1, 3, 5] => lunes, miércoles, viernes

        // Generar fechas entre inicio y fin de clases que coincidan con los días de clase
        $fechaInicio = \Carbon\Carbon::parse($cursoPeriodo->fecha_inicio_clases);
        $fechaFin = \Carbon\Carbon::parse($cursoPeriodo->fecha_fin_clases);
        $fechasClase = [];

        for ($fecha = $fechaInicio->copy(); $fecha <= $fechaFin; $fecha->addDay()) {
            if (in_array($fecha->dayOfWeekIso, $diasClase)) {
                $fechasClase[] = $fecha->toDateString();
            }
        }

        // Insertar asistencias vacías por cada fecha
        foreach ($fechasClase as $fecha) {
            DB::table('asistencias')->insert([
                'user_id' => $request->user_id,
                'curso_periodo_id' => $request->curso_periodo_id,
                'fecha' => $fecha,
                'asistio' => null, // Aún no tomada
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return back()->with('success', 'Alumno matriculado correctamente y asistencias generadas.');
    } catch (\Exception $e) {
        return back()->with('error', 'Error al matricular: ' . $e->getMessage());
    }
}


    //eliminar matricula
public function destroy($id)
{
    // Buscar la matrícula primero
    $matricula = DB::table('matriculas')->where('id', $id)->first();

    if ($matricula) {
        // Eliminar las asistencias relacionadas
        DB::table('asistencias')
            ->where('user_id', $matricula->user_id)
            ->where('curso_periodo_id', $matricula->curso_periodo_id)
            ->delete();

        // Luego eliminar la matrícula
        DB::table('matriculas')->where('id', $id)->delete();

        return back()->with('success', 'Matrícula y asistencias eliminadas correctamente.');
    }

    return back()->with('error', 'La matrícula no fue encontrada.');
}
}