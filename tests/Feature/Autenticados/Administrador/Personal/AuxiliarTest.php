<?php

use App\Http\Controllers\Usuario\Administrador\Personal\AdministradorAuxiliarController;
use App\Models\Usuario;
use App\Models\Persona;
use function Pest\Laravel\get;
use function Pest\Laravel\actingAs;

test('Verificación de respuesta HTTP de la ruta administrador/auxiliares', function () {
    get(route('administrador.auxiliares'))->assertStatus(302);
});

test('Verificación de redirección al login para usuarios no autenticados', function () {
    get(route('administrador.auxiliares'))->assertRedirect(route('iniciar-sesion'));
});

test('Verificación de controlador en la ruta administrador/auxiliares', function () {
    $action = app('router')->getRoutes()->getByName('administrador.auxiliares')->getActionName();
    expect($action)->toBe(AdministradorAuxiliarController::class.'@indice');
});

test('Verificación de middlewares en la ruta administrador/auxiliares', function () {
    $route = app('router')->getRoutes()->getByName('administrador.auxiliares');
    expect($route->getAction('middleware'))->toContain('auth', 'administrador');
});