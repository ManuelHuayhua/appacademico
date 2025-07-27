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
use App\Http\Controllers\Alumnos\ComprobanteController;
use App\Http\Controllers\Admin\PagosController;
use App\Http\Controllers\Admin\ClasesurlController;
use App\Http\Controllers\Admin\AdminNotasAsistenciasController;
use App\Http\Controllers\Admin\CursoSilaboController;
use App\Http\Controllers\Admin\PeriodoController;
use App\Http\Controllers\Admin\CalificadoProfesorController;
use App\Http\Controllers\Admin\Librearnotas;
use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\Admin\EstadisticasController;

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

 Route::get('/mis-calificaciones', [CalificacionalumnoController::class, 'index'])->name('alumno.calificaciones.index')->middleware('usuarioonly');

//comprobante de cursos

 Route::get('/alumno/comprobante', [ComprobanteController::class, 'index'])->name('alumno.comprobante')->middleware('usuarioonly');

 //silbus de cursos matriculados

   Route::get('/alumno/silabus', [App\Http\Controllers\Alumnos\SilaboController::class, 'index'])->name('alumno.silabus')->middleware('usuarioonly');

//calificaciones del profesor
Route::post('/alumno/calificar-profesor/{id}', [CalificacionalumnoController::class, 'guardarCalificacion'])->name('alumno.calificar-profesor')->middleware('usuarioonly');



// ruta para admin
          Route::get('/admin', [EstadisticasController::class, 'index'])
    ->name('admin.dashboard')
    ->middleware('adminonly');

// ruta para crear usuarios admin
Route::get('/admin/usuarios/crear', [UserController::class, 'create'])->name('admin.usuarios.create')->middleware('adminonly');
    Route::post('/admin/usuarios', [UserController::class, 'store'])->name('admin.usuarios.store')
     ->middleware('adminonly');

Route::get('/admin/usuarios/{id}', [UserController::class, 'show']);
Route::put('/admin/usuarios/{id}', [UserController::class, 'update']);
Route::put('/admin/usuarios/{id}/password', [UserController::class, 'updatePassword']);
Route::delete('/admin/usuarios/{id}', [UserController::class, 'destroy'])->name('admin.usuarios.destroy');



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
Route::put('/admin/mensajes/{mensaje}', [MensajeController::class, 'update'])
    ->name('admin.mensajes.update');

    
// Ver pagos
Route::get('/pagos', [PagosController::class, 'index'])->name('admin.pagos');
Route::post('/pagos', [PagosController::class, 'filtrarPagos'])->name('admin.pagos.post');
Route::post('/admin/registrar-pago', [PagosController::class, 'registrarPago'])->name('admin.registrarPago');
Route::post('/admin/actualizar-monto-curso', [PagosController::class, 'actualizarMontoCurso'])->name('admin.actualizarMontoCurso');

//ingresar URL
Route::get('/admin/clases-url', [ClasesurlController::class, 'index'])->name('admin.clasesurl.index');
Route::post('/admin/clases-url/update', [ClasesurlController::class, 'update'])->name('admin.clasesurl.update');

// ruta para ver notas y asistencias
Route::get('admin/notas-y-asistencias', [AdminNotasAsistenciasController::class, 'index'])
    ->name('admin.notas_y_asistencias');
Route::put('/admin/notas/{calificacion}', [AdminNotasAsistenciasController::class, 'actualizar'])->name('admin.notas.actualizar');
// ruta para exportar notas y asistencias a Excel
Route::get('/admin/notas-asistencias/export', [AdminNotasAsistenciasController::class, 'exportExcel'])
    ->name('admin.notas.exportar');


// ruta para ver silabus de cursos
Route::get('curso-silabo', [CursoSilaboController::class, 'index'])->name('curso_silabo.index');

Route::post('curso-silabo/{id}/update', [CursoSilaboController::class, 'update'])->name('curso_silabo.update');


// ruta para ver periodos

// Mostrar todos los periodos
Route::get('admin/periodos', [PeriodoController::class, 'index'])->name('admin.periodos.index');

// Guardar nuevo periodo (desde modal)
Route::post('admin/periodos', [PeriodoController::class, 'store'])->name('admin.periodos.store');

// Actualizar periodo (desde modal)
Route::put('admin/periodos/{id}', [PeriodoController::class, 'update'])->name('admin.periodos.update');

// Eliminar periodo
Route::delete('admin/periodos/{id}', [PeriodoController::class, 'destroy'])->name('admin.periodos.destroy');

// ruta para ver calificaciones de profesor
Route::get('/admin/calificado-profesor', [CalificadoProfesorController::class, 'index'])->name('admin.calificado_profesor.index');

//librear notas
Route::get('admin/librerarnotas', [Librearnotas::class, 'index'])->name('admin.librerarnotas.index');
Route::post('admin/librerarnotas/cambiar-permiso-curso', [Librearnotas::class, 'cambiarPermisoCurso'])->name('admin.librerarnotas.cambiarPermisoCurso');





 // ruta para profesor

    Route::middleware(['auth', 'profesoronly'])
    ->prefix('profesor')
    ->name('profesor.')
    ->group(function () {
        
        // Vista principal del profesor
        Route::get('/', [App\Http\Controllers\Profesor\ProfesorController::class, 'index'])->name('dashboard');

        // Ver cursos asignados
        Route::get('/cursos', [ProfesorCursoController::class, 'index'])->name('cursos');

        // Guardar asistencia
        Route::post('/asistencia/guardar', [ProfesorCursoController::class, 'guardarAsistencia'])->name('asistencia.guardar');
    });

    Route::get('/profesor/calificaciones', [App\Http\Controllers\Profesor\Calificacionesprofesor::class, 'index'])->name('profesor.calificaciones');
    Route::post('/profesor/calificaciones', [App\Http\Controllers\Profesor\Calificacionesprofesor::class, 'guardar'])->name('profesor.calificaciones.guardar');
    Route::get('/calendario', [App\Http\Controllers\Profesor\CalendarioController::class, 'index'])->name('calendario');
});




//ruta para el certificado 
Route::get('/ver-certificado', [CertificadoController::class, 'formulario'])->name('certificados.formulario');
Route::post('/ver-certificado', [CertificadoController::class, 'buscar'])->name('certificados.buscar');
Route::get('/certificados/{codigo}', [CertificadoController::class, 'mostrar'])->name('certificados.mostrar');