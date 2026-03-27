<?php

use App\Http\Controllers\AnuncioController;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

test('Verificación de respuesta HTTP de la ruta de anuncios sin parámetros', function () {
    get(route('anuncios'))->assertStatus(200);
});

test('Verificación de respuesta HTTP de la ruta de anuncios con página', function () {
    get(route('anuncios', ['pagina' => 1]))->assertStatus(200);
});

test('Verificación de respuesta HTTP de la ruta de anuncios con parámetros de selección', function () {
    get(route('anuncios', ['pagina' => 1, 'seleccionar_parametro' => 'categoria', 'valor_parametro' => 'test']))->assertStatus(200);
});

test('Verificación de contenido específico en la página de anuncios', function () {
    get(route('anuncios'))->assertSee('Anuncios');
});

test('Verificación de controlador en la ruta de anuncios', function () {
    $action = app('router')->getRoutes()->getByName('anuncios')->getActionName();
    expect($action)->toBe(AnuncioController::class.'@indice');
});

test('Verificación de respuesta HTTP de la ruta de búsqueda de anuncios', function () {
    post(route('anuncios.buscar'), [
        'seleccionar_parametro' => 'categoria',
        'valor_parametro' => 'test'
    ])->assertStatus(200);
});

test('Verificación de controlador en la ruta de búsqueda de anuncios', function () {
    $action = app('router')->getRoutes()->getByName('anuncios.buscar')->getActionName();
    expect($action)->toBe(AnuncioController::class.'@buscar');
});