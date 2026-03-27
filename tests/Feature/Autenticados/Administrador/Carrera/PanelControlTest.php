<?php

use App\Http\Controllers\Usuario\Administrador\AdministradorPanelControlController;
use function Pest\Laravel\get;

test('Verificación de respuesta HTTP de la ruta administrador/panel-control', function () {
    get(route('administrador.panel-control'))->assertStatus(302);
});

test('Verificación de redirección al login para usuarios no autenticados', function () {
    get(route('administrador.panel-control'))->assertRedirect(route('iniciar-sesion'));
});

test('Verificación de controlador en la ruta administrador/panel-control', function () {
    $action = app('router')->getRoutes()->getByName('administrador.panel-control')->getActionName();
    expect($action)->toBe(AdministradorPanelControlController::class.'@indice');
});

test('Verificación de middlewares en la ruta administrador/panel-control', function () {
    $route = app('router')->getRoutes()->getByName('administrador.panel-control');
    expect($route->getAction('middleware'))->toContain('auth', 'administrador');
});