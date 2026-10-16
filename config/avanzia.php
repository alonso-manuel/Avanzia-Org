<?php

/*
 * Datos de la organización para SEO (JSON-LD) y redirecciones del sitio WordPress anterior.
 * Los datos de contacto del frontend están en resources/js/lib/public/contacto.ts.
 */
return [

    'organizacion' => [
        'nombre' => 'Avanzia América Latina',
        'razon_social' => 'AVANZIA AMERICA LATINA SAC',
        'descripcion' => 'Avanzia América Latina capacita a docentes de inicial, primaria, secundaria y superior en inteligencia artificial y herramientas digitales. Ofrece cursos en vivo de 3 días, 100% online y con certificado, cursos grabados para estudiar a tu ritmo y Avanzia STUDIO, un asistente con IA que crea sesiones, rúbricas y materiales en pocos minutos.',
        'logo' => '/images/logo-avanzia.png',
        'email' => 'avanzia@avanzia.org',
        'whatsapp' => '+51965654894',
        'pais' => 'PE',
        'redes' => [
            'https://www.facebook.com/avanzialatam',
            'https://www.instagram.com/avanzialatam',
        ],
    ],

    // A dónde llegan los avisos de nuevas solicitudes de convenio (/convenios)
    'email_convenios' => env('AVANZIA_EMAIL_CONVENIOS', 'avanzia@avanzia.org'),

    // Desde cuántos interesados se muestra el contador en la tarjeta del curso (menos se ve mal)
    'umbral_interesados' => (int) env('AVANZIA_UMBRAL_INTERESADOS', 10),

    /*
     * Testimonios: cualquiera puede publicar el suyo. Se publican al instante salvo que contengan
     * alguna de estas palabras (en minúsculas, sin tildes): entonces quedan "pendiente" y no se muestran.
     * Para despublicar uno: cambiar su estado a "rechazada" en la tabla opiniones.
     */
    'opiniones' => [
        'publicacion_automatica' => (bool) env('AVANZIA_OPINIONES_AUTOMATICAS', true),
        'palabras_revision' => [
            'idiota', 'imbecil', 'estupido', 'estafa', 'estafadores', 'ladron', 'ladrones', 'mierda',
            'puta', 'puto', 'carajo', 'cojudo', 'huevon', 'pendejo', 'concha', 'conchatumadre',
            'ctm', 'csm', 'chucha', 'verga', 'cabron', 'maricon', 'basura', 'fraude', 'porno',
            'casino', 'apuestas', 'bitcoin', 'cripto', 'viagra', 'prestamo',
        ],
    ],

    // Imagen para compartir cuando una página no define la suya (1200×630)
    'imagen_social' => '/images/og-avanzia.jpg',

    /*
     * URLs del WordPress anterior (sitemap de octubre de 2026). Laravel ignora la barra final,
     * así que "cursos" cubre también "/cursos/".
     * Las páginas que se conservan (quienes-somos, validación, libro de reclamaciones, legales)
     * tienen ruta propia en routes/web.php.
     */
    'redirecciones' => [
        'cursos' => '/#cursos',
        'contacto' => '/#convenios',
        'product/deepseek-educativo' => '/#cursos',
        'domina-canva-2025-diseno-facil-y-efectivo' => '/#cursos',
        'transforma-la-educacion-con-inteligencia-artificial' => '/#cursos',
        'gracias-por-inscribirte' => '/',
        'wp-sitemap.xml' => '/sitemap.xml',
    ],

    // Páginas de prueba o internas de WordPress: 410 para que Google las retire del índice
    'eliminadas' => [
        'hello-world',
        '1520-2',
        '1522-2',
        'elementor-1597',
        'elementor-1597-copy',
        'elementor-1597-copy-copy',
        'wishsuite',
        'checkout-page',
        'elementor-hf/footer1',
        'elementor-hf/header',
        'category/uncategorized',
        'product-category/uncategorized',
    ],

];
