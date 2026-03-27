<?php

use App\Http\Controllers\ComunicadoController;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

test('Verificación de respuesta HTTP de la ruta de comunicados sin parámetros', function () {
    get(route('comunicados'))->assertStatus(200);
});

test('Verificación de respuesta HTTP de la ruta de comunicados con página', function () {
    get(route('comunicados', ['pagina' => 1]))->assertStatus(200);
});

test('Verificación de respuesta HTTP de la ruta de comunicados con parámetros de selección', function () {
    get(route('comunicados', ['pagina' => 1, 'seleccionar_parametro' => 'categoria', 'valor_parametro' => 'test']))->assertStatus(200);
});

test('Verificación de contenido específico en la página de comunicados', function () {
    get(route('comunicados'))->assertSee('Comunicados');
});

test('Verificación de controlador en la ruta de comunicados', function () {
    $action = app('router')->getRoutes()->getByName('comunicados')->getActionName();
    expect($action)->toBe(ComunicadoController::class.'@indice');
});

test('Verificación de respuesta HTTP de la ruta de búsqueda de comunicados', function () {
    post(route('comunicados.buscar'), [
        'seleccionar_parametro' => 'categoria',
        'valor_parametro' => 'test'
    ])->assertStatus(200);
});

test('Verificación de controlador en la ruta de búsqueda de comunicados', function () {
    $action = app('router')->getRoutes()->getByName('comunicados.buscar')->getActionName();
    expect($action)->toBe(ComunicadoController::class.'@buscar');
});