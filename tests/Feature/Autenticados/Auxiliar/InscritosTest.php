<?php

use App\Http\Controllers\Usuario\Auxiliar\AuxiliarInscritoController;
use function Pest\Laravel\get;

test('Verificación de respuesta HTTP de la ruta auxiliar/inscritos', function () {
    get(route('auxiliar.inscritos', ['aperturaId' => 1]))->assertStatus(302);
});

test('Verificación de redirección al login para usuarios no autenticados', function () {
    get(route('auxiliar.inscritos', ['aperturaId' => 1]))->assertRedirect(route('iniciar-sesion'));
});

test('Verificación de controlador en la ruta auxiliar/inscritos', function () {
    $action = app('router')->getRoutes()->getByName('auxiliar.inscritos')->getActionName();
    expect($action)->toBe(AuxiliarInscritoController::class.'@indice');
});

test('Verificación de middlewares en la ruta auxiliar/inscritos', function () {
    $route = app('router')->getRoutes()->getByName('auxiliar.inscritos');
    expect($route->getAction('middleware'))->toContain('auth', 'auxiliar');
});

test('Verificación de parámetros en la ruta auxiliar/inscritos', function () {
    $aperturaId = 123;
    $periodo = '2';
    $gestion = '2025';
    
    $route = route('auxiliar.inscritos', [
        'aperturaId' => $aperturaId,
        'periodo' => $periodo,
        'gestion' => $gestion
    ]);
    
    expect($route)->toBeString()
        ->toContain((string)$aperturaId)
        ->toContain($periodo)
        ->toContain($gestion);
});