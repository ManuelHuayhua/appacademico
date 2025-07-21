<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Alumnos\PerfilController;
use Illuminate\Support\Facades\Auth; 
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CursoController;
use App\Http\Controllers\Alumnos\CursosController;
use App\Http\Controllers\Admin\MatriculaController;
use App\Http\Controllers\Profesor\CursoController as ProfesorCursoController;
use App\Http\Controllers\Alumnos\CalificacionalumnoController;
use App\Http\Controllers\Admin\CalificacionesController;
use App\Http\Controllers\Admin\MensajeController;

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

//editar perfil
    Route::put('/perfil/actualizar', [PerfilController::class, 'update'])->name('perfil.update');


//ruta vista  cursos_alumno
Route::get('/alumno/cursos', [CursosController::class, 'index'])
    ->name('alumno.cursos')
    ->middleware('usuarioonly');
//ruta vista  horarios_alumno

Route::get('/alumno/calendario', [CursosController::class, 'horario'])
    ->name('alumno.calendario')
    ->middleware('usuarioonly');

//calificaciones

 Route::get('/mis-calificaciones', [CalificacionalumnoController::class, 'index'])->name('alumno.calificaciones.index');








// ruta para admin
           Route::view('/admin', 'admin.admin')
          ->name('admin.dashboard')
          ->middleware('adminonly');

// ruta para crear usuarios admin
Route::get('/admin/usuarios/crear', [UserController::class, 'create'])->name('admin.usuarios.create')->middleware('adminonly');
    Route::post('/admin/usuarios', [UserController::class, 'store'])->name('admin.usuarios.store')
     ->middleware('adminonly');

// ruta para crear cursos y asignar horarios y profesores // condicional de periodo que sea del año actual

Route::get('/admin/cursos/crear', [CursoController::class, 'create'])->name('admin.cursos.create'); // GET
Route::post('/admin/cursos', [CursoController::class, 'store'])->name('admin.cursos.store'); // POST
Route::get('/admin/cursos', function () {
    return redirect()->route('admin.cursos.create');
});
Route::delete('/admin/cursos/{curso}', [CursoController::class, 'destroy'])->name('admin.cursos.destroy');
Route::get('/admin/carreras-por-nombre-facultad/{nombre}', function ($nombre) {
    $facultad = \App\Models\Facultad::where('nombre', $nombre)->first();

    if (!$facultad) return response()->json([]);
    
    $carreras = \App\Models\Carrera::where('facultad_id', $facultad->id)->get();

    return response()->json($carreras);
    
});
Route::get('/admin/cursos-por-nombre-carrera/{nombre}', function ($nombre) {
    $carrera = \App\Models\Carrera::where('nombre', $nombre)->first();

    if (!$carrera) return response()->json([]);

    $cursos = \App\Models\Curso::where('carrera_id', $carrera->id)->get();

    return response()->json($cursos);
});



//matricula
Route::get('/admin/matricula', [MatriculaController::class, 'create'])
    ->name('admin.matricula.create')
    ->middleware('adminonly');

Route::post('/admin/matricula', [MatriculaController::class, 'store'])
    ->name('admin.matricula.store')
    ->middleware('adminonly');


//eliminar matricula
Route::delete('/admin/matricula/{id}', [MatriculaController::class, 'destroy'])
    ->name('admin.matricula.destroy')
    ->middleware('adminonly');

//calificaciones:
Route::get('/admin/calificaciones', [CalificacionesController::class, 'index'])->name('admin.calificaciones.index') ->middleware('adminonly');


//enviar mensaje
Route::get('/admin/mensajes/crear', [MensajeController::class, 'crear'])->name('admin.mensajes.crear');
Route::post('/admin/mensajes/enviar', [MensajeController::class, 'enviar'])->name('admin.mensajes.enviar');




 // ruta para profesor

    Route::middleware(['auth', 'profesoronly'])
    ->prefix('profesor')
    ->name('profesor.')
    ->group(function () {
        
        // Vista principal del profesor
        Route::view('/', 'profesor.profesor')->name('dashboard');

        // Ver cursos asignados
        Route::get('/cursos', [ProfesorCursoController::class, 'index'])->name('cursos');

        // Guardar asistencia
        Route::post('/asistencia/guardar', [ProfesorCursoController::class, 'guardarAsistencia'])->name('asistencia.guardar');
    });

    Route::get('/profesor/calificaciones', [App\Http\Controllers\Profesor\Calificacionesprofesor::class, 'index'])->name('profesor.calificaciones');
    Route::post('/profesor/calificaciones', [App\Http\Controllers\Profesor\Calificacionesprofesor::class, 'guardar'])->name('profesor.calificaciones.guardar');
    Route::get('/calendario', [App\Http\Controllers\Profesor\CalendarioController::class, 'index'])->name('calendario');
});

