<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DictadoProfesor;
use App\Models\User;
use Carbon\Carbon;

class DictadoProfeController extends Controller
{
 public function index(Request $request)
{
    $query = DictadoProfesor::with('profesor')->orderBy('fecha_calificacion', 'desc');

    $fecha_inicio = $request->fecha_inicio ?? Carbon::today()->toDateString(); // hoy si no hay filtro
    $fecha_fin = $request->fecha_fin ?? Carbon::today()->toDateString(); // hoy si no hay filtro

    $query->where('fecha_calificacion', '>=', $fecha_inicio)
          ->where('fecha_calificacion', '<=', $fecha_fin);

    $dictados = $query->get();

    return view('admin.dictadoprofe', compact('dictados', 'fecha_inicio', 'fecha_fin'));

}

}
