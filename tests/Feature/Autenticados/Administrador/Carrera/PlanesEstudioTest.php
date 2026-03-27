<?php

use App\Http\Controllers\Usuario\Administrador\Carrera\AdministradorPlanEstudioController;
use function Pest\Laravel\get;

test('Verificación de respuesta HTTP de la ruta administrador/planes-estudios', function () {
    get(route('administrador.planes-estudios'))->assertStatus(302);
});

test('Verificación de redirección al login para usuarios no autenticados', function () {
    get(route('administrador.planes-estudios'))->assertRedirect(route('iniciar-sesion'));
});

test('Verificación de controlador en la ruta administrador/planes-estudios', function () {
    $action = app('router')->getRoutes()->getByName('administrador.planes-estudios')->getActionName();
    expect($action)->toBe(AdministradorPlanEstudioController::class.'@indice');
});

test('Verificación de middlewares en la ruta administrador/planes-estudios', function () {
    $route = app('router')->getRoutes()->getByName('administrador.planes-estudios');
    expect($route->getAction('middleware'))->toContain('auth', 'administrador');
});