<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use Closure;

class CheckModule
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $module)
    {
        $authUser = Auth::user();
        $usuario = Usuario::where('email', $authUser->email)->fisrt();
        if (!$usuario->hasModule($module)) {
            abort(403, 'No tienes autorización para ingresar.');
        }
        return $next($request);
    }
}
