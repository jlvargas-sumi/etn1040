<?php

use App\Http\Controllers\Usuario\Administrador\Personal\AdministradorAdministrativoController;
use App\Models\Usuario;
use App\Models\Persona;
use function Pest\Laravel\get;
use function Pest\Laravel\actingAs;

test('Verificación de respuesta HTTP de la ruta administrador/administrativos', function () {
    get(route('administrador.administrativos'))->assertStatus(302);
});

test('Verificación de redirección al login para usuarios no autenticados', function () {
    get(route('administrador.administrativos'))->assertRedirect(route('iniciar-sesion'));
});

test('Verificación de controlador en la ruta administrador/administrativos', function () {
    $action = app('router')->getRoutes()->getByName('administrador.administrativos')->getActionName();
    expect($action)->toBe(AdministradorAdministrativoController::class.'@indice');
});

test('Verificación de middlewares en la ruta administrador/administrativos', function () {
    $route = app('router')->getRoutes()->getByName('administrador.administrativos');
    expect($route->getAction('middleware'))->toContain('auth', 'administrador');
});