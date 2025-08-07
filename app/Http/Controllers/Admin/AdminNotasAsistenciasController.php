<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Facultad;
use App\Models\Carrera;
use App\Models\Curso;
use App\Models\Periodo;
use App\Models\CursoPeriodo;
use App\Models\Matricula;
use App\Models\Calificacion;
use App\Exports\NotasAsistenciasExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\CarbonPeriod;
use Carbon\Carbon;
use App\Models\Horario;
use Illuminate\Support\Str;
class AdminNotasAsistenciasController extends Controller
{
  public function index(Request $request)
    {
        $facultades = Facultad::all();
        $periodos = Periodo::orderBy('id', 'desc')->get();

        $filtro = [
            'facultad_id' => $request->facultad_id,
            'carrera_id' => $request->carrera_id,
            'curso_id' => $request->curso_id,
            'periodo_id' => $request->periodo_id,
        ];

        $matriculas = collect();

        if ($request->filled(['facultad_id', 'carrera_id', 'curso_id', 'periodo_id'])) {
            $cursoPeriodo = CursoPeriodo::where('curso_id', $request->curso_id)
                ->where('periodo_id', $request->periodo_id)
                ->first();

            if ($cursoPeriodo) {
                $matriculas = Matricula::with(['user', 'user.calificaciones' => function ($q) use ($cursoPeriodo) {
                        $q->where('curso_periodo_id', $cursoPeriodo->id);
                    }, 'user.asistencias' => function ($q) use ($cursoPeriodo) {
                        $q->where('curso_periodo_id', $cursoPeriodo->id);
                    }])
                    ->whereHas('user', fn($q) => $q->where('usuario', true))
                    ->where('curso_periodo_id', $cursoPeriodo->id)
                    ->get();
            }
        }

        return view('admin.notas_y_asistencias', compact(
            'facultades', 'periodos', 'filtro', 'matriculas'
        ));
    }

public function actualizar(Request $request, $id)
{
    $calificacion = Calificacion::findOrFail($id);

    $data = $request->only([
        'primer_avance',
        'segundo_avance',
        'presentacion_final',
        'oral_1', 'oral_2', 'oral_3', 'oral_4', 'oral_5',
        'promedio_avance',
        'promedio',
        'promedio_evaluacion_permanente',
        'examen_final',
        'promedio_final'
    ]);

    $calificacion->update($data);

    // ✅ Verificar si se debe generar código de certificado
    if (
        is_null($calificacion->codigo_certificado) &&
        !is_null($calificacion->promedio_final) &&
        $calificacion->promedio_final >= 10.5
    ) {
        $calificacion->codigo_certificado = 'CERT-' . strtoupper(Str::random(10));
        $calificacion->save(); // 🔁 Guardar con el nuevo código
    }

    return back()->with('success', 'Notas actualizadas correctamente.');
}

public function exportExcel(Request $request)
{
    $cursoPeriodo = CursoPeriodo::where('curso_id', $request->curso_id)
        ->where('periodo_id', $request->periodo_id)
        ->first();

    if (!$cursoPeriodo) {
        return back()->with('error', 'Curso periodo no encontrado');
    }

    // Obtener los días de semana que tienen clases (1=Lunes,...,7=Domingo)
    $diasSemana = Horario::where('curso_periodo_id', $cursoPeriodo->id)
        ->pluck('dia_semana')
        ->unique()
        ->toArray();

    // Crear rango de fechas desde inicio a fin de clases
    $periodoFechas = CarbonPeriod::create($cursoPeriodo->fecha_inicio_clases, $cursoPeriodo->fecha_fin_clases);

    // Filtrar solo fechas que son días de clase
    $fechasClases = [];
    foreach ($periodoFechas as $fecha) {
        if (in_array($fecha->dayOfWeekIso, $diasSemana)) {
            $fechasClases[] = $fecha->format('Y-m-d');
        }
    }

    $matriculas = Matricula::with(['user', 'user.calificaciones' => function ($q) use ($cursoPeriodo) {
            $q->where('curso_periodo_id', $cursoPeriodo->id);
        }, 'user.asistencias' => function ($q) use ($cursoPeriodo) {
            $q->where('curso_periodo_id', $cursoPeriodo->id);
        }])
        ->whereHas('user', fn($q) => $q->where('usuario', true))
        ->where('curso_periodo_id', $cursoPeriodo->id)
        ->get();

    return Excel::download(new NotasAsistenciasExport($matriculas, $fechasClases), 'notas_asistencias.xlsx');
}

}