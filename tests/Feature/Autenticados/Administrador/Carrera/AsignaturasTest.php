<?php

use App\Http\Controllers\Usuario\Administrador\Carrera\AdministradorAsignaturaController;
use function Pest\Laravel\get;

test('Verificación de respuesta HTTP de la ruta administrador/asignaturas', function () {
    get(route('administrador.asignaturas'))->assertStatus(302);
});

test('Verificación de redirección al login para usuarios no autenticados', function () {
    get(route('administrador.asignaturas'))->assertRedirect(route('iniciar-sesion'));
});

test('Verificación de controlador en la ruta administrador/asignaturas', function () {
    $action = app('router')->getRoutes()->getByName('administrador.asignaturas')->getActionName();
    expect($action)->toBe(AdministradorAsignaturaController::class.'@indice');
});

test('Verificación de respuesta HTTP de la ruta administrador/asignaturas/buscar', function () {
    get(route('administrador.asignaturas.buscar'))->assertStatus(302);
});

test('Verificación de redirección al login para usuarios no autenticados en buscar', function () {
    get(route('administrador.asignaturas.buscar'))->assertRedirect(route('iniciar-sesion'));
});

test('Verificación de controlador en la ruta administrador/asignaturas/buscar', function () {
    $action = app('router')->getRoutes()->getByName('administrador.asignaturas.buscar')->getActionName();
    expect($action)->toBe(AdministradorAsignaturaController::class.'@buscar');
});

test('Verificación de middlewares en la ruta administrador/asignaturas', function () {
    $route = app('router')->getRoutes()->getByName('administrador.asignaturas');
    expect($route->getAction('middleware'))->toContain('auth', 'administrador');
});

test('Verificación de middlewares en la ruta administrador/asignaturas/buscar', function () {
    $route = app('router')->getRoutes()->getByName('administrador.asignaturas.buscar');
    expect($route->getAction('middleware'))->toContain('auth', 'administrador');
});