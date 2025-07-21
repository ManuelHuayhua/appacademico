<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CursoPeriodo;
use App\Models\Matricula;
use App\Models\Mensaje;
use Illuminate\Support\Facades\Auth;

class MensajeController extends Controller
{
    public function crear()
{
    $cursos = CursoPeriodo::with('curso')->get();
    $alumnos = User::where('usuario', true)->get();

    return view('admin.mensaje', compact('cursos', 'alumnos'));
}

  public function enviar(Request $request)
{
    $request->validate([
        'titulo' => 'required',
        'contenido' => 'required',
        'tipo_envio' => 'required|in:individual,curso',
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        'alumno_id' => $request->tipo_envio === 'individual' ? 'required|exists:users,id' : 'nullable',
        'curso_periodo_id' => $request->tipo_envio === 'curso' ? 'required|exists:curso_periodo,id' : 'nullable',


    ]);

    if ($request->tipo_envio === 'individual') {
        Mensaje::create([
            'remitente_id' => Auth::id(),
            'destinatario_id' => $request->alumno_id,
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ]);
    } else {
        $matriculados = Matricula::where('curso_periodo_id', $request->curso_periodo_id)->pluck('user_id');
        foreach ($matriculados as $alumnoId) {
            Mensaje::create([
                'remitente_id' => Auth::id(),
                'destinatario_id' => $alumnoId,
                'curso_periodo_id' => $request->curso_periodo_id,
                'titulo' => $request->titulo,
                'contenido' => $request->contenido,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
            ]);
        }
    }

    return back()->with('success', 'Mensaje(s) enviado(s) correctamente.');
}
}
