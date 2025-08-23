<?php

namespace App\Http\Controllers\Profesor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PerfilProfesor extends Controller
{
    public function index()
    {
        // Usuario autenticado (profesor)
        $profesor = Auth::user();

        return view('profesor.perfil_profesor', compact('profesor'));
    }

    public function update(Request $request)
    {
        $profesor = Auth::user();

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $profesor->id,
            'telefono' => 'nullable|string|max:20',
        ]);

        $profesor->email = $request->email;
        $profesor->telefono = $request->telefono;
        $profesor->save();

        return redirect()->back()->with('success', 'Perfil actualizado correctamente');
    }
}
