<?php

/*
 * Páginas de agradecimiento de las campañas (Facebook → formulario → "¡Falta un paso!").
 *
 * - /gracias-por-inscribirte muestra la campaña "actual". landing.avanzia.org es una redirección
 *   enmascarada de Spaceship hacia esa URL, así que cambiar "actual" cambia lo que ve la campaña.
 * - /gracias/{clave} muestra cualquier campaña de la lista (para campañas simultáneas).
 * - Para una campaña nueva: copiar un bloque, cambiar el grupo de WhatsApp, el color y el temario.
 *
 * Son páginas sin indexar (noindex) y fuera del sitemap.
 *
 * Al editar desde cPanel: cada texto va entre comillas simples y termina en coma. Un apóstrofo
 * dentro del texto se escribe \' (p. ej. 'Taller d\'IA'). Si falta una coma o una comilla, el sitio
 * entero da error 500: hacer antes una copia del archivo.
 */
return [

    'actual' => 'ingenieria-pedagogica',

    /*
     * Textos de la página, iguales para todas las campañas. Una campaña puede cambiar
     * cualquiera de ellos con su propio bloque 'textos' (ver el ejemplo comentado más abajo).
     * Los textos "_resaltado" se muestran destacados: en amarillo, en negrita o subrayados.
     */
    'textos' => [
        'progreso_hecho' => 'Registro',
        'progreso_pendiente' => 'Paso Final Pendiente',
        'titulo' => '¡Tu registro está casi listo!',
        'mensaje_antes' => 'Solo falta',
        'mensaje_resaltado' => '1 paso obligatorio',
        'mensaje_despues' => 'para asegurar tu cupo y recibir los enlaces de Zoom.',
        'boton' => 'UNIRME AL GRUPO',
        'boton_ayuda' => 'Toca aquí para finalizar',
        'advertencia_titulo' => '¡Atención!',
        'advertencia_antes' => 'Los accesos a las clases, manuales y certificados se enviarán',
        'advertencia_resaltado' => 'ÚNICAMENTE',
        'advertencia_despues' => 'por este grupo de WhatsApp. Si no entras, perderás el curso.',
        'nota_grupo' => 'Grupo cerrado y sin SPAM.',
        'resumen' => 'Resumen de tu inscripción',
        'etiqueta_capacitador' => 'Capacitador del Programa',
        'titulo_temario' => 'Temario que estás a punto de recibir:',
        'pregunta_final' => '¿Aún no te unes al grupo exclusivo?',
        'boton_final' => 'Ir arriba para unirme al grupo',
    ],

    'lista' => [

        // Plantilla original: page-gracias-ingenieria.php (tema Astra Child del WordPress anterior)
        'ingenieria-pedagogica' => [
            'curso' => 'Ingeniería Pedagógica',
            'grupo_whatsapp' => 'https://chat.whatsapp.com/DTfERpApJzVEgj1tEzp5hF',
            // Borgoña del afiche del curso
            'color' => '#6b1f38',
            'color_oscuro' => '#4a1527',
            'capacitador' => [
                'nombre' => 'Ing. Diego Avila',
                'foto' => '/images/campanas/diego-avila.webp',
                'insignia' => 'Google for Education Partner',
            ],
            // Textos propios de esta campaña (opcional). Ejemplo: quitar las // para cambiar el título.
            'textos' => [
                // 'titulo' => '¡Ya casi eres parte de Ingeniería Pedagógica!',
            ],
            'temario' => [
                [
                    'titulo' => 'Dominando el Ecosistema de la IA:',
                    'subtitulo' => 'De la Coherencia Pedagógica al Tangible HTML',
                    'temas' => [
                        'Configuración y dominio avanzado de herramientas de Inteligencia Artificial de última generación para el ecosistema docente.',
                        'Ingeniería del prompting aplicada: optimización, estructuración y refinamiento de interacciones para maximizar el rigor académico.',
                        'Diseño del Perfil Pedagógico General y establecimiento del Hilo Maestro como la columna vertebral de la coherencia curricular.',
                        'Traducción de lineamientos pedagógicos complejos en arquitecturas de código optimizadas asistidas por IA.',
                        'Desarrollo interactivo y programación guiada de un recurso digital interactivo adaptado a las necesidades de la clase.',
                    ],
                ],
                [
                    'titulo' => 'De la Planificación Institucional al Diseño Visual:',
                    'subtitulo' => 'RAG y Proyectos STEAM Automatizados',
                    'temas' => [
                        'Integración pedagógica avanzada mediante RAG utilizando fuentes institucionales y académicas verificadas.',
                        'Despliegue de un prompt específico para garantizar la continuidad absoluta entre el Hilo Maestro y los contenidos de valor sin alucinaciones.',
                        'Estructuración metodológica de proyectos transversales STEAM impulsados por inteligencia artificial.',
                        'Automatización inteligente de sistemas de evaluación, rúbricas de desempeño e informes de retroalimentación formativa.',
                        'Cierre visual dinámico con Napkin para transformar flujos, esquemas curriculares y procesos evaluativos en diagramas profesionales de alto impacto visual.',
                    ],
                ],
                [
                    'titulo' => 'Inmersión Total en Gemini Notebook:',
                    'subtitulo' => 'Ecosistemas de Conocimiento y Podcast Educativo',
                    'temas' => [
                        'Arquitectura y configuración experta de espacios de trabajo centralizados y seguros en NotebookLM.',
                        'Gestión avanzada de fuentes de conocimiento heterogéneas.',
                        'Estrategias de interrogación experta y síntesis académica automatizada de alta precisión sobre la base documental propia.',
                        'Creación de recursos didácticos dinámicos, guías de estudio personalizadas y bancos de preguntas estratégicas para los alumnos.',
                        'Producción de Audio Overviews (podcasts educativos conversacionales generados por IA) diseñados para potenciar el repaso y aprendizaje autónomo.',
                    ],
                ],
            ],
        ],

    ],

];
