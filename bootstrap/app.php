<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

use App\Http\Middleware\Usuario\AdministradorMiddleware;
use App\Http\Middleware\Usuario\AdministrativoMiddleware;
use App\Http\Middleware\Usuario\AuxiliarMiddleware;
use App\Http\Middleware\Usuario\DocenteMiddleware;
use App\Http\Middleware\Usuario\EstudianteMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->alias([
            'administrador' => AdministradorMiddleware::class,
            'administrativo' => AdministrativoMiddleware::class,
            'auxiliar' => AuxiliarMiddleware::class,
            'docente' => DocenteMiddleware::class,
            'estudiante' => EstudianteMiddleware::class,
        ]);
        $middleware->redirectGuestsTo(fn (Request $request) => route('iniciar-sesion'));
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
