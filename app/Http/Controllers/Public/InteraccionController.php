<?php

namespace App\Http\Controllers\Public;

use App\Enums\TipoInteraccion;
use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Models\InteraccionCurso;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class InteraccionController extends Controller
{
    /** Cookie anónima que identifica al navegador (1 año). No guarda datos personales. */
    public const COOKIE = 'avanzia_visitante';

    /**
     * Registra que un visitante vio el temario o agregó el curso al carrito.
     * Solo cuenta una vez por visitante, curso y tipo. Devuelve los interesados actualizados.
     */
    public function store(Request $request, Curso $curso): JsonResponse
    {
        abort_unless($curso->publicado, 404);

        $datos = $request->validate([
            'tipo' => ['required', Rule::enum(TipoInteraccion::class)],
        ]);

        $visitante = $request->cookie(self::COOKIE);

        if (! is_string($visitante) || ! Str::isUuid($visitante)) {
            $visitante = (string) Str::uuid();
        }

        // insertOrIgnore: si ya existe (índice único), no hace nada
        InteraccionCurso::query()->insertOrIgnore([
            'curso_id' => $curso->id,
            'tipo' => $datos['tipo'],
            'visitante' => hash('sha256', $visitante),
            'created_at' => now(),
        ]);

        return response()
            ->json(['interesados' => $curso->contarInteresados() + (int) $curso->alumnos])
            ->withCookie(Cookie::make(self::COOKIE, $visitante, minutes: 60 * 24 * 365, sameSite: 'lax'));
    }
}
