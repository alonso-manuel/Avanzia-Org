<?php

namespace App\Http\Middleware;

use App\Models\Convenio;
use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

/**
 * Datos que necesita el layout público (PublicLayout) en todas las páginas de la zona.
 * Se aplica solo a las rutas públicas para no consultar la BD en el panel ni en el login.
 */
class CompartirDatosPublicos
{
    public function handle(Request $request, Closure $next): Response
    {
        Inertia::share('convenios', fn () => Convenio::publicados()->get(Convenio::CAMPOS_PUBLICOS));

        return $next($request);
    }
}
