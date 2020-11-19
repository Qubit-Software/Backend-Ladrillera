<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use App\Models\UsuarioModel;
use App\Models\EmpleadoModel;
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
        $usuario = UsuarioModel::where('correo', $authUser->email)->first();
        $empleado = EmpleadoModel::where('id', $usuario->id_empleado)->first();
        // if (is_null($empleado) || !$empleado->authorizeModules([$module,])) {
        if (is_null($empleado) || !$empleado->hasModule($module)) {
            return response()->json(['msg' => 'No tienes autorización para ingresar al modulo ' . $module], 403);
        }
        return $next($request);
    }
}
