<?php

namespace App\Http\Controllers\Alumnos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Matricula;
use App\Models\Calificacion;
use App\Models\Periodo;

class ComprobanteController extends Controller
{
public function index(Request $request)
{
    $alumnoId = Auth::id();

    // Obtener todos los periodos para el <select>
    $periodos = Periodo::whereHas('cursoPeriodos.matriculas', function ($query) use ($alumnoId) {
    $query->where('user_id', $alumnoId);
})
->orderBy('fecha_inicio', 'desc')
->get();

    // Si no se selecciona un periodo, usamos el actual (hoy entre inicio y fin)
    $periodoSeleccionado = $request->input('periodo_id');

    if (!$periodoSeleccionado) {
        $periodoActual = Periodo::where('fecha_inicio', '<=', now())
                                ->where('fecha_fin', '>=', now())
                                ->first();

        $periodoSeleccionado = $periodoActual ? $periodoActual->id : null;
    }

    // Obtener matrículas del alumno solo del periodo seleccionado
    $matriculas = Matricula::with(['cursoPeriodo.curso', 'cursoPeriodo.periodo'])
        ->where('user_id', $alumnoId)
        ->whereHas('cursoPeriodo', function ($query) use ($periodoSeleccionado) {
            $query->where('periodo_id', $periodoSeleccionado);
        })
        ->get();

    $datos = $matriculas->map(function ($matricula) use ($alumnoId) {
        $cursoPeriodo = $matricula->cursoPeriodo;
        $calificacion = Calificacion::where('user_id', $alumnoId)
            ->where('curso_periodo_id', $cursoPeriodo->id)
            ->first();

        return [
            'curso' => $cursoPeriodo->curso->nombre,
            'periodo' => $cursoPeriodo->periodo->nombre,
            'seccion' => $cursoPeriodo->seccion,
            'turno' => $cursoPeriodo->turno,
            'monto_total' => $cursoPeriodo->monto_total,
            'monto_pagado' => $calificacion->monto_pago ?? 0,
            'restante' => ($cursoPeriodo->monto_total ?? 0) - ($calificacion->monto_pago ?? 0),
            'completo' => ($calificacion && $calificacion->monto_pago >= $cursoPeriodo->monto_total),
        ];
    });

    return view('comprobante', compact('datos', 'periodos', 'periodoSeleccionado'));
}
}
