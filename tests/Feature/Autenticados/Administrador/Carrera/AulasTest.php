<?php

use App\Http\Controllers\Usuario\Administrador\Carrera\AdministradorAulaController;
use function Pest\Laravel\get;

test('Verificación de respuesta HTTP de la ruta administrador/aulas', function () {
    get(route('administrador.aulas'))->assertStatus(302);
});

test('Verificación de redirección al login para usuarios no autenticados', function () {
    get(route('administrador.aulas'))->assertRedirect(route('iniciar-sesion'));
});

test('Verificación de controlador en la ruta administrador/aulas', function () {
    $action = app('router')->getRoutes()->getByName('administrador.aulas')->getActionName();
    expect($action)->toBe(AdministradorAulaController::class.'@indice');
});

test('Verificación de middlewares en la ruta administrador/aulas', function () {
    $route = app('router')->getRoutes()->getByName('administrador.aulas');
    expect($route->getAction('middleware'))->toContain('auth', 'administrador');
});