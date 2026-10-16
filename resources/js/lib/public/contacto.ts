// Datos de contacto y enlaces externos de la landing (docs/CONTEXTO_AVANZIA.md)

export const STUDIO_URL = 'https://studio.avanzia.org/';
export const PORTAL_URL = 'https://portal.avanzia.org/';

export const WHATSAPP_NUMERO = '51965654894';

export const EMAIL = 'avanzia@avanzia.org';
export const TELEFONO = '+51 999 576 778';
export const RUC = '20613857894';
export const RAZON_SOCIAL = 'AVANZIA AMERICA LATINA SAC';
export const DOMICILIO = 'Av. Apurímac 431, Cusco, Cusco, Perú';

/** Enlace a WhatsApp con un mensaje ya escrito. */
export function whatsapp(mensaje?: string): string {
    const base = `https://wa.me/${WHATSAPP_NUMERO}`;

    return mensaje ? `${base}?text=${encodeURIComponent(mensaje)}` : base;
}

// Páginas públicas propias: conservan las URLs del sitio actual
export const RUTAS_LEGALES = {
    quienesSomos: '/quienes-somos',
    convenios: '/convenios',
    testimonios: '/testimonios',
    validacion: '/validacionlegalcertificadoavanzia',
    libroReclamaciones: '/libro-de-reclamaciones',
    privacidad: '/politica-de-privacidad',
    terminos: '/terminos-y-condiciones',
    descargo: '/descargo-de-responsabilidad',
    copyright: '/copyright',
} as const;
