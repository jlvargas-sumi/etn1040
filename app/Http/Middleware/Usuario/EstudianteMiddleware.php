<?php

namespace App\Http\Middleware\Usuario;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EstudianteMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->guard()->check() && session('rolActivoUsuario')->rol_nombre == 'Estudiante')
        {
            return $next($request);
        }
        return back();
    }
}
