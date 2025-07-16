<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    //mostrar listrado de los usuarios creados


    public function create(Request $request)
{
    $filtro = $request->input('filtro');

    $query = User::query();

    if ($filtro === 'admin') {
        $query->where('admin', true);
    } elseif ($filtro === 'profesor') {
        $query->where('profesor', true);
    } elseif ($filtro === 'usuario') {
        $query->where('usuario', true);
    }

    $usuarios = $query->get();

    return view('admin.crearusers', compact('usuarios', 'filtro'));
}
    //forlmualrio de crear alumno-profesor-admin
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'apellido_p' => 'required|string|max:255',
            'apellido_m' => 'required|string|max:255',
            'dni' => 'required|string|max:20|unique:users,dni',
            'email' => 'nullable|email|unique:users,email',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->apellido_p = $request->apellido_p;
        $user->apellido_m = $request->apellido_m;
        $user->dni = $request->dni;
        $user->email = $request->email;
        $user->fecha_nacimiento = $request->fecha_nacimiento;
        $user->genero = $request->genero;
        $user->telefono = $request->telefono;

        // Asignar roles
        $user->admin = $request->has('admin');
        $user->profesor = $request->has('profesor');
        $user->usuario = $request->has('usuario');

        // Contraseña igual al DNI (encriptada)
        $user->password = Hash::make($request->dni);

        $user->save();

        return redirect()->back()->with('success', 'Usuario creado correctamente.');
    }
}
