<?php

use App\Http\Controllers\Usuario\Administrador\Personal\AdministradorEstudianteController;
use App\Models\Usuario;
use App\Models\Persona;
use function Pest\Laravel\get;
use function Pest\Laravel\actingAs;

test('Verificación de respuesta HTTP de la ruta administrador/estudiantes', function () {
    get(route('administrador.estudiantes'))->assertStatus(302);
});

test('Verificación de redirección al login para usuarios no autenticados', function () {
    get(route('administrador.estudiantes'))->assertRedirect(route('iniciar-sesion'));
});

test('Verificación de controlador en la ruta administrador/estudiantes', function () {
    $action = app('router')->getRoutes()->getByName('administrador.estudiantes')->getActionName();
    expect($action)->toBe(AdministradorEstudianteController::class.'@indice');
});

test('Verificación de middlewares en la ruta administrador/estudiantes', function () {
    $route = app('router')->getRoutes()->getByName('administrador.estudiantes');
    expect($route->getAction('middleware'))->toContain('auth', 'administrador');
});