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
use Illuminate\Support\Facades\DB;
use App\Models\CursoPeriodo;
class CursoController extends Controller
{

    

public function create()
{
       $profesores = User::where('profesor', true)->get();
    $periodos = Periodo::all();
    $facultades = Facultad::all();
    $carreras = Carrera::all();
    $cursos = Curso::with(['carrera.facultad', 'cursoPeriodos.horarios.profesor', 'cursoPeriodos.periodo'])->get();

    return view('admin.crearcurso', compact('profesores', 'periodos', 'cursos','facultades', 'carreras'));
}

public function store(Request $request)
{
    $request->validate([
        'periodo_id' => 'required|exists:periodos,id',
    ]);

    DB::beginTransaction();
    try {
        $mensajesRepetidos = [];
        $mensajesCreados = [];

        // Facultad
        $facultad = $request->facultad_existente
            ? Facultad::findOrFail($request->facultad_existente)
            : Facultad::firstOrCreate(['nombre' => trim(ucwords(strtolower($request->facultad_nombre)))]);

        // Carrera
        $carrera = $request->carrera_existente
            ? Carrera::findOrFail($request->carrera_existente)
            : Carrera::firstOrCreate([
                'nombre' => trim(ucwords(strtolower($request->carrera_nombre))),
                'facultad_id' => $facultad->id,
            ]);

        $periodoId = $request->periodo_id;

        foreach ($request->cursos as $cursoData) {
            if (empty($cursoData['nombre'])) continue;

            $nombreCurso = trim(ucwords(strtolower($cursoData['nombre'])));

            // Buscar curso existente
            $curso = Curso::firstOrCreate(
                [
                    'nombre' => $nombreCurso,
                    'carrera_id' => $carrera->id
                ],
                [
                    'descripcion' => $cursoData['descripcion'] ?? null
                ]
            );

            // Verificar si ya existe el mismo curso + periodo + sección
            $cursoPeriodoExistente = CursoPeriodo::where('curso_id', $curso->id)
                ->where('periodo_id', $periodoId)
                ->where('seccion', $cursoData['seccion'])
                ->first();

            if ($cursoPeriodoExistente) {
                $mensajesRepetidos[] = "El curso \"{$nombreCurso}\" con sección \"{$cursoData['seccion']}\" ya existe en este periodo.";
                continue;
            }

            // Crear curso_periodo y sus horarios
            $cursoPeriodo = CursoPeriodo::create([
                'curso_id' => $curso->id,
                'periodo_id' => $periodoId,
                'seccion' => $cursoData['seccion'],
                'turno' => $cursoData['turno'] ?? 'mañana',
                'fecha_apertura_matricula' => $cursoData['fecha_apertura_matricula'],
                'fecha_cierre_matricula' => $cursoData['fecha_cierre_matricula'],
                'fecha_inicio_clases' => $cursoData['fecha_inicio_clases'],
                'fecha_fin_clases' => $cursoData['fecha_fin_clases'],
                'vacantes' => $cursoData['vacantes'] ?? 30,
            ]);

            if (isset($cursoData['horarios']) && is_array($cursoData['horarios'])) {
                foreach ($cursoData['horarios'] as $horarioData) {
                    Horario::create([
                        'curso_periodo_id' => $cursoPeriodo->id,
                        'profesor_id' => $cursoData['profesor_id'] ?? null,
                        'dia_semana' => $horarioData['dia_semana'],
                        'hora_inicio' => $horarioData['hora_inicio'],
                        'hora_fin' => $horarioData['hora_fin'],
                    ]);
                }
            }

            $mensajesCreados[] = "Curso \"{$nombreCurso}\" con sección \"{$cursoData['seccion']}\" creado correctamente.";
        }

        DB::commit();

        return redirect()->route('admin.cursos.create')->with([
            'success' => $mensajesCreados,
            'warning' => $mensajesRepetidos
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->withInput()->with('error', 'Error al guardar: ' . $e->getMessage());
    }
}

public function destroy(Curso $curso)
{
    // Primero elimina los horarios de cada CursoPeriodo
    foreach ($curso->cursoPeriodos as $cursoPeriodo) {
        $cursoPeriodo->horarios()->delete(); // ✅ Elimina los horarios relacionados
        $cursoPeriodo->delete();              // ✅ Luego elimina el curso_periodo
    }

    // Finalmente, elimina el curso
    $curso->delete();

    return redirect()->route('admin.cursos.create')->with('success', ['Curso eliminado correctamente.']);
}
}


