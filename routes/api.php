<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\HoraController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\VerificationController;
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

Route::middleware('auth:sanctum')->group(function () {

    /* Servicios */
    Route::middleware('verified')->delete('/servicios/{servicio}', [ServicioController::class, 'destroy']);
    Route::middleware('verified')->put('/servicios/{servicio}', [ServicioController::class, 'update']);
    Route::middleware('verified')->get('/servicios', [ServicioController::class, 'index']);

    /* Citas */
    Route::middleware('verified')->get('/citas', [CitaController::class, 'index']);
    Route::middleware('verified')->post('/citas', [CitaController::class, 'store']);
    Route::middleware('verified')->delete('/citas/{id}', [CitaController::class, 'destroy']);
    Route::middleware('verified')->put('/citas/{id}', [CitaController::class, 'update']);

    /* Horas */
    Route::middleware('verified')->post('/horas', [HoraController::class, 'store']);


    Route::middleware('verified')->get('/user', function (Request $request) {
        /*Comprobar si el usuario confirmo el email */
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
});

Route::get('email/verify/{id}', [VerificationController::class, 'verify'])->name('verification.verify'); // Make sure to keep this as your route name

/* Autenticacion */
Route::post('/register', [AuthController::class, 'registro']);
Route::post('/login', [AuthController::class, 'login']);
