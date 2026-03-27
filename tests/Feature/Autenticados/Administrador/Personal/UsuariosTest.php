<?php

use App\Http\Controllers\Usuario\Administrador\Personal\AdministradorUsuarioController;
use App\Models\Usuario;
use App\Models\Persona;
use function Pest\Laravel\get;
use function Pest\Laravel\actingAs;

test('Verificación de respuesta HTTP de la ruta administrador/usuarios', function () {
    get(route('administrador.usuarios'))->assertStatus(302);
});

test('Verificación de redirección al login para usuarios no autenticados', function () {
    get(route('administrador.usuarios'))->assertRedirect(route('iniciar-sesion'));
});

test('Verificación de controlador en la ruta administrador/usuarios', function () {
    $action = app('router')->getRoutes()->getByName('administrador.usuarios')->getActionName();
    expect($action)->toBe(AdministradorUsuarioController::class.'@indice');
});

test('Verificación de middlewares en la ruta administrador/usuarios', function () {
    $route = app('router')->getRoutes()->getByName('administrador.usuarios');
    expect($route->getAction('middleware'))->toContain('auth', 'administrador');
});