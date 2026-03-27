<?php

use App\Http\Controllers\Usuario\Auxiliar\AuxiliarAuxiliaturaController;
use function Pest\Laravel\get;

test('Verificación de respuesta HTTP de la ruta auxiliar/auxiliaturas', function () {
    get(route('auxiliar.auxiliaturas'))->assertStatus(302);
});

test('Verificación de redirección al login para usuarios no autenticados', function () {
    get(route('auxiliar.auxiliaturas'))->assertRedirect(route('iniciar-sesion'));
});

test('Verificación de controlador en la ruta auxiliar/auxiliaturas', function () {
    $action = app('router')->getRoutes()->getByName('auxiliar.auxiliaturas')->getActionName();
    expect($action)->toBe(AuxiliarAuxiliaturaController::class.'@indice');
});

test('Verificación de middlewares en la ruta auxiliar/auxiliaturas', function () {
    $route = app('router')->getRoutes()->getByName('auxiliar.auxiliaturas');
    expect($route->getAction('middleware'))->toContain('auth', 'auxiliar');
});

test('Verificación de parámetros opcionales en la ruta auxiliar/auxiliaturas', function () {
    $periodo = '2';
    $gestion = '2025';
    
    $route = route('auxiliar.auxiliaturas', [$periodo, $gestion]);
    
    expect($route)->toBeString()
        ->toContain($periodo)
        ->toContain($gestion);
});