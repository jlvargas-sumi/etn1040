<?php

use App\Http\Controllers\Api\PersonalController;
use App\Http\Controllers\Api\CarreraController;

use Illuminate\Support\Facades\Route;


// Peticiones
Route::get('/datos/personal/{ci?}', [PersonalController::class, 'datosPersonalPorCi']);
Route::get('/datos/estudiante/{ru?}', [PersonalController::class, 'datosEstudiantePorRu']);
Route::get('/datos/pensum-asignatura-completo/{id?}', [CarreraController::class, 'datosPensumPorAsignaturaCompleto']);

