<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Alumnos\PerfilController;
use Illuminate\Support\Facades\Auth; 
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CursoController;

Route::get('/', function () {
    // Invitado ⇒ login
    if (! Auth::check()) {
        return redirect()->route('login');
    }

    // Usuario autenticado
    $user = Auth::user();

    if ($user->admin) {          // campo boolean admin
        return redirect('/admin');
    }

    if ($user->profesor) {       // campo boolean profesor
        return redirect('/profesor');
    }

    // Por descarte es “usuario” normal
    return redirect('/home');
});



Auth::routes();                        // genera /register, /login, etc.

Route::middleware('auth')->group(function () {

   
    Route::get('/home', [HomeController::class, 'index'])
          ->name('home')
          ->middleware('usuarioonly');

          // 👉 Ruta al perfil del alumno
    Route::get('/alumno/perfil', [PerfilController::class, 'show'])
          ->name('alumno.perfil')
          ->middleware('usuarioonly');


          
// ruta para admin
           Route::view('/admin', 'admin.admin')
          ->name('admin.dashboard')
          ->middleware('adminonly');

// ruta para crear usuarios admin
Route::get('/admin/usuarios/crear', [UserController::class, 'create'])->name('admin.usuarios.create')->middleware('adminonly');
    Route::post('/admin/usuarios', [UserController::class, 'store'])->name('admin.usuarios.store')
     ->middleware('adminonly');

// ruta para crear cursos y asignar horarios y profesores
Route::get('/admin/cursos/crear', [CursoController::class, 'create'])->name('admin.cursos.create'); // GET
Route::post('/admin/cursos', [CursoController::class, 'store'])->name('admin.cursos.store'); // POST
Route::get('/admin/cursos', [CursoController::class, 'index'])->name('admin.cursos.index');
Route::delete('/admin/cursos/{curso}', [CursoController::class, 'destroy'])->name('admin.cursos.destroy');
Route::get('/admin/carreras-por-nombre-facultad/{nombre}', function ($nombre) {
    $facultad = \App\Models\Facultad::where('nombre', $nombre)->first();

    if (!$facultad) return response()->json([]);
    
    $carreras = \App\Models\Carrera::where('facultad_id', $facultad->id)->get();

    return response()->json($carreras);
});






 // ruta para profesor

    Route::view('/profesor', 'profesor.profesor')
          ->name('profesor.dashboard')
          ->middleware('profesoronly');
});