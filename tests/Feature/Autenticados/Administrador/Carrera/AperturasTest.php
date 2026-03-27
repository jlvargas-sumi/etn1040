<?php

use App\Http\Controllers\Usuario\Administrador\Inscripcion\AdministradorAperturaController;
use function Pest\Laravel\get;

test('Verificación de respuesta HTTP de la ruta administrador/aperturas', function () {
    get(route('administrador.aperturas'))->assertStatus(302);
});

test('Verificación de redirección al login para usuarios no autenticados', function () {
    get(route('administrador.aperturas'))->assertRedirect(route('iniciar-sesion'));
});

test('Verificación de controlador en la ruta administrador/aperturas', function () {
    $action = app('router')->getRoutes()->getByName('administrador.aperturas')->getActionName();
    expect($action)->toBe(AdministradorAperturaController::class.'@indice');
});

test('Verificación de middlewares en la ruta administrador/aperturas', function () {
    $route = app('router')->getRoutes()->getByName('administrador.aperturas');
    expect($route->getAction('middleware'))->toContain('auth', 'administrador');
});

test('Verificación de parámetros opcionales en la ruta administrador/aperturas', function () {
    $planEstudioId = 1;
    $mencionId = 2;
    $periodo = '2';
    $gestion = '2025';
    
    $route = route('administrador.aperturas', [$planEstudioId, $mencionId, $periodo, $gestion]);
    
    expect($route)->toBeString()->toContain((string)$planEstudioId)
        ->toContain((string)$mencionId)
        ->toContain($periodo)
        ->toContain($gestion);
});