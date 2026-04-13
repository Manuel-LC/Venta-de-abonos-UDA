<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbonosController;
use App\Http\Controllers\UsuariosController;

// Página principal — formulario de compra
Route::get('/',  [AbonosController::class, 'compra'])->name('compra');
Route::post('/', [AbonosController::class, 'procesarCompra'])->name('compra.procesar');

// Ticket tras compra exitosa
Route::get('/ticket/{id}', [AbonosController::class, 'ticket'])->name('ticket');

// Se usa el middleware nativo 'auth' de Laravel
Route::middleware('auth')->group(function () {
    Route::get('/abonos', [AbonosController::class, 'listado'])->name('listado');
});

// Autenticación
Route::get('/login',   [UsuariosController::class, 'login'])->name('login');
Route::post('/login',  [UsuariosController::class, 'procesarLogin'])->name('login.procesar');
Route::post('/logout', [UsuariosController::class, 'logout'])->name('logout');