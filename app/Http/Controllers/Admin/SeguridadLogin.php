<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoginLog;
use Carbon\Carbon;

class SeguridadLogin extends Controller
{
     public function index(Request $request)
    {
        // Tomamos fechas del request
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        if (!$fechaInicio || !$fechaFin) {
            // 👉 Por defecto mostramos solo el día actual
            $fechaInicio = Carbon::today()->startOfDay();
            $fechaFin = Carbon::today()->endOfDay();
        } else {
            // 👉 Convertimos las fechas para abarcar todo el rango
            $fechaInicio = Carbon::parse($fechaInicio)->startOfDay();
            $fechaFin = Carbon::parse($fechaFin)->endOfDay();
        }

        $logs = LoginLog::with('user')
            ->whereBetween('logged_in_at', [$fechaInicio, $fechaFin])
            ->orderBy('logged_in_at', 'desc')
            ->paginate(20);

        // Total de accesos en el rango
        $totalLogs = $logs->total();

        return view('admin.seguridadlogin', compact('logs', 'fechaInicio', 'fechaFin', 'totalLogs'));
    }
}
