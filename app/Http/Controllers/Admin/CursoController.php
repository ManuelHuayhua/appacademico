<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Curso;
use App\Models\Horario;
use App\Models\Facultad;
use App\Models\Carrera;
use App\Models\Periodo;
class CursoController extends Controller
{
public function create()
{
       $profesores = User::where('profesor', true)->get();
    $periodos = Periodo::all();
    $facultades = Facultad::all();
    $carreras = Carrera::all();
    $cursos = Curso::with(['carrera.facultad', 'horarios.profesor', 'horarios.periodo'])->get();

    return view('admin.crearcurso', compact('profesores', 'periodos', 'cursos','facultades', 'carreras'));
}

public function store(Request $request)
{
    $request->validate([
        'periodo_id' => 'required|exists:periodos,id',
    ]);

    // 🔁 Nueva lógica: usar facultad/carrera existente o crear nueva
    $facultadId = $request->facultad_existente;
    if ($facultadId) {
        $facultad = Facultad::findOrFail($facultadId);
    } else {
       $facultadNombre = trim(ucwords(strtolower($request->facultad_nombre)));
$facultad = Facultad::firstOrCreate(['nombre' => $facultadNombre]);
    }

    $carreraId = $request->carrera_existente;
    if ($carreraId) {
        $carrera = Carrera::findOrFail($carreraId);
    } else {
      $carreraNombre = trim(ucwords(strtolower($request->carrera_nombre)));
$carrera = Carrera::firstOrCreate([
    'nombre' => $carreraNombre,
    'facultad_id' => $facultad->id,
]);
    }

    $periodoId = $request->periodo_id;

    foreach ($request->cursos as $cursoData) {
    if (empty($cursoData['nombre'])) continue;

    $curso = Curso::create([
        'nombre' => $cursoData['nombre'],
        'descripcion' => $cursoData['descripcion'] ?? null,
        'carrera_id' => $carrera->id
    ]);

    $profesorId = $cursoData['profesor_id'] ?? null;

    if (isset($cursoData['horarios']) && is_array($cursoData['horarios'])) {
        foreach ($cursoData['horarios'] as $horarioData) {
            
           Horario::create([
    'curso_id' => $curso->id,
    'profesor_id' => $profesorId,
    'dia_semana' => $horarioData['dia_semana'],
    'hora_inicio' => $horarioData['hora_inicio'],
    'hora_fin' => $horarioData['hora_fin'],
    'periodo_id' => $periodoId, // 👈 usa esto siempre
]);
        }
    }
}

    return redirect()->route('admin.cursos.create')->with('success', 'Cursos y horarios creados correctamente.');
}

public function destroy(Curso $curso)
{
    // Elimina primero los horarios relacionados
    $curso->horarios()->delete();

    // Luego elimina el curso
    $curso->delete();

    return redirect()->back()->with('success', 'Curso eliminado correctamente.');
}

}


