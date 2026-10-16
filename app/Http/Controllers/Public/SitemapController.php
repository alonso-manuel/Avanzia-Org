<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Sitemap para Google Search Console. Agregar aquí cada página pública indexable
     * (validación, legales, páginas por curso…) a medida que se creen.
     */
    public function __invoke(): Response
    {
        $paginas = [
            ['url' => route('home'), 'lastmod' => Curso::max('updated_at')],
            ...collect(['quienes-somos', 'convenios', 'testimonios', 'validacion', 'libro-reclamaciones', 'privacidad', 'terminos', 'descargo', 'copyright'])
                ->map(fn (string $ruta) => ['url' => route($ruta), 'lastmod' => null]),
        ];

        return response()
            ->view('sitemap', ['paginas' => $paginas])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
