<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Opinion;
use App\Support\OpcionesConvenio;
use App\Support\OpcionesOpinion;
use App\Support\Paises;
use App\Support\Seo;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Páginas públicas de contenido fijo. Conservan las URLs del WordPress anterior.
 */
class PaginaController extends Controller
{
    public function quienesSomos(): Response
    {
        return Inertia::render('public/QuienesSomos', [
            'seo' => Seo::make(
                title: 'Quiénes somos | Avanzia América Latina',
                description: 'Conectamos a los docentes de América Latina con la inteligencia artificial y las herramientas digitales más avanzadas. Conoce nuestra misión y visión.',
                datosEstructurados: [[
                    '@type' => 'AboutPage',
                    'url' => route('quienes-somos'),
                    'about' => ['@id' => url('/').'#organizacion'],
                ]],
            ),
        ]);
    }

    /** Los convenios llegan como prop compartida (CompartirDatosPublicos). */
    public function convenios(): Response
    {
        return Inertia::render('public/Convenios', [
            'seo' => Seo::make(
                title: 'Convenios y alianzas | Avanzia América Latina',
                description: 'Instituciones educativas y organizaciones magisteriales de América Latina que respaldan las capacitaciones de Avanzia. Establece una alianza para tu plana docente.',
            ),
            'opciones' => [
                'tiposInstitucion' => OpcionesConvenio::TIPOS_INSTITUCION,
                'intereses' => OpcionesConvenio::INTERESES,
                'paises' => OpcionesConvenio::PAISES,
            ],
        ]);
    }

    /** Todos los testimonios publicados, del más reciente al más antiguo. */
    public function testimonios(): Response
    {
        $opiniones = Opinion::aprobadas()
            ->latest('aprobada_en')
            ->latest('id')
            ->paginate(12, Opinion::CAMPOS_PUBLICOS)
            ->withQueryString();

        $pagina = $opiniones->currentPage() > 1 ? " (página {$opiniones->currentPage()})" : '';

        return Inertia::render('public/Testimonios', [
            'seo' => Seo::make(
                title: "Testimonios de docentes{$pagina} | Avanzia América Latina",
                description: 'Lo que opinan los docentes de América Latina que se capacitaron con Avanzia: cursos en vivo, Avanzia STUDIO y más. Deja también tu testimonio.',
            ),
            'opiniones' => $opiniones,
            'estadisticas' => Opinion::estadisticas(),
            // Para el formulario "Añadir testimonio"
            'paises' => Paises::OPINION,
            'cursosOpinion' => OpcionesOpinion::cursos(),
        ]);
    }

    public function validacion(): Response
    {
        return Inertia::render('public/Validacion', [
            'seo' => Seo::make(
                title: 'Validación de certificados | Avanzia América Latina',
                description: 'Verifica la autenticidad de los certificados emitidos por Avanzia América Latina SAC (RUC 20613857894), válidos en nueve países de América Latina.',
            ),
        ]);
    }

    public function libroReclamaciones(): Response
    {
        return Inertia::render('public/LibroReclamaciones', [
            'seo' => Seo::make(
                title: 'Libro de Reclamaciones | Avanzia América Latina',
                description: 'Libro de Reclamaciones virtual de Avanzia América Latina SAC. Registra tu queja o reclamo.',
            ),
        ]);
    }

    public function privacidad(): Response
    {
        return $this->legal('Privacidad', 'Política de Privacidad', 'Cómo Avanzia América Latina recopila, usa y protege los datos personales de quienes visitan su sitio web.');
    }

    public function descargo(): Response
    {
        return $this->legal('Descargo', 'Descargo de Responsabilidad', 'Alcance y limitaciones de la información publicada en el sitio web de Avanzia América Latina.');
    }

    public function terminos(): Response
    {
        return $this->legal('Terminos', 'Términos y Condiciones', 'Condiciones para los participantes de los cursos de Avanzia América Latina SAC: pagos, certificación, uso del material y propiedad intelectual.');
    }

    public function copyright(): Response
    {
        return $this->legal('Copyright', 'Copyright', 'Derechos de autor sobre el sitio web y los contenidos de Avanzia América Latina.');
    }

    /** El texto de cada documento está en resources/js/pages/public/legal/{Pagina}.vue. */
    private function legal(string $pagina, string $titulo, string $descripcion): Response
    {
        return Inertia::render("public/legal/{$pagina}", [
            'seo' => Seo::make(
                title: "{$titulo} | Avanzia América Latina",
                description: $descripcion,
            ),
        ]);
    }
}
