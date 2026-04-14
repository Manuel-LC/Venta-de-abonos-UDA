<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AbonosApiController;

/*
|--------------------------------------------------------------------------
| API Routes — Venta de abonos U.D. Almería
|--------------------------------------------------------------------------
|
| Rutas públicas:
|   GET  /api/tipos-abono          → Lista de tipos y precios
|   POST /api/abonos               → Compra de un abono (validación en API)
|   GET  /api/abonos/{id}/ticket   → Datos del ticket
|
| Rutas protegidas (cabecera X-API-Key requerida):
|   GET  /api/abonos               → Listado completo de abonos
|
*/

// ── Públicas ──────────────────────────────────────────────────────────────
Route::get('/tipos-abono', [AbonosApiController::class, 'tiposAbono']);
Route::post('/abonos',     [AbonosApiController::class, 'store']);
Route::get('/abonos/{id}/ticket', [AbonosApiController::class, 'ticket']);

// ── Protegida con API Key ─────────────────────────────────────────────────
Route::middleware('api.key')->group(function () {
    Route::get('/abonos', [AbonosApiController::class, 'index']);
});