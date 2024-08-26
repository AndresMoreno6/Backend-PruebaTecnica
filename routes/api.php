<?php

use App\Http\Controllers\CiudadController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\PaisController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get("/paises", [PaisController::class,'paises']);

Route::get('/paises/{pais}/ciudades', [CiudadController::class, 'ciudadesPorPais']);

// Route::get("/ciudades", [CiudadController::class,'index']);

Route::post('/cambioMoneda', [HistorialController::class, 'cambioMoneda']);

Route::post('/clima', [HistorialController::class, 'obtenerClima']);

Route::post('/busquedas', [HistorialController::class, 'guardarBusqueda']);

Route::get('/historial/{id}', [HistorialController::class,'obtenerHistorial']);

Route::get('/busquedashistorial', [HistorialController::class,'historialBusquedas']);
