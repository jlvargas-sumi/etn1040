<?php

use App\Http\Controllers\Usuario\Docente\DocenteInscritoController;
use function Pest\Laravel\get;

test('Verificación de respuesta HTTP de la ruta docente/inscritos', function () {
    get(route('docente.inscritos', ['aperturaId' => 1]))->assertStatus(302);
});

test('Verificación de redirección al login para usuarios no autenticados', function () {
    get(route('docente.inscritos', ['aperturaId' => 1]))->assertRedirect(route('iniciar-sesion'));
});

test('Verificación de controlador en la ruta docente/inscritos', function () {
    $action = app('router')->getRoutes()->getByName('docente.inscritos')->getActionName();
    expect($action)->toBe(DocenteInscritoController::class.'@indice');
});

test('Verificación de middlewares en la ruta docente/inscritos', function () {
    $route = app('router')->getRoutes()->getByName('docente.inscritos');
    expect($route->getAction('middleware'))->toContain('auth', 'docente');
});

test('Verificación de parámetros en la ruta docente/inscritos', function () {
    $aperturaId = 123;
    $periodo = '2';
    $gestion = '2025';
    
    $route = route('docente.inscritos', [
        'aperturaId' => $aperturaId,
        'periodo' => $periodo,
        'gestion' => $gestion
    ]);
    
    expect($route)->toBeString()
        ->toContain((string)$aperturaId)
        ->toContain($periodo)
        ->toContain($gestion);
});