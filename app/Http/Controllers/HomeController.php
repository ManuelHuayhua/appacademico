<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matricula;
use App\Models\Mensaje;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
public function index()
{
    $user = Auth::user();
    $hoy = Carbon::now()->toDateString();

    // Buscar mensajes activos dirigidos al usuario logueado
    $mensajes = Mensaje::where('destinatario_id', $user->id)
        ->whereDate('fecha_inicio', '<=', $hoy)
        ->whereDate('fecha_fin', '>=', $hoy)
        ->get();

    return view('home', compact('mensajes'));
}
}
