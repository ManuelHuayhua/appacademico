<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Alumnos\PerfilController;
use Illuminate\Support\Facades\Auth;  

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

  
    Route::view('/admin', 'admin.admin')
          ->name('admin.dashboard')
          ->middleware('adminonly');

   
    Route::view('/profesor', 'profesor.profesor')
          ->name('profesor.dashboard')
          ->middleware('profesoronly');
});