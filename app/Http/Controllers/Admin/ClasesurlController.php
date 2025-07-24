<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CursoPeriodo;
use App\Models\Periodo;
use Carbon\Carbon;
class ClasesurlController extends Controller
{
    //muestra las clases virtuales de los cursos por periodo
 public function index(Request $request)
    {
        $periodos = Periodo::orderBy('fecha_inicio', 'desc')->get();
        $hoy = Carbon::now()->toDateString();

        // Buscar el periodo actual por fechas
        $periodoActual = $periodos->first(function ($p) use ($hoy) {
            return $p->fecha_inicio <= $hoy && $p->fecha_fin >= $hoy;
        });

        // Verificar si se ha seleccionado un periodo manualmente
        $periodoSeleccionado = $request->get('periodo_id') ?? ($periodoActual ? $periodoActual->id : null);

        // Si no hay periodo válido, enviar vista sin resultados
        if (!$periodoSeleccionado) {
            return view('admin.clasesurl', [
                'periodos' => $periodos,
                'cursosPeriodo' => collect(),
                'periodoSeleccionado' => null,
                'mensaje' => 'No hay un periodo activo actualmente. Por favor, selecciona uno manualmente.'
            ]);
        }

        $cursosPeriodo = CursoPeriodo::with('curso', 'periodo')
            ->where('periodo_id', $periodoSeleccionado)
            ->get();

        return view('admin.clasesurl', [
            'periodos' => $periodos,
            'cursosPeriodo' => $cursosPeriodo,
            'periodoSeleccionado' => $periodoSeleccionado,
            'mensaje' => null
        ]);
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
