<?php

use App\Http\Controllers\Usuario\Administrador\Personal\AdministradorDocenteController;
use App\Models\Usuario;
use App\Models\Persona;
use function Pest\Laravel\get;
use function Pest\Laravel\actingAs;

test('Verificación de respuesta HTTP de la ruta administrador/docentes', function () {
    get(route('administrador.docentes'))->assertStatus(302);
});

test('Verificación de redirección al login para usuarios no autenticados', function () {
    get(route('administrador.docentes'))->assertRedirect(route('iniciar-sesion'));
});

test('Verificación de controlador en la ruta administrador/docentes', function () {
    $action = app('router')->getRoutes()->getByName('administrador.docentes')->getActionName();
    expect($action)->toBe(AdministradorDocenteController::class.'@indice');
});

test('Verificación de middlewares en la ruta administrador/docentes', function () {
    $route = app('router')->getRoutes()->getByName('administrador.docentes');
    expect($route->getAction('middleware'))->toContain('auth', 'administrador');
});