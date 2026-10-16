<?php

namespace Database\Seeders;

use App\Models\Curso;
use Illuminate\Database\Seeder;

/**
 * Catálogo real de Avanzia. Se va completando a medida que el cliente envía cada curso
 * (afiche cuadrado en public/images/cursos/{slug}.webp y temario en {slug}-temario.webp).
 * `alumnos`: docentes capacitados en ciclos anteriores, cifra real informada por Avanzia
 * ("más de 120 por curso", 16/10/2026). Actualizarla con datos reales; nunca inventarla.
 */
class CursoSeeder extends Seeder
{
    public function run(): void
    {
        $cursos = [
            [
                'slug' => 'ingenieria-pedagogica-ia',
                'titulo' => 'Ingeniería Pedagógica con IA: Metodologías STEAM, RAG y Herramientas de Vanguardia',
                'categoria' => 'ia',
                'descripcion' => 'Aprende a dominar la inteligencia artificial generativa y herramientas de vanguardia como docente.',
                'duracion' => '3 días',
                'gratuito' => false,
                'alumnos' => 120,
            ],
            [
                'slug' => 'experto-gemini-avanzado',
                'titulo' => 'Experto en Gemini Avanzado: Creación de Aplicaciones Multitarea y Cuadernos Inteligentes aplicados en la Docencia',
                'categoria' => 'ia',
                'descripcion' => 'Domina el modelo de inteligencia artificial de Gemini. Utiliza tokens contextuales y evita alucinaciones.',
                'duracion' => '3 días',
                'gratuito' => false,
                'alumnos' => 120,
            ],
            [
                'slug' => 'ia-estrategica-claude',
                'titulo' => 'Inteligencia Artificial Estratégica con Claude: Optimización Curricular y Docencia de Alto Impacto',
                'categoria' => 'ia',
                'descripcion' => 'Aprende a utilizar el entorno de Claude como docente y a crear proyectos y artifacts en el ecosistema de Anthropic.',
                'duracion' => '3 días',
                'gratuito' => false,
                'alumnos' => 120,
            ],
            [
                'slug' => 'narrativas-que-ensenan-storytelling',
                'titulo' => 'Narrativas que Enseñan: Storytelling Educativo desde Cero con Inteligencia Artificial',
                'categoria' => 'metodologia',
                'descripcion' => 'Aprende a narrar con impacto: transforma tus sesiones en historias cautivantes y crea personajes, entornos y storyboards.',
                'duracion' => '3 días',
                'gratuito' => false,
                'alumnos' => 120,
            ],
            [
                'slug' => 'investigacion-inteligente-ia',
                'titulo' => 'Investigación Inteligente: Estrategias Avanzadas con IA para el Docente del Siglo XXI',
                'categoria' => 'investigacion',
                'descripcion' => 'Aprende a investigar con inteligencia artificial: usa herramientas potenciadas por IA para hacer el proceso investigativo con ética, profesionalismo y eficiencia.',
                'duracion' => '3 días',
                'gratuito' => false,
                'alumnos' => 120,
            ],
            [
                'slug' => 'herramientas-digitales-gamificacion',
                'titulo' => 'Aplicación de Herramientas Digitales para la Gamificación Educativa',
                'categoria' => 'metodologia',
                'descripcion' => 'Domina Kahoot, Quizizz, Blooket, Gimkit, Educaplay y Wordwall, herramientas orientadas a la gamificación educativa.',
                'duracion' => '3 días',
                'gratuito' => false,
                'alumnos' => 120,
            ],
        ];

        foreach ($cursos as $orden => $curso) {
            Curso::updateOrCreate(['slug' => $curso['slug']], [
                ...$curso,
                'modalidad' => 'en_vivo',
                'imagen' => "/images/cursos/{$curso['slug']}.webp",
                'temario_imagen' => "/images/cursos/{$curso['slug']}-temario.webp",
                'color' => 'naranja',
                'publicado' => true,
                'orden' => $orden,
            ]);
        }
    }
}
