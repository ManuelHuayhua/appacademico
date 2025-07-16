<?php

namespace App\Http\Controllers\Alumnos;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PerfilController extends Controller
{
     public function show()
    {
        // Obtiene al usuario autenticado
        $user = Auth::user();

        // Verifica que sea estudiante (usuario = true / 1)
        if ($user && $user->usuario) {
        return view('perfil', compact('user'));

        }

        abort(403, 'Acceso no autorizado.');
    }


public function update(Request $request)
{
    $request->validate([
        'telefono' => 'required|string|max:20',
        'email' => 'required|email|max:255',
    ]);

    $user = Auth::user();

    // Solo se actualizan estos campos
    $user->telefono = $request->telefono;
    $user->email = $request->email;

    $user->save();

    return redirect()->back()->with('success', 'Datos de contacto actualizados correctamente.');
}
}
