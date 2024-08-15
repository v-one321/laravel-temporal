<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\ContactoController;
use App\Http\Controllers\api\EmpresaController;
use App\Http\Controllers\api\ServiciosController;
use App\Http\Controllers\api\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(["middleware" => "auth:sanctum"], function(){
    Route::post('/logout', [AuthController::class, 'logout']);
    /*****************          EMPRESA         ****************** */
    Route::post('/empresa', [EmpresaController::class, 'store']);
    /*****************          Servicios       ******************* */
    Route::get('/servicios', [ServiciosController::class, 'index']);
    Route::post('/servicios', [ServiciosController::class, 'store']);
    Route::get('/servicios/{id}', [ServiciosController::class, 'show']);
    Route::delete('/servicios/{id}', [ServiciosController::class, 'destroy']);
    Route::post('/servicios/{id}', [ServiciosController::class, 'update']);
});

Route::post('/login', [AuthController::class, 'login']);
/***************        CREAR USUARIO       ****************************** */
Route::post('/usuario', [UsuarioController::class, 'store']);
/***************        EMPRESA             ****************************** */
Route::get('/empresa', [EmpresaController::class, 'index']);
/*****************      Servicios *////////////////////// */
Route::get('/servicios-activos', [ServiciosController::class, 'serviciosActivos']);

Route::post('/enviar-email', [ContactoController::class, 'sendEmail']);