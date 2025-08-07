<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CursoPeriodo;
use App\Models\Matricula;
use App\Models\Mensaje;
use Illuminate\Support\Facades\Auth;
use App\Models\Periodo;

class MensajeController extends Controller
{
 public function crear()
{
    $hoy = now();

    $periodoActual = Periodo::where('fecha_inicio', '<=', $hoy)
                             ->where('fecha_fin', '>=', $hoy)
                             ->first();

    if (!$periodoActual) {
        return back()->with('error', 'No hay un período activo actualmente.');
    }

    $cursos = CursoPeriodo::with('curso', 'periodo')
                ->where('periodo_id', $periodoActual->id)
                ->get();

    $alumnos = User::where('usuario', true)->get();

    // 🔽 IMPORTANTE: Asegúrate que aquí estés usando 'destinatario'
   $mensajes = Mensaje::with(['destinatario', 'cursoPeriodo.curso', 'cursoPeriodo.periodo'])
    ->where('remitente_id', Auth::id())
    ->where(function ($query) use ($periodoActual) {
        $query->whereHas('cursoPeriodo', function ($q) use ($periodoActual) {
            $q->where('periodo_id', $periodoActual->id);
        })
        ->orWhereNull('curso_periodo_id'); // Incluye mensajes individuales
    })
    ->latest()
    ->get()
    ->groupBy(function ($mensaje) {
        return $mensaje->curso_periodo_id ? 'curso' : 'individual';
    });

    return view('admin.mensaje', compact('cursos', 'alumnos', 'periodoActual', 'mensajes'));
}

  public function enviar(Request $request)
{
     $request->validate([
        'titulo' => 'required',
        'contenido' => 'required',
        'tipo_envio' => 'required|in:individual,curso,general',
        'tipo_mensaje' => 'required|in:importante,normal', // Nuevo campo
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        'alumno_id' => $request->tipo_envio === 'individual' ? 'required|exists:users,id' : 'nullable',
        'curso_periodo_id' => $request->tipo_envio === 'curso' ? 'required|exists:curso_periodo,id' : 'nullable',
    ]);


 // Prefijo según tipo de mensaje
    $prefijo = $request->tipo_mensaje === 'importante' ? 'Importante: ' : 'Normal: ';
    $tituloFinal = $prefijo . $request->titulo;

    if ($request->tipo_envio === 'individual') {
        // Enviar a un alumno específico
        Mensaje::create([
            'remitente_id' => Auth::id(),
            'destinatario_id' => $request->alumno_id,
            'titulo' => $tituloFinal,
            'contenido' => $request->contenido,
            'tipo_mensaje' => $request->tipo_mensaje,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ]);

   } elseif ($request->tipo_envio === 'curso') {
        // Enviar a todos los alumnos de un curso
        $matriculados = Matricula::where('curso_periodo_id', $request->curso_periodo_id)->pluck('user_id');
        foreach ($matriculados as $alumnoId) {
            Mensaje::create([
                'remitente_id' => Auth::id(),
                'destinatario_id' => $alumnoId,
                'curso_periodo_id' => $request->curso_periodo_id,
                'titulo' => $tituloFinal,
                'contenido' => $request->contenido,
                'tipo_mensaje' => $request->tipo_mensaje,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
            ]);
        }

    } elseif ($request->tipo_envio === 'general') {
        // Enviar a todos los alumnos del sistema
        $alumnos = User::where('usuario', true)->pluck('id');
        foreach ($alumnos as $alumnoId) {
            Mensaje::create([
                'remitente_id' => Auth::id(),
                'destinatario_id' => $alumnoId,
                'titulo' => $tituloFinal,
                'contenido' => $request->contenido,
                'tipo_mensaje' => $request->tipo_mensaje,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
            ]);
        }
    }

    return back()->with('success', 'Mensaje(s) enviado(s) correctamente.');
}
public function update(Request $request, $id)
{
    $request->validate([
        'titulo' => 'required',
        'contenido' => 'required',
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
    ]);

    $mensaje = Mensaje::findOrFail($id);

    if (!is_null($mensaje->curso_periodo_id)) {
        // Solo actualiza los mensajes que fueron creados al mismo tiempo (mismo envío)
        Mensaje::where('curso_periodo_id', $mensaje->curso_periodo_id)
            ->where('created_at', $mensaje->created_at)
            ->update([
                'titulo' => $request->titulo,
                'contenido' => $request->contenido,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
            ]);
    } else {
        // Mensaje individual
        $mensaje->update([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ]);
    }

    return redirect()->back()->with('success', 'Mensaje actualizado correctamente.');
}

}
