<?php

namespace App\Http\Controllers\Public;

use App\Enums\EstadoOpinion;
use App\Http\Controllers\Controller;
use App\Http\Requests\Public\GuardarOpinionRequest;
use App\Models\Opinion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class OpinionController extends Controller
{
    /**
     * Publica el testimonio al instante, salvo que la moderación automática lo deje en revisión.
     * Le avisa al formulario el resultado con el flash "opinion" (publicada | en_revision).
     */
    public function store(GuardarOpinionRequest $request): RedirectResponse
    {
        // Si un bot llenó el campo trampa, se responde igual pero no se guarda nada
        if ($request->filled('sitio_web')) {
            Inertia::flash('opinion', 'publicada');

            return back();
        }

        $datos = $request->safe()->except(['acepta_publicacion', 'sitio_web']);

        // El mismo texto desde la misma IP en las últimas 24 h: doble clic o reenvío
        $duplicada = Opinion::query()
            ->where('ip', $request->ip())
            ->where('comentario', $datos['comentario'])
            ->where('created_at', '>=', now()->subDay())
            ->exists();

        if ($duplicada) {
            throw ValidationException::withMessages([
                'comentario' => 'Ya recibimos este mismo testimonio. ¡Gracias!',
            ]);
        }

        $publicar = config('avanzia.opiniones.publicacion_automatica')
            && ! $this->requiereRevision($datos['nombre'].' '.($datos['institucion'] ?? '').' '.$datos['comentario']);

        Opinion::create([
            ...$datos,
            'estado' => $publicar ? EstadoOpinion::Aprobada : EstadoOpinion::Pendiente,
            'aprobada_en' => $publicar ? now() : null,
            'ip' => $request->ip(),
        ]);

        Inertia::flash('opinion', $publicar ? 'publicada' : 'en_revision');

        return back();
    }

    /** ¿Contiene alguna palabra de la lista de revisión? Compara sin tildes ni mayúsculas y por palabra completa. */
    private function requiereRevision(string $texto): bool
    {
        $palabras = preg_split('/[^a-z0-9ñ]+/u', Str::lower(Str::ascii($texto))) ?: [];

        return array_intersect($palabras, config('avanzia.opiniones.palabras_revision')) !== [];
    }
}
