<?php

namespace App\Http\Controllers\Alumnos;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Matricula;
use Illuminate\Http\Request;

class SilaboController extends Controller
{
public function index()
{
    $alumnoId = Auth::id();

    $matriculas = Matricula::with('cursoPeriodo.curso')
        ->where('user_id', $alumnoId)
        ->get();

    // Agrupar por ID de curso único
    $cursosUnicos = $matriculas->map(function ($matricula) {
        return $matricula->cursoPeriodo->curso;
    })->unique('id'); // Aquí eliminamos duplicados por ID del curso

    return view('silabus', compact('cursosUnicos'));
}
}