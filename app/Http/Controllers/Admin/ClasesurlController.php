<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CursoPeriodo;
use App\Models\Periodo;
use App\Models\Facultad;
use App\Models\Carrera;
use Carbon\Carbon;
class ClasesurlController extends Controller
{
    //muestra las clases virtuales de los cursos por periodo
public function index(Request $request)
{
    $facultades = Facultad::all();

    $facultad_id = $request->get('facultad_id');
    $carrera_id = $request->get('carrera_id');
    $periodo_id = $request->get('periodo_id');

    $carreras = $facultad_id ? Carrera::where('facultad_id', $facultad_id)->get() : collect();
    $cursosPeriodo = collect();
    $periodos = Periodo::orderBy('fecha_inicio', 'desc')->get();

    if ($carrera_id && $periodo_id) {
        $cursosPeriodo = CursoPeriodo::with('curso', 'periodo')
            ->where('periodo_id', $periodo_id)
            ->whereHas('curso', function ($q) use ($carrera_id) {
                $q->where('carrera_id', $carrera_id);
            })
            ->get();
    }

    return view('admin.clasesurl', compact(
        'facultades', 'carreras', 'periodos', 'cursosPeriodo',
        'facultad_id', 'carrera_id', 'periodo_id'
    ));
}

    //actualiza la url de la clase virtual del curso
  public function update(Request $request)
    {
        $request->validate([
            'curso_periodo_id' => 'required|exists:curso_periodo,id',
            'url_clase_virtual' => 'nullable|url'
        ]);

        $cursoPeriodo = CursoPeriodo::findOrFail($request->curso_periodo_id);
        $cursoPeriodo->url_clase_virtual = $request->url_clase_virtual;
        $cursoPeriodo->save();

        return back()->with('success', 'URL de clase virtual actualizada correctamente.');
    }
}
