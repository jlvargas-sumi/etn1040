<?php

use App\Http\Controllers\NosotrosController;
use function Pest\Laravel\get;

test('Verificación de respuesta HTTP de la ruta de nosotros', function () {
    get(route('nosotros'))->assertStatus(200);
});

test('Verificación de contenido específico en la página de nosotros', function () {
    get(route('nosotros'))->assertSee('Nosotros');
});

test('Verificación de controlador en la ruta de nosotros', function () {
    $action = app('router')->getRoutes()->getByName('nosotros')->getActionName();
    expect($action)->toBe(NosotrosController::class.'@indice');
});