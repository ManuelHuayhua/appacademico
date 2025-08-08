<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request; 
use App\Models\LoginLog;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

      public function username()
    {
        return 'dni';
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
  

     /**
     * Sobrecarga de credentials(): inyecta el rol que el usuario marcó.
     *
     * Auth::attempt() validará:
     *   - dni
     *   - password
     *   - y que la columna (admin|usuario|profesor) sea true (1)
     */
    protected function credentials(Request $request): array
    {
        $roleColumn = $request->input('role');      // admin | usuario | profesor

        return [
            'dni'      => $request->input('dni'),
            'password' => $request->input('password'),
            $roleColumn => true,                    // exige rol = 1
        ];
    }

    /* ---------- Redirige según el rol real ---------- */
   protected function authenticated(Request $request, $user)
{
    // Guardar log de login para todos o solo admin (ejemplo admin)
    if ($user->admin) {
        LoginLog::create([
            'user_id' => $user->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'logged_in_at' => now(),
        ]);
    }

    // Redirigir según rol
    if ($user->admin) {
        return redirect('/admin');
    }

    if ($user->profesor) {
        return redirect('/profesor');
    }

    return redirect('/home');
}

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
