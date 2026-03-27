<?php

use App\Http\Controllers\Usuario\Docente\DocenteNotaController;
use function Pest\Laravel\get;

test('Verificación de respuesta HTTP de la ruta docente/notas', function () {
    get(route('docente.notas', ['aperturaId' => 1]))->assertStatus(302);
});

test('Verificación de redirección al login para usuarios no autenticados', function () {
    get(route('docente.notas', ['aperturaId' => 1]))->assertRedirect(route('iniciar-sesion'));
});

test('Verificación de controlador en la ruta docente/notas', function () {
    $action = app('router')->getRoutes()->getByName('docente.notas')->getActionName();
    expect($action)->toBe(DocenteNotaController::class.'@indice');
});

test('Verificación de middlewares en la ruta docente/notas', function () {
    $route = app('router')->getRoutes()->getByName('docente.notas');
    expect($route->getAction('middleware'))->toContain('auth', 'docente');
});

test('Verificación de parámetros en la ruta docente/notas', function () {
    $aperturaId = 123;
    $periodo = '2';
    $gestion = '2025';
    
    $route = route('docente.notas', [
        'aperturaId' => $aperturaId,
        'periodo' => $periodo,
        'gestion' => $gestion
    ]);
    
    expect($route)->toBeString()
        ->toContain((string)$aperturaId)
        ->toContain($periodo)
        ->toContain($gestion);
});