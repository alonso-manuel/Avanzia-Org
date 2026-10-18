/** Metadatos que envía App\Support\Seo a cada página pública. */
export type Seo = {
    title: string;
    description: string;
    url: string;
    image: string;
    /** Nodos JSON-LD propios de la página; app.blade.php los escribe junto al de la organización. */
    datosEstructurados: Record<string, unknown>[];
    /** false = la página no debe aparecer en buscadores (noindex). */
    indexar: boolean;
};
