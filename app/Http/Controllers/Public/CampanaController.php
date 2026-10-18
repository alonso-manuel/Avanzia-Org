<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Support\Seo;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Páginas "¡Falta un paso!" de las campañas: tras inscribirse, el docente debe unirse al grupo de WhatsApp.
 * Datos en config/campanas.php. landing.avanzia.org (redirección enmascarada de Spaceship) apunta a
 * /gracias-por-inscribirte, que muestra la campaña "actual".
 */
class CampanaController extends Controller
{
    public function gracias(?string $campana = null): Response
    {
        $clave = $campana ?? config('campanas.actual');
        $datos = config("campanas.lista.{$clave}");

        abort_if($datos === null, 404);

        return Inertia::render('public/campana/Gracias', [
            'seo' => Seo::make(
                title: "¡Falta un paso! | Avanzia - {$datos['curso']}",
                description: "Únete al grupo de WhatsApp del curso {$datos['curso']} para recibir los enlaces de las clases, los manuales y tu certificado.",
                indexar: false,
            ),
            'campana' => $datos,
        ]);
    }
}
