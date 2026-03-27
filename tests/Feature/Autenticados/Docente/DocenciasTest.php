<?php

use App\Http\Controllers\Usuario\Docente\DocenteDocenciaController;
use function Pest\Laravel\get;

test('Verificación de respuesta HTTP de la ruta docente/docencias', function () {
    get(route('docente.docencias'))->assertStatus(302);
});

test('Verificación de redirección al login para usuarios no autenticados', function () {
    get(route('docente.docencias'))->assertRedirect(route('iniciar-sesion'));
});

test('Verificación de controlador en la ruta docente/docencias', function () {
    $action = app('router')->getRoutes()->getByName('docente.docencias')->getActionName();
    expect($action)->toBe(DocenteDocenciaController::class.'@indice');
});

test('Verificación de middlewares en la ruta docente/docencias', function () {
    $route = app('router')->getRoutes()->getByName('docente.docencias');
    expect($route->getAction('middleware'))->toContain('auth', 'docente');
});

test('Verificación de parámetros opcionales en la ruta docente/docencias', function () {
    $periodo = '2';
    $gestion = '2025';
    
    $route = route('docente.docencias', [$periodo, $gestion]);
    
    expect($route)->toBeString()
        ->toContain($periodo)
        ->toContain($gestion);
});