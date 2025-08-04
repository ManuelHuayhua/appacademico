<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Retiro;
use App\Models\Calificacion;
use App\Models\User;
use App\Models\Periodo;
use Carbon\Carbon;
use App\Models\CursoPeriodo;
class RetiradosController extends Controller
{
 public function index(Request $request)
{
    $campoNota = $request->get('nota', 'primer_avance');
    $hoy = Carbon::today();

    $periodoId = $request->get('periodo_id') ?? Periodo::where('fecha_inicio', '<=', $hoy)
        ->where('fecha_fin', '>=', $hoy)
        ->first()?->id;

    $retiros = Retiro::with([
        'user',
        'cursoPeriodo.curso.carrera.facultad',
        'periodo'
    ])
    ->when($periodoId, function ($query) use ($periodoId) {
        $query->where('periodo_id', $periodoId);
    })
    ->orderBy('fecha_retiro', 'desc')
    ->get();

    $profesores = User::where('profesor', true)->get();

    $profesoresSinNotas = [];

    foreach ($profesores as $profesor) {
        $cursos = CursoPeriodo::where('periodo_id', $periodoId)
            ->whereHas('calificaciones', function ($q) use ($profesor) {
                $q->where('profesor_id', $profesor->id);
            })
            ->with(['curso', 'calificaciones' => function ($q) use ($profesor) {
                $q->where('profesor_id', $profesor->id);
            }])
            ->get();

        $cursosConNotasFaltantes = [];

        foreach ($cursos as $curso) {
            $faltantes = $curso->calificaciones->where(function ($nota) use ($campoNota) {
                return is_null($nota->$campoNota) || $nota->$campoNota === '';
            });

            if ($faltantes->count() > 0) {
                $cursosConNotasFaltantes[] = $curso;
            }
        }

        if (count($cursosConNotasFaltantes) > 0) {
            $profesoresSinNotas[] = [
                'profesor' => $profesor,
                'cursos' => $cursosConNotasFaltantes
            ];
        }
    }

    $periodos = Periodo::orderBy('fecha_inicio', 'desc')->get();

    return view('admin.retirados', compact(
        'retiros',
        'profesoresSinNotas',
        'campoNota',
        'periodoId',
        'periodos'
    ));
}

}
