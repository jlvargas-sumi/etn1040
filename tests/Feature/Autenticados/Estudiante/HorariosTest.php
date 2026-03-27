<?php

use App\Http\Controllers\Usuario\Estudiante\HorarioController;
use function Pest\Laravel\get;

test('Verificación de respuesta HTTP de la ruta estudiante/horarios', function () {
    get(route('estudiante.horarios'))->assertStatus(302);
});

test('Verificación de redirección al login para usuarios no autenticados', function () {
    get(route('estudiante.horarios'))->assertRedirect(route('iniciar-sesion'));
});

test('Verificación de controlador en la ruta estudiante/horarios', function () {
    $action = app('router')->getRoutes()->getByName('estudiante.horarios')->getActionName();
    expect($action)->toBe(HorarioController::class.'@indice');
});

test('Verificación de middlewares en la ruta estudiante/horarios', function () {
    $route = app('router')->getRoutes()->getByName('estudiante.horarios');
    expect($route->getAction('middleware'))->toContain('auth', 'estudiante');
});

test('Verificación de parámetros opcionales en la ruta estudiante/horarios', function () {
    $periodo = '2';
    $gestion = '2025';
    
    $route = route('estudiante.horarios', [$periodo, $gestion]);
    
    expect($route)->toBeString()
        ->toContain($periodo)
        ->toContain($gestion);
});