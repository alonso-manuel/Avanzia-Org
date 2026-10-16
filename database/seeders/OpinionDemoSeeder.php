<?php

namespace Database\Seeders;

use App\Enums\EstadoOpinion;
use App\Models\Opinion;
use Illuminate\Database\Seeder;

/**
 * Opiniones ficticias de la plantilla, solo para ver el diseño en local.
 * No ejecutar en producción: allí solo se publican opiniones reales aprobadas.
 */
class OpinionDemoSeeder extends Seeder
{
    public function run(): void
    {
        $opiniones = [
            ['María Gómez', 'pe', 'Lima', 'IEP Innova', 'Evaluación Formativa', 'Increíble. Redujo mis horas de planificación a solo minutos. El enfoque de evaluación formativa es exacto a lo que pide el MINEDU.', 5],
            ['Carlos Ruiz', 'co', 'Bogotá', 'Univ. Nacional', 'IA Aplicada a la Docencia', 'El curso de IA me abrió la mente. Ahora estructuro proyectos completos en tiempo récord.', 5],
            ['Elena Suárez', 'mx', 'CDMX', 'Tec. Monterrey', 'Investigación Académica', 'La metodología se hace más digerible. Excelentes profesores y una plataforma muy intuitiva.', 5],
            ['Javier Pérez', 'cl', 'Santiago', 'Liceo Bicentenario', 'Avanzia STUDIO', 'La integración del marco curricular es perfecta. Mis unidades didácticas salen listas para aplicar.', 4],
            ['Andrea Rojas', 'ar', 'Buenos Aires', 'UBA', 'Diseño Universal', 'Me ayudó muchísimo a adaptar mis clases para asegurar la inclusión de todos mis alumnos.', 5],
            ['Luis Fernando', 'ec', 'Quito', 'Colegio Mejía', 'Google Workspace', 'Por fin domino las herramientas colaborativas. Mis clases virtuales mejoraron al 100%.', 5],
            ['Patricia L.', 'pe', 'Arequipa', 'Colegio San José', 'Avanzia STUDIO', 'Las rúbricas que genera la IA tienen un nivel de detalle que me tomaba horas redactar manualmente.', 5],
            ['Roberto M.', 'ar', 'Córdoba', 'IES', 'IA Aplicada a la Docencia', 'El enfoque práctico del curso es invaluable. No es solo teoría, aprendes creando.', 4],
            ['Sofía V.', 'bo', 'La Paz', 'UMSA', 'Metodología de Investigación', 'Pude armar mi matriz de consistencia sin estrés. Gran apoyo de los capacitadores.', 5],
            ['Diego A.', 'pe', 'Trujillo', 'UCV', 'Avanzia STUDIO', 'Subo mis propios PDFs y la IA me crea cuestionarios precisos. Totalmente recomendado.', 5],
            ['Carolina B.', 'co', 'Medellín', 'EAFIT', 'Google Workspace', 'Muy bien estructurado. Aprendí trucos que me ahorran tiempo todos los días.', 5],
            ['Miguel T.', 'mx', 'Guadalajara', 'UDG', 'Evaluación Formativa', 'Cambió mi forma de evaluar. Ahora mis estudiantes entienden exactamente qué se espera de ellos.', 5],
        ];

        // La primera de la lista queda como la más reciente
        foreach ($opiniones as $i => [$nombre, $pais, $ciudad, $institucion, $curso, $comentario, $estrellas]) {
            Opinion::updateOrCreate(['nombre' => $nombre, 'curso' => $curso], [
                'pais' => $pais,
                'ciudad' => $ciudad,
                'institucion' => $institucion,
                'comentario' => $comentario,
                'estrellas' => $estrellas,
                'estado' => EstadoOpinion::Aprobada,
                'aprobada_en' => now()->subMinutes($i),
            ]);
        }
    }
}
