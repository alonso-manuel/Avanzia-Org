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

    'actual' => 'investigacion',

    /*
     * Textos de la página. Si hay varias campañas, cada una puede cambiar cualquiera de ellos
     * agregando su propio bloque 'textos'.
     * Los textos "_resaltado" se muestran destacados: en amarillo, en negrita o subrayados.
     */
    'textos' => [
        'progreso_hecho' => 'Registro exitoso',
        'progreso_pendiente' => 'Paso Final Pendiente',
        'titulo' => '¡Tu registro está casi listo!',
        'inscripcion_antes' => 'Te has inscrito al',
        'inscripcion_resaltado' => 'Seminario-Taller: Inteligencia Artificial y Productividad en la Investigación de Alto Impacto',
        'mensaje_antes' => 'Falta un',
        'mensaje_resaltado' => 'único paso obligatorio',
        'mensaje_despues' => 'para asegurar tu cupo y recibir los materiales.',
        'boton' => 'TOCA AQUÍ PARA FINALIZAR',
        'boton_ayuda' => 'Unirme al grupo oficial del seminario',
        'nota_grupo' => 'Grupo silenciado y seguro. Solo administradores.',
        'advertencia_titulo' => 'ACCESO ESTRICTAMENTE RESTRINGIDO',
        'advertencia_antes' => 'Los enlaces de Google Meet, las grabaciones y la certificación opcional se enviarán',
        'advertencia_resaltado' => 'ÚNICAMENTE',
        'advertencia_despues' => 'por WhatsApp. Si abandonas esta página sin unirte, perderás el acceso al taller.',
        'etiqueta_certificacion' => 'Certificación Opcional',
        'etiqueta_capacitador' => 'Capacitador del Seminario',
        'titulo_temario' => 'Programa Académico de 3 Días',
        'boton_final' => 'Volver arriba para unirme al grupo',
    ],

    'lista' => [

        // Plantilla original: "Landing Gracias Avanzia Investigacion" (tema Astra Child del WordPress anterior)
        'investigacion' => [
            'curso' => 'IA en Investigación',
            'titulo_pagina' => '¡Gracias por Inscribirte! | Avanzia - IA en Investigación',
            'grupo_whatsapp' => 'https://chat.whatsapp.com/Bx1wEydrYWY4hAanT9SBH5',
            // Pizarra oscuro del afiche y dorado Avanzia
            'color' => '#1c2434',
            'color_acento' => '#dca843',
            'capacitador' => [
                'nombre' => 'Ing. Diego Avila',
                'foto' => '/images/campanas/diego-avila.webp',
                'insignia' => 'DOCENTE CERTIFICADO DE GOOGLE',
            ],
            'temario' => [
                [
                    'titulo' => 'Comandos Avanzados de Búsqueda y Matrices de Consistencia',
                    'temas' => [
                        'Domina operadores booleanos y comandos avanzados para localizar literatura gris y documentos académicos ocultos con precisión quirúrgica en Google.',
                        'Aplica estrategias avanzadas de rastreo en repositorios institucionales y bases de datos abiertas para ubicar fuentes primarias.',
                        'Identifica los errores críticos y cuellos de botella al estructurar manualmente la matriz de consistencia tradicional.',
                        'Conoce Avanzia Studio en vivo, el motor de IA especializado para alinear lógicamente problema, objetivos, hipótesis y variables.',
                        'Consolida y exporta tu matriz como la estructura vertebral definitiva para todo el proceso posterior de redacción científica.',
                    ],
                ],
                [
                    'titulo' => 'Análisis Científico Profundo, Revisión Bibliográfica y Auditoría',
                    'temas' => [
                        'Descubre literatura de alto impacto y mapas de citación inteligentes libres de sesgos utilizando Semantic Scholar.',
                        'Acelera la lectura de papers complejos mediante SciSpace, extrayendo metodologías clave y decodificando resultados.',
                        'Centraliza y carga masivamente tus documentos para estructurar tu propio cerebro de investigación con Gemini Notebook.',
                        'Implementa protocolos estrictos anti-alucinaciones, detecta citas fantasma y realiza verificación cruzada de DOIs.',
                        'Genera fichas analíticas automatizadas y resúmenes cruzados como materia prima perfecta para tu artículo científico.',
                    ],
                ],
                [
                    'titulo' => 'Creación de tu Aplicación Web Investigadora potenciada por IA',
                    'temas' => [
                        'Explora el entorno nativo de Google AI Studio y crea herramientas especializadas sin complicaciones técnicas.',
                        'Diseña la arquitectura de tu aplicación configurando un panel interno para gestionar varias tareas simultáneamente.',
                        'Inyecta contexto cargando la matriz de consistencia y las fichas analíticas como memoria permanente.',
                        'Ejecuta una prueba de fuego transformando tus insumos previos en borradores iniciales redactados con rigor académico.',
                        'Domina la gestión autónoma para respaldar, duplicar y actualizar tus herramientas directamente en la nube.',
                    ],
                ],
            ],
        ],
    ],

];
