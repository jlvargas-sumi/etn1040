<?php

use App\Http\Controllers\Usuario\Docente\DocenteAnuncioController;
use function Pest\Laravel\get;

test('Verificación de respuesta HTTP de la ruta docente/anuncios', function () {
    get(route('docente.anuncios'))->assertStatus(302);
});

test('Verificación de redirección al login para usuarios no autenticados', function () {
    get(route('docente.anuncios'))->assertRedirect(route('iniciar-sesion'));
});

test('Verificación de controlador en la ruta docente/anuncios', function () {
    $action = app('router')->getRoutes()->getByName('docente.anuncios')->getActionName();
    expect($action)->toBe(DocenteAnuncioController::class.'@indice');
});

test('Verificación de middlewares en la ruta docente/anuncios', function () {
    $route = app('router')->getRoutes()->getByName('docente.anuncios');
    expect($route->getAction('middleware'))->toContain('auth', 'docente');
});

test('Verificación de parámetros opcionales en la ruta docente/anuncios', function () {
    $pagina = 2;
    
    $route = route('docente.anuncios', ['pagina' => $pagina]);
    
    expect($route)->toBeString()
        ->toContain((string)$pagina);
});

test('Verificación de parámetros inválidos en la ruta docente/anuncios', function () {
    $response = get('/docente/anuncios/abc');
    expect($response->status())->not->toBe(200);
});