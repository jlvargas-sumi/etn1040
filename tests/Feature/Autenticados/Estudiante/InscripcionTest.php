<?php

use App\Http\Controllers\Usuario\Estudiante\InscripcionController;
use function Pest\Laravel\get;

test('Verificación de respuesta HTTP de la ruta estudiante/inscripciones', function () {
    get(route('estudiante.inscripciones'))->assertStatus(302);
});

test('Verificación de redirección al login para usuarios no autenticados', function () {
    get(route('estudiante.inscripciones'))->assertRedirect(route('iniciar-sesion'));
});

test('Verificación de controlador en la ruta estudiante/inscripciones', function () {
    $action = app('router')->getRoutes()->getByName('estudiante.inscripciones')->getActionName();
    expect($action)->toBe(InscripcionController::class.'@indice');
});

test('Verificación de middlewares en la ruta estudiante/inscripciones', function () {
    $route = app('router')->getRoutes()->getByName('estudiante.inscripciones');
    expect($route->getAction('middleware'))->toContain('auth', 'estudiante');
});

test('Verificación de parámetros opcionales en la ruta estudiante/inscripciones', function () {
    $periodo = '2';
    $gestion = '2024';
    
    $route = route('estudiante.inscripciones', [$periodo, $gestion]);
    
    expect($route)->toBeString()
        ->toContain($periodo)
        ->toContain($gestion);
});