<?php

use App\Http\Controllers\PensumController;
use function Pest\Laravel\get;

test('Verificación de respuesta HTTP de la ruta de pensum', function () {
    get(route('pensum'))->assertStatus(200);
});

test('Verificación de contenido específico en la página de pensum', function () {
    get(route('pensum'))->assertSee('Pensum');
});

test('Verificación de controlador en la ruta de pensum', function () {
    $action = app('router')->getRoutes()->getByName('pensum')->getActionName();
    expect($action)->toBe(PensumController::class.'@indice');
});