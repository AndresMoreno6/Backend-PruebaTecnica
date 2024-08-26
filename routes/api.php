<?php

use App\Http\Controllers\CiudadController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\PaisController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::get("/paises", [PaisController::class,'index']);
Route::get('/paises/{pais}/ciudades', [CiudadController::class, 'show']);


// Route::get("/paises/{id}", [PaisController::class,'show']);
Route::get("/ciudades", [CiudadController::class,'index']);

// Route::get('/cambioMoneda', [CiudadController::class, 'getCambio']);

Route::post('/cambioMoneda', [HistorialController::class, 'cambioMoneda']);

Route::post('/clima', [HistorialController::class, 'obtenerClima']);


Route::post('/historial', [HistorialController::class, 'store']);
