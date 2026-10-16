<?php

namespace App\Http\Controllers\Public;

use App\Enums\CategoriaCurso;
use App\Enums\ModalidadCurso;
use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Models\Opinion;
use App\Support\OpcionesOpinion;
use App\Support\Paises;
use App\Support\Seo;
use Illuminate\Database\Eloquent\Collection;
use Inertia\Inertia;
use Inertia\Response;

class InicioController extends Controller
{
    public function __invoke(): Response
    {
        $publicados = Curso::publicados()
            ->conInteresados()
            ->where('modalidad', ModalidadCurso::EnVivo)
            ->get();

        $cursos = $publicados->map(fn (Curso $curso) => [
            'id' => $curso->id,
            'titulo' => $curso->titulo,
            'categoria' => $curso->categoria->value,
            'categoriaNombre' => $curso->categoria->nombre(),
            'descripcion' => $curso->descripcion,
            'horas' => $curso->horas,
            'duracion' => $curso->duracion,
            'gratuito' => $curso->gratuito,
            'imagen' => $curso->imagen,
            'color' => $curso->color,
            'temarioImagen' => $curso->temario_imagen,
            'interesados' => $curso->totalInteresados(),
        ]);

        return Inertia::render('public/Inicio', [
            'seo' => Seo::make(
                title: 'Avanzia América Latina | Inteligencia artificial para docentes',
                description: 'Cursos en vivo y grabados para docentes de América Latina: aprende a usar inteligencia artificial para planificar, evaluar y crear materiales.',
                datosEstructurados: [
                    [
                        '@type' => 'WebSite',
                        'name' => config('avanzia.organizacion.nombre'),
                        'url' => url('/'),
                        'inLanguage' => 'es',
                        'publisher' => ['@id' => url('/').'#organizacion'],
                    ],
                    $this->listaDeCursos($publicados),
                ],
            ),
            'cursos' => $cursos,
            'categorias' => collect(CategoriaCurso::cases())
                ->map(fn (CategoriaCurso $categoria) => ['id' => $categoria->value, 'nombre' => $categoria->nombre()]),
            'opiniones' => Opinion::aprobadas()
                ->latest('aprobada_en')
                ->limit(18)
                ->get(Opinion::CAMPOS_PUBLICOS),
            'estadisticas' => Opinion::estadisticas(),
            'paises' => Paises::OPINION,
            // Las mismas opciones que valida GuardarOpinionRequest
            'cursosOpinion' => OpcionesOpinion::cursos(),
            'umbralInteresados' => config('avanzia.umbral_interesados'),
        ]);
    }

    /**
     * Catálogo como JSON-LD. Cuando existan páginas por curso, cada elemento debe llevar su `url`.
     *
     * @param  Collection<int, Curso>  $cursos
     * @return array<string, mixed>
     */
    private function listaDeCursos(Collection $cursos): array
    {
        return [
            '@type' => 'ItemList',
            'name' => 'Cursos en vivo para docentes',
            'itemListElement' => $cursos->values()->map(fn (Curso $curso, int $i) => [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'item' => [
                    '@type' => 'Course',
                    'name' => $curso->titulo,
                    'description' => $curso->descripcion,
                    'inLanguage' => 'es',
                    'isAccessibleForFree' => $curso->gratuito,
                    'provider' => ['@id' => url('/').'#organizacion'],
                ],
            ])->all(),
        ];
    }
}
