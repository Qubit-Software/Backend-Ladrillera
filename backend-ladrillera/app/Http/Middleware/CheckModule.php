<?php

namespace App\Http\Middleware;

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
        if (!$request->user()->hasModule($module)) {
            abort(403, 'No tienes autorización para ingresar.');
        }
        return $next($request);
    }
}
