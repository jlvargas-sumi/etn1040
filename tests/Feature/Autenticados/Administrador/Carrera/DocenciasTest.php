<?php

use App\Http\Controllers\Usuario\Administrador\Inscripcion\AdministradorDocenciaController;
use function Pest\Laravel\get;

test('Verificación de respuesta HTTP de la ruta administrador/docencias', function () {
    get(route('administrador.docencias'))->assertStatus(302);
});

test('Verificación de redirección al login para usuarios no autenticados', function () {
    get(route('administrador.docencias'))->assertRedirect(route('iniciar-sesion'));
});

test('Verificación de controlador en la ruta administrador/docencias', function () {
    $action = app('router')->getRoutes()->getByName('administrador.docencias')->getActionName();
    expect($action)->toBe(AdministradorDocenciaController::class.'@indice');
});

test('Verificación de middlewares en la ruta administrador/docencias', function () {
    $route = app('router')->getRoutes()->getByName('administrador.docencias');
    expect($route->getAction('middleware'))->toContain('auth', 'administrador');
});

test('Verificación de parámetros opcionales en la ruta administrador/docencias', function () {
    $planEstudioId = 1;
    $mencionId = 2;
    $periodo = '2';
    $gestion = '2025';
    
    $route = route('administrador.docencias', [$planEstudioId, $mencionId, $periodo, $gestion]);
    
    expect($route)->toBeString()->toContain((string)$planEstudioId)
        ->toContain((string)$mencionId)
        ->toContain($periodo)
        ->toContain($gestion);
});