<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Periodo;
use App\Models\Facultad;
use App\Models\Carrera;
use App\Models\Curso;
use App\Models\User;
use App\Models\CursoPeriodo;
use App\Models\Calificacion;
use App\Models\Horario;
use Illuminate\Support\Facades\DB;

class Librearnotas extends Controller
{
  public function index(Request $request)
    {
        $facultades = Facultad::all();
        $periodos = Periodo::orderBy('fecha_inicio', 'desc')->get();

        $carreras = collect();
        $cursos = collect();
        $cursoPeriodosPorCurso = [];

        if ($request->filled('facultad_id')) {
            $carreras = Carrera::where('facultad_id', $request->facultad_id)->get();
        }

        if ($request->filled(['facultad_id', 'carrera_id', 'periodo_id'])) {
            $cursos = Curso::where('carrera_id', $request->carrera_id)
                ->whereIn('id', function ($q) use ($request) {
                    $q->select('curso_id')
                        ->from('curso_periodo')
                        ->where('periodo_id', $request->periodo_id);
                })
                ->get();

            foreach ($cursos as $curso) {
                $cursoPeriodos = CursoPeriodo::where('curso_id', $curso->id)
                    ->where('periodo_id', $request->periodo_id)
                    ->get();

                foreach ($cursoPeriodos as $cp) {
                    $profesores = User::where('profesor', true)
                        ->whereIn('id', Calificacion::where('curso_periodo_id', $cp->id)->pluck('profesor_id')->unique())
                        ->get();

                    $cursoPeriodosPorCurso[$curso->id][] = [
                        'curso_periodo' => $cp,
                        'profesores' => $profesores
                    ];
                }
            }
        }

        return view('admin.librerarnotas', compact(
            'facultades',
            'periodos',
            'carreras',
            'cursos',
            'cursoPeriodosPorCurso',
            'request'
        ));
    }

   public function cambiarPermisoCurso(Request $request)
{
    $cursoPeriodoId = $request->input('curso_periodo_id');
    $profesorId = $request->input('profesor_id');
    $permiso = $request->input('permiso');

    // Validar que el permiso esté permitido
    $valoresPermitidos = ['1','2','3','4','5','6','7','8','9','editable','denegado'];

    if (!in_array($permiso, $valoresPermitidos)) {
        return redirect()->back()->with('error', 'Permiso inválido.');
    }

    // Actualiza solo los registros de ese curso y profesor
    Calificacion::where('curso_periodo_id', $cursoPeriodoId)
        ->where('profesor_id', $profesorId)
        ->update(['permiso' => $permiso]);

    return redirect()->back()->with('success', 'Permiso actualizado correctamente.');
}
}
