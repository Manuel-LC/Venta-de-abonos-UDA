<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AutenticadoMiddleware;
use App\Http\Middleware\ApiKeyMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        /*
        |----------------------------------------------------------------------
        | AÑADIDO: Rutas de la API REST.
        | Todas las rutas en routes/api.php quedan prefijadas con /api
        | automáticamente por Laravel.
        |----------------------------------------------------------------------
        */
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            /*
            |------------------------------------------------------------------
            | AÑADIDO: Middleware de API Key para rutas protegidas de la API.
            | Uso en routes/api.php:  Route::middleware('api.key')->group(...)
            |------------------------------------------------------------------
            */
            'api.key'    => ApiKeyMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();