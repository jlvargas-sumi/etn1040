<?php

use App\Http\Controllers\InicioController;
use App\Http\Controllers\NosotrosController;
use App\Http\Controllers\AnuncioController;
use App\Http\Controllers\ComunicadoController;
use App\Http\Controllers\ConvocatoriaController;
use App\Http\Controllers\PensumController;
use App\Http\Controllers\HorarioController;

use App\Http\Controllers\PruebaController;

use Illuminate\Support\Facades\Route;

Route::get('/', [InicioController::class, 'indice'])->name('inicio');
Route::get('/nosotros', [NosotrosController::class, 'indice'])->name('nosotros');
Route::get('/anuncios', [AnuncioController::class, 'indice'])->name('anuncios');
Route::get('/comunicados', [ComunicadoController::class, 'indice'])->name('comunicados');
Route::get('/convocatorias', [ConvocatoriaController::class, 'indice'])->name('convocatorias');
Route::get('/pensum', [PensumController::class, 'indice'])->name('pensum');
Route::get('/horarios', [HorarioController::class, 'indice'])->name('horarios');
Route::post('/horarios', [HorarioController::class, 'buscar'])->name('horarios.buscar');
Route::get('/pruebas/borrar-cache', [PruebaController::class, 'borrarCache'])->name('pruebas.borrar-cache');
Route::get('/pruebas', [PruebaController::class, 'indice'])->name('pruebas');
Route::get('/pruebas/rich', [PruebaController::class, 'rich']);
Route::post('/pruebas/rich', [PruebaController::class, 'rich'])->name('rich');
Route::post('/pruebas/bcsrf', [PruebaController::class, 'bcsrf'])->name('bcsrf');
Route::get('/pruebas/pdf', [PruebaController::class, 'pdf'])->name('pdf');
Route::post('/pruebas/buscar', [PruebaController::class, 'buscar'])->name('pruebas.buscar');

require __DIR__.'/auth.php';
require __DIR__.'/servicios.php';