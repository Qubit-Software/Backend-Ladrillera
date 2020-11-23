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
    public function handle($request, Closure $next, ...$modules)
    {
        $authUser = Auth::user();
        $usuario = UsuarioModel::where('correo', $authUser->email)->first();
        $empleado = EmpleadoModel::where('id_usuario', $usuario->id)->first();
        if (is_null($empleado) || !$empleado->authorizeModules($modules)) {
            return response()->json([
                'msg' => 'No tienes autorización para ingresar al modulo ' . implode(',', $modules),
                'tus_modulos' => $empleado->modules()->get()
            ], 403);
        }
        return $next($request);
    }
}
