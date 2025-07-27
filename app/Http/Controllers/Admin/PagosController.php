<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CursoPeriodo;
use App\Models\Calificacion;
use App\Models\User;
use App\Models\Matricula;
use App\Models\Periodo;
use Carbon\Carbon;

class PagosController extends Controller
{
 public function index(Request $request)
{
    $hoy = Carbon::today();
    $periodoId = $request->input('periodo_id');
    $periodos = Periodo::orderBy('fecha_inicio', 'desc')->get();

    // Si no se seleccionó ningún periodo en el filtro
    if (!$periodoId) {
        // Intentar buscar el periodo actual (activo en la fecha de hoy)
        $periodoActual = Periodo::whereDate('fecha_inicio', '<=', $hoy)
            ->whereDate('fecha_fin', '>=', $hoy)
            ->first();

        if ($periodoActual) {
            $periodoId = $periodoActual->id;
        } else {
            // Si no hay periodo actual, buscar el último más reciente que ya pasó
            $ultimoPeriodo = Periodo::whereDate('fecha_fin', '<', $hoy)
                ->orderBy('fecha_fin', 'desc')
                ->first();

            if ($ultimoPeriodo) {
                $periodoId = $ultimoPeriodo->id;
            } else {
                // No hay ningún periodo registrado aún → retornar vacío
                return view('admin.pagos', [
                    'datos' => collect(),
                    'periodos' => $periodos,
                    'periodoId' => null
                ]);
            }
        }
    }

    // Ya tenemos un periodoId válido, cargar los datos de ese periodo
    $datos = CursoPeriodo::with(['curso', 'periodo', 'calificaciones.alumno'])
        ->where('periodo_id', $periodoId)
        ->get();

    return view('admin.pagos', compact('datos', 'periodos', 'periodoId'));
}

public function registrarPago(Request $request) 
{
    $request->validate([
        'calificacion_id' => 'required|exists:calificaciones,id',
        'monto' => 'required|numeric|min:0.01',
    ]);

    $calificacion = Calificacion::findOrFail($request->calificacion_id);

    $montoTotal = $calificacion->cursoPeriodo->monto_total ?? 0;
    $montoPagadoActual = $calificacion->monto_pago ?? 0;
    $nuevoMonto = $request->monto;

    // Verifica si se excede el monto total
    if (($montoPagadoActual + $nuevoMonto) > $montoTotal) {
        return redirect()->back()->with('error', 'El monto ingresado supera el total del curso.');
    }

    $nuevoMontoPagado = $montoPagadoActual + $nuevoMonto;
    $pagoRealizado = $nuevoMontoPagado >= $montoTotal;

    $calificacion->update([
        'monto_pago' => $nuevoMontoPagado,
        'pago_realizado' => $pagoRealizado,
    ]);

    return redirect()->back()->with('success', 'Pago registrado correctamente.');
}

// Actualizar monto del curso
public function actualizarMontoCurso(Request $request)
{
    $request->validate([
        'curso_periodo_id' => 'required|exists:curso_periodo,id',
        'monto_total' => 'required|numeric|min:0.01',
    ]);

    $curso = CursoPeriodo::findOrFail($request->curso_periodo_id);
    $curso->monto_total = $request->monto_total;
    $curso->save();

    return redirect()->back()->with('success', 'Monto del curso actualizado correctamente.');
}


}
