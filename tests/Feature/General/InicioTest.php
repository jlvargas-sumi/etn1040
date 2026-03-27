<?php

use App\Http\Controllers\InicioController;
use function Pest\Laravel\get;

test('Verificación de respuesta HTTP de la ruta de inicio', function () {
    get(route('inicio'))->assertStatus(200);
});

test('Verificación de contenido específico en la página de inicio', function () {
    get(route('inicio'))->assertSee('Bienvenido');
});

test('Verificación de controlador en la ruta de inicio', function () {
    $action = app('router')->getRoutes()->getByName('inicio')->getActionName();
    expect($action)->toBe(InicioController::class.'@indice');
});
