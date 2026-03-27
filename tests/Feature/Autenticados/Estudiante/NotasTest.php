<?php

use App\Http\Controllers\Usuario\Estudiante\NotaController;
use function Pest\Laravel\get;

test('Verificación de respuesta HTTP de la ruta estudiante/notas', function () {
    get(route('estudiante.notas'))->assertStatus(302);
});

test('Verificación de redirección al login para usuarios no autenticados', function () {
    get(route('estudiante.notas'))->assertRedirect(route('iniciar-sesion'));
});

test('Verificación de controlador en la ruta estudiante/notas', function () {
    $action = app('router')->getRoutes()->getByName('estudiante.notas')->getActionName();
    expect($action)->toBe(NotaController::class.'@indice');
});

test('Verificación de middlewares en la ruta estudiante/notas', function () {
    $route = app('router')->getRoutes()->getByName('estudiante.notas');
    expect($route->getAction('middleware'))->toContain('auth', 'estudiante');
});

test('Verificación de parámetros opcionales en la ruta estudiante/notas', function () {
    $periodo = '2';
    $gestion = '2025';
    
    $route = route('estudiante.notas', [$periodo, $gestion]);
    
    expect($route)->toBeString()
        ->toContain($periodo)
        ->toContain($gestion);
});