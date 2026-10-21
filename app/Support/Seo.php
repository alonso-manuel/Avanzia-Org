<?php

namespace App\Support;

/**
 * Metadatos de una página pública. Se envían como prop `seo` y la vista
 * raíz (resources/views/app.blade.php) los escribe en el HTML desde el servidor.
 */
class Seo
{
    /**
     * @param  list<array<string, mixed>>  $datosEstructurados  Nodos JSON-LD propios de la página (cursos, etc.)
     * @param  bool  $indexar  false para páginas que no deben aparecer en buscadores (p. ej. agradecimientos de campañas)
     * @return array{title: string, description: string, url: string, image: string, datosEstructurados: list<array<string, mixed>>, indexar: bool}
     */
    public static function make(
        string $title,
        string $description,
        ?string $image = null,
        array $datosEstructurados = [],
        bool $indexar = true,
    ): array {
        return [
            'title' => $title,
            'description' => $description,
            'url' => request()->url(),
            'image' => url()->to($image ?? config('avanzia.imagen_social')),
            'datosEstructurados' => $datosEstructurados,
            'indexar' => $indexar,
        ];
    }

    /**
     * JSON-LD de la organización, presente en todas las páginas públicas.
     * Le da a los buscadores la información clave sin depender del JavaScript (no hay SSR).
     *
     * @return array<string, mixed>
     */
    public static function organizacion(): array
    {
        $org = config('avanzia.organizacion');

        return [
            '@type' => 'EducationalOrganization',
            '@id' => url('/').'#organizacion',
            'name' => $org['nombre'],
            'legalName' => $org['razon_social'],
            'description' => $org['descripcion'],
            'url' => url('/'),
            'logo' => url($org['logo']),
            'email' => $org['email'],
            'sameAs' => $org['redes'],
            'areaServed' => 'Latinoamérica',
            'address' => ['@type' => 'PostalAddress', 'addressCountry' => $org['pais']],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'contactType' => 'customer service',
                'telephone' => $org['whatsapp'],
                'email' => $org['email'],
                'availableLanguage' => 'es',
            ],
        ];
    }

    /**
     * Bloque JSON-LD listo para insertar en <script type="application/ld+json">.
     * JSON_HEX_TAG evita que un texto de la BD con "</script>" cierre la etiqueta.
     *
     * @param  list<array<string, mixed>>  $nodos
     */
    public static function jsonLd(array $nodos): string
    {
        return json_encode(
            ['@context' => 'https://schema.org', '@graph' => [self::organizacion(), ...$nodos]],
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_THROW_ON_ERROR,
        );
    }
}
