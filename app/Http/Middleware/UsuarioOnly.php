<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UsuarioOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $u = Auth::user();

        // ✅ pasa sólo si la columna 'usuario' está en 1
        //    y NO es ni admin ni profesor
        if ($u && $u->usuario && !$u->admin && !$u->profesor) {
            return $next($request);
        }

        // ❌ cualquier otro rol queda fuera
        return redirect('/')->with('error', 'Acceso denegado');
    }
}
