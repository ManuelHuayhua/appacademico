<?php

namespace App\Http\Controllers\Alumnos;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
class CursosController extends Controller
{

    //vista cursos del alumno
    public function index()
    {
        $user = Auth::user(); // alumno autenticado

        $cursos = DB::table('matriculas')
            ->join('curso_periodo', 'matriculas.curso_periodo_id', '=', 'curso_periodo.id')
            ->join('cursos', 'curso_periodo.curso_id', '=', 'cursos.id')
            ->join('periodos', 'curso_periodo.periodo_id', '=', 'periodos.id')
            ->where('matriculas.user_id', $user->id)
            ->select(
                'cursos.nombre as curso',
                'cursos.descripcion',
                'periodos.nombre as periodo',
                'curso_periodo.seccion',
                'matriculas.fecha_matricula',
                'matriculas.estado'
            )
            ->orderBy('periodos.fecha_inicio', 'desc')
            ->get();

        return view('cursos_alumno', compact('cursos'));
    }

public function horario()
{
    $userId = auth()->id();

    $horarios = DB::table('matriculas')
        ->join('curso_periodo', 'matriculas.curso_periodo_id', '=', 'curso_periodo.id')
        ->join('cursos', 'curso_periodo.curso_id', '=', 'cursos.id')
        ->join('periodos', 'curso_periodo.periodo_id', '=', 'periodos.id')
        ->join('horarios', 'curso_periodo.id', '=', 'horarios.curso_periodo_id')
        ->join('users as profesores', 'horarios.profesor_id', '=', 'profesores.id')
        ->where('matriculas.user_id', $userId)
        ->select(
            'cursos.nombre as curso',
            'horarios.dia_semana',
            'horarios.hora_inicio',
            'horarios.hora_fin',
            'profesores.name as profesor',
            'periodos.nombre as periodo',
            'curso_periodo.fecha_inicio_clases',
'curso_periodo.fecha_fin_clases'
        )
        ->get();

    $clasesConFechas = [];

    foreach ($horarios as $clase) {
        $inicio = \Carbon\Carbon::parse($clase->fecha_inicio_clases);
$fin = \Carbon\Carbon::parse($clase->fecha_fin_clases);

        while ($inicio->lte($fin)) {
            if ($inicio->dayOfWeekIso == $clase->dia_semana) {
                $clasesConFechas[] = [
                    'title' => $clase->curso . " ({$clase->hora_inicio} - {$clase->hora_fin})",
                    'start' => $inicio->toDateString() . "T" . $clase->hora_inicio,
                    'end'   => $inicio->toDateString() . "T" . $clase->hora_fin,
                    'extendedProps' => [
                        'profesor' => $clase->profesor,
                        'periodo'  => $clase->periodo,
                    ]
                ];
            }
            $inicio->addDay();
        }
    }

    return view('cursos_horario', [
        'eventosJson' => json_encode($clasesConFechas)
    ]);
}
}