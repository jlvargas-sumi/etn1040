<?php

use App\Http\Controllers\Usuario\Auxiliar\AuxiliarPonderacionController;
use function Pest\Laravel\get;

test('Verificación de respuesta HTTP de la ruta auxiliar/ponderaciones', function () {
    get(route('auxiliar.ponderaciones', ['aperturaId' => 1]))->assertStatus(302);
});

test('Verificación de redirección al login para usuarios no autenticados', function () {
    get(route('auxiliar.ponderaciones', ['aperturaId' => 1]))->assertRedirect(route('iniciar-sesion'));
});

test('Verificación de controlador en la ruta auxiliar/ponderaciones', function () {
    $action = app('router')->getRoutes()->getByName('auxiliar.ponderaciones')->getActionName();
    expect($action)->toBe(AuxiliarPonderacionController::class.'@indice');
});

test('Verificación de middlewares en la ruta auxiliar/ponderaciones', function () {
    $route = app('router')->getRoutes()->getByName('auxiliar.ponderaciones');
    expect($route->getAction('middleware'))->toContain('auth', 'auxiliar');
});

test('Verificación de parámetros en la ruta auxiliar/ponderaciones', function () {
    $aperturaId = 123;
    $periodo = '2';
    $gestion = '2025';
    
    $route = route('auxiliar.ponderaciones', [
        'aperturaId' => $aperturaId,
        'periodo' => $periodo,
        'gestion' => $gestion
    ]);
    
    expect($route)->toBeString()
        ->toContain((string)$aperturaId)
        ->toContain($periodo)
        ->toContain($gestion);
});