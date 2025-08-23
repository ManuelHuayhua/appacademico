<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

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
        $tipo = $request->input('tipo_usuario');

$user->admin = $tipo === 'admin';
$user->profesor = $tipo === 'profesor';
$user->usuario = $tipo === 'usuario';

        // Contraseña igual al DNI (encriptada)
        $user->password = Hash::make($request->dni);

        $user->save();

        return redirect()->back()->with('success', 'Usuario creado correctamente.');
    }

    public function show($id)
{
    return User::findOrFail($id);
}

public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $tipo = $request->input('tipo_usuario');

$user->update([
    'name' => $request->name,
    'apellido_p' => $request->apellido_p,
    'apellido_m' => $request->apellido_m,
    'dni' => $request->dni,
    'email' => $request->email,
    'fecha_nacimiento' => $request->fecha_nacimiento,
    'genero' => $request->genero,
    'telefono' => $request->telefono,
    'admin' => $tipo === 'admin',
    'profesor' => $tipo === 'profesor',
    'usuario' => $tipo === 'usuario',
]);

    return redirect()->back()->with('success', 'Usuario actualizado.');
}

public function updatePassword(Request $request, $id)
{
    $request->validate(['password' => 'required|min:6']);
    $user = User::findOrFail($id);
    $user->password = Hash::make($request->password);
    $user->save();

    return redirect()->back()->with('success', 'Contraseña actualizada.');
}

public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->back()->with('success', 'Usuario eliminado.');
}


public function export()
{
    return Excel::download(new UsersExport, 'usuarios.xlsx');
}

}
