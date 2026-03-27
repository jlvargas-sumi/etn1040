<?php

use App\Http\Controllers\Auth\AutenticacionUsuarioController;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

test('Verificación de respuesta HTTP de la ruta de cerrar sesión con GET', function () {
    get(route('cerrar-sesion'))->assertStatus(302); // Redirección tras cerrar sesión
});

test('Verificación de respuesta HTTP de la ruta de cerrar sesión con POST', function () {
    post(route('cerrar-sesion'))->assertStatus(302); // Redirección tras cerrar sesión
});

test('Verificación de controlador en la ruta de cerrar sesión', function () {
    $action = app('router')->getRoutes()->getByName('cerrar-sesion')->getActionName();
    expect($action)->toBe(AutenticacionUsuarioController::class.'@destruir');
});