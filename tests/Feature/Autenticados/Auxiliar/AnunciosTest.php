<?php

use App\Http\Controllers\Usuario\Auxiliar\AuxiliarAnuncioController;
use function Pest\Laravel\get;

test('Verificación de respuesta HTTP de la ruta auxiliar/anuncios', function () {
    get(route('auxiliar.anuncios'))->assertStatus(302);
});

test('Verificación de redirección al login para usuarios no autenticados', function () {
    get(route('auxiliar.anuncios'))->assertRedirect(route('iniciar-sesion'));
});

test('Verificación de controlador en la ruta auxiliar/anuncios', function () {
    $action = app('router')->getRoutes()->getByName('auxiliar.anuncios')->getActionName();
    expect($action)->toBe(AuxiliarAnuncioController::class.'@indice');
});

test('Verificación de middlewares en la ruta auxiliar/anuncios', function () {
    $route = app('router')->getRoutes()->getByName('auxiliar.anuncios');
    expect($route->getAction('middleware'))->toContain('auth', 'auxiliar');
});

test('Verificación de parámetros opcionales en la ruta auxiliar/anuncios', function () {
    $pagina = 2;
    
    $route = route('auxiliar.anuncios', ['pagina' => $pagina]);
    
    expect($route)->toBeString()
        ->toContain((string)$pagina);
});

test('Verificación de parámetros inválidos en la ruta auxiliar/anuncios', function () {
    $response = get('/auxiliar/anuncios/abc');
    expect($response->status())->not->toBe(200);
});