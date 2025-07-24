<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Facultad;
use App\Models\Carrera;
use App\Models\Curso;

class CursoSilaboController extends Controller
{
   public function index(Request $request)
{
    $facultades = Facultad::all();

    $facultadSeleccionada = $request->input('facultad_id');
    $carreraSeleccionada = $request->input('carrera_id');

    $carreras = [];
    $cursos = [];

    if ($facultadSeleccionada) {
        $carreras = Carrera::where('facultad_id', $facultadSeleccionada)->get();
    }

    if ($carreraSeleccionada) {
        $cursos = Curso::where('carrera_id', $carreraSeleccionada)->get();
    }

    return view('admin.curso_silabo', compact(
        'facultades',
        'carreras',
        'cursos',
        'facultadSeleccionada',
        'carreraSeleccionada'
    ));
}

 public function update(Request $request, $cursoId)
    {
        $curso = Curso::findOrFail($cursoId);
        $curso->silabus_url = $request->silabus_url;
        $curso->save();

        return redirect()->back()->with('success', 'URL del sílabo actualizada correctamente.');
    }
}
