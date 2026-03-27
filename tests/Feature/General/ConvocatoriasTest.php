<?php

use App\Http\Controllers\ConvocatoriaController;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

test('Verificación de respuesta HTTP de la ruta de convocatorias sin parámetros', function () {
    get(route('convocatorias'))->assertStatus(200);
});

test('Verificación de respuesta HTTP de la ruta de convocatorias con página', function () {
    get(route('convocatorias', ['pagina' => 1]))->assertStatus(200);
});

test('Verificación de respuesta HTTP de la ruta de convocatorias con parámetros de selección', function () {
    get(route('convocatorias', ['pagina' => 1, 'seleccionar_parametro' => 'categoria', 'valor_parametro' => 'test']))->assertStatus(200);
});

test('Verificación de contenido específico en la página de convocatorias', function () {
    get(route('convocatorias'))->assertSee('Convocatorias');
});

test('Verificación de controlador en la ruta de convocatorias', function () {
    $action = app('router')->getRoutes()->getByName('convocatorias')->getActionName();
    expect($action)->toBe(ConvocatoriaController::class.'@indice');
});

test('Verificación de respuesta HTTP de la ruta de búsqueda de convocatorias', function () {
    post(route('convocatorias.buscar'), [
        'seleccionar_parametro' => 'categoria',
        'valor_parametro' => 'test'
    ])->assertStatus(200);
});

test('Verificación de controlador en la ruta de búsqueda de convocatorias', function () {
    $action = app('router')->getRoutes()->getByName('convocatorias.buscar')->getActionName();
    expect($action)->toBe(ConvocatoriaController::class.'@buscar');
});