<?php

use App\Http\Controllers\Usuario\Administrador\Inscripcion\AdministradorAuxiliaturaController;
use function Pest\Laravel\get;

test('Verificación de respuesta HTTP de la ruta administrador/auxiliaturas', function () {
    get(route('administrador.auxiliaturas'))->assertStatus(302);
});

test('Verificación de redirección al login para usuarios no autenticados', function () {
    get(route('administrador.auxiliaturas'))->assertRedirect(route('iniciar-sesion'));
});

test('Verificación de controlador en la ruta administrador/auxiliaturas', function () {
    $action = app('router')->getRoutes()->getByName('administrador.auxiliaturas')->getActionName();
    expect($action)->toBe(AdministradorAuxiliaturaController::class.'@indice');
});

test('Verificación de middlewares en la ruta administrador/auxiliaturas', function () {
    $route = app('router')->getRoutes()->getByName('administrador.auxiliaturas');
    expect($route->getAction('middleware'))->toContain('auth', 'administrador');
});

test('Verificación de parámetros opcionales en la ruta administrador/auxiliaturas', function () {
    $planEstudioId = 1;
    $mencionId = 2;
    $periodo = '2';
    $gestion = '2025';
    
    $route = route('administrador.auxiliaturas', [$planEstudioId, $mencionId, $periodo, $gestion]);
    
    expect($route)->toBeString()->toContain((string)$planEstudioId)
        ->toContain((string)$mencionId)
        ->toContain($periodo)
        ->toContain($gestion);
});