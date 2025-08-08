<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asistencia;
use App\Models\Carrera;
use App\Models\CursoPeriodo;
use App\Models\Horario;
use App\Models\Periodo;
use App\Models\Facultad;
use App\Models\Curso;
use Illuminate\Support\Facades\DB;
class MaterialesController extends Controller
{
public function index(Request $request)
{
    $periodos = Periodo::orderBy('nombre')->get();

    // Obtener la fecha actual (solo fecha sin hora)
    $fechaHoy = now()->toDateString();

    // Buscar el periodo cuyo rango de fechas contenga la fecha actual
    $periodoActual = Periodo::where('fecha_inicio', '<=', $fechaHoy)
                            ->where('fecha_fin', '>=', $fechaHoy)
                            ->first();

    // Si no hay filtro de periodo enviado, asignar el periodo actual
    if (!$request->filled('periodo_id') && $periodoActual) {
        $request->merge(['periodo_id' => $periodoActual->id]);
    }

    $facultades = collect();
    $carreras = collect();
    $cursos = collect();
    $asistencias = collect();

    $hayFiltro = $request->filled('periodo_id') 
              && $request->filled('facultad_id') 
              && $request->filled('carrera_id') 
              && $request->filled('curso_id');

    if ($request->filled('periodo_id')) {
        $facultades = Facultad::whereHas('carreras.cursos.cursoPeriodos', function($q) use ($request) {
            $q->where('periodo_id', $request->periodo_id);
        })->orderBy('nombre')->get();
    }

    if ($request->filled('facultad_id')) {
        $carreras = Carrera::where('facultad_id', $request->facultad_id)
            ->whereHas('cursos.cursoPeriodos', function($q) use ($request) {
                if ($request->filled('periodo_id')) {
                    $q->where('periodo_id', $request->periodo_id);
                }
            })->orderBy('nombre')->get();
    }

    if ($request->filled('carrera_id')) {
        $cursos = CursoPeriodo::with('curso')
            ->whereHas('curso', fn($q) => $q->where('carrera_id', $request->carrera_id))
            ->when($request->filled('periodo_id'), fn($q) => 
                $q->where('periodo_id', $request->periodo_id)
            )
            ->orderBy('id')
            ->get()
            ->map(function($cp) {
                return (object) [
                    'id' => $cp->id,
                    'nombre' => "{$cp->curso->nombre} - {$cp->seccion}"
                ];
            });
    }

    if ($hayFiltro) {
        $query = Asistencia::with([
                'cursoPeriodo.curso.carrera.facultad',
                'cursoPeriodo.periodo'
            ])
            ->select(
                DB::raw('MAX(asistencias.id) as id'),
                'fecha',
                'curso_periodo_id',
                DB::raw('MAX(url_material) as url_material'),
                DB::raw('MAX(url_grabada) as url_grabada')
            )
            ->join('curso_periodo', 'asistencias.curso_periodo_id', '=', 'curso_periodo.id')
            ->groupBy('fecha', 'curso_periodo_id', 'curso_periodo.seccion')
            ->orderBy('fecha', 'asc');

        $query->whereHas('cursoPeriodo', fn($q) => $q->where('periodo_id', $request->periodo_id));
        $query->whereHas('cursoPeriodo.curso.carrera', fn($q) => $q->where('facultad_id', $request->facultad_id));
        $query->whereHas('cursoPeriodo.curso', fn($q) => $q->where('carrera_id', $request->carrera_id));
        $query->where('curso_periodo_id', $request->curso_id);

        $asistencias = $query->get();
    }

    return view('admin.materiales', compact('asistencias', 'periodos', 'facultades', 'carreras', 'cursos', 'hayFiltro'));
}


    public function update(Request $request, $id)
    {
        $request->validate([
            'url_material' => 'nullable|url',
            'url_grabada' => 'nullable|url'
        ]);

        $asistencia = Asistencia::findOrFail($id);

        // Actualizar todas las asistencias del mismo curso_periodo y fecha
        Asistencia::where('curso_periodo_id', $asistencia->curso_periodo_id)
            ->where('fecha', $asistencia->fecha)
            ->update([
                'url_material' => $request->input('url_material'),
                'url_grabada' => $request->input('url_grabada')
            ]);

        return redirect()->back()->with('success', 'Material actualizado para todo el grupo.');
    }

    //actulizar todas de golpe si esque hay registros nuevo --
public function syncLinksFaltantes(Request $request)
{
    $cursoPeriodoId = $request->input('curso_periodo_id');

    if (!$cursoPeriodoId) {
        return redirect()->back()->with('error', 'Falta el curso_periodo_id para sincronizar.');
    }

    // Obtener todas las fechas distintas de ese curso_periodo
    $fechas = Asistencia::where('curso_periodo_id', $cursoPeriodoId)
        ->distinct()
        ->pluck('fecha');

    $totalActualizados = 0;

    foreach ($fechas as $fecha) {
        // Buscar un registro con links para ese curso_periodo y fecha
        $registroConLinks = Asistencia::where('curso_periodo_id', $cursoPeriodoId)
            ->where('fecha', $fecha)
            ->whereNotNull('url_material')
            ->whereNotNull('url_grabada')
            ->first();

        if ($registroConLinks) {
            // Actualizar los registros sin links para ese curso_periodo y fecha
            $actualizados = Asistencia::where('curso_periodo_id', $cursoPeriodoId)
                ->where('fecha', $fecha)
                ->where(function ($query) {
                    $query->whereNull('url_material')
                          ->orWhere('url_material', '')
                          ->orWhereNull('url_grabada')
                          ->orWhere('url_grabada', '');
                })
                ->update([
                    'url_material' => $registroConLinks->url_material,
                    'url_grabada' => $registroConLinks->url_grabada,
                ]);

            $totalActualizados += $actualizados;
        }
    }

    return redirect()->back()->with('success', "Se actualizaron $totalActualizados registros con enlaces faltantes.");
}
}

