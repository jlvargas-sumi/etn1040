<?php

use App\Http\Controllers\Usuario\Administrador\Carrera\AdministradorMencionController;
use function Pest\Laravel\get;

test('Verificación de respuesta HTTP de la ruta administrador/menciones', function () {
    get(route('administrador.menciones'))->assertStatus(302);
});

test('Verificación de redirección al login para usuarios no autenticados', function () {
    get(route('administrador.menciones'))->assertRedirect(route('iniciar-sesion'));
});

test('Verificación de controlador en la ruta administrador/menciones', function () {
    $action = app('router')->getRoutes()->getByName('administrador.menciones')->getActionName();
    expect($action)->toBe(AdministradorMencionController::class.'@indice');
});

test('Verificación de middlewares en la ruta administrador/menciones', function () {
    $route = app('router')->getRoutes()->getByName('administrador.menciones');
    expect($route->getAction('middleware'))->toContain('auth', 'administrador');
});