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

        $existe = DB::table('matriculas')
            ->where('user_id', $request->user_id)
            ->where('curso_periodo_id', $request->curso_periodo_id)
            ->exists();

        if ($existe) {
            return back()->with('error', 'Este alumno ya está matriculado en este curso.');
        }

        DB::table('matriculas')->insert([
            'user_id' => $request->user_id,
            'curso_periodo_id' => $request->curso_periodo_id,
            'fecha_matricula' => now(),
            'estado' => 'activo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Alumno matriculado correctamente.');
    }


    //eliminar matricula
    public function destroy($id)
{
    DB::table('matriculas')->where('id', $id)->delete();

    return back()->with('success', 'Matrícula eliminada correctamente.');
}
}