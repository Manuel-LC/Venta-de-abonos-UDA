<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware de autenticación por API Key.
 *
 * El cliente debe incluir la cabecera:
 *   X-API-Key: <valor de API_KEY en .env>
 *
 * Ejemplo de uso en .env:
 *   API_KEY=mi-clave-secreta-cambiar-en-produccion
 */
class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $keyRecibida   = $request->header('X-API-Key');
        $keyEsperada   = config('app.api_key');

        if (empty($keyRecibida) || $keyRecibida !== $keyEsperada) {
            return response()->json([
                'error'   => 'No autorizado.',
                'mensaje' => 'Debes incluir una cabecera X-API-Key válida.',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}