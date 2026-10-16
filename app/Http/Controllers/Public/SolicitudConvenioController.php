<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\GuardarSolicitudConvenioRequest;
use App\Mail\NuevaSolicitudConvenio;
use App\Models\SolicitudConvenio;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class SolicitudConvenioController extends Controller
{
    /**
     * Guarda la solicitud de alianza y avisa por correo al equipo (en cola, no dentro de la petición).
     */
    public function store(GuardarSolicitudConvenioRequest $request): RedirectResponse
    {
        // Si un bot llenó el campo trampa, se responde igual pero no se guarda nada
        if ($request->filled('empresa_web')) {
            return back();
        }

        $solicitud = SolicitudConvenio::create([
            ...$request->safe()->except(['acepta', 'empresa_web']),
            'ip' => $request->ip(),
        ]);

        Mail::to(config('avanzia.email_convenios'))->queue(new NuevaSolicitudConvenio($solicitud));

        return back();
    }
}
