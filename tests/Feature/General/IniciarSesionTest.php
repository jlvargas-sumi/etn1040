<?php

use App\Http\Controllers\Auth\AutenticacionUsuarioController;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

test('Verificación de respuesta HTTP de la ruta de iniciar sesión', function () {
    get(route('iniciar-sesion'))->assertStatus(200);
});

test('Verificación de contenido específico en la página de iniciar sesión', function () {
    get(route('iniciar-sesion'))->assertSee('Iniciar Sesión');
});

test('Verificación de controlador en la ruta de iniciar sesión', function () {
    $action = app('router')->getRoutes()->getByName('iniciar-sesion')->getActionName();
    expect($action)->toBe(AutenticacionUsuarioController::class.'@indice');
});

test('Verificación de respuesta HTTP de la ruta de autenticación', function () {
    post(route('iniciar-sesion.autenticar'), [
        'usuario' => 'test@example.com',
        'clave' => 'password123'
    ])->assertStatus(302); // Redirección tras autenticación exitosa
});

test('Verificación de controlador en la ruta de autenticación', function () {
    $action = app('router')->getRoutes()->getByName('iniciar-sesion.autenticar')->getActionName();
    expect($action)->toBe(AutenticacionUsuarioController::class.'@autenticar');
});