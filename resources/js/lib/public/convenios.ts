import {
    BookOpen,
    Earth,
    GraduationCap,
    Landmark,
    Laptop,
    Mic,
    Scale,
    School,
    Users,
} from '@lucide/vue';
import type { Component } from 'vue';

// Icono de respaldo mientras un convenio no tenga logo oficial (campo `icono`)
export const ICONOS_CONVENIO: Record<string, Component> = {
    institucion: Landmark,
    graduacion: GraduationCap,
    laptop: Laptop,
    universidad: School,
    personas: Users,
    mundo: Earth,
    microfono: Mic,
    libro: BookOpen,
    balanza: Scale,
};

// Clases completas para que Tailwind las detecte (la BD guarda solo la clave `color`)
export const COLORES_CONVENIO: Record<
    string,
    { texto: string; fondo: string }
> = {
    azul: { texto: 'text-blue-600', fondo: 'bg-blue-50' },
    naranja: { texto: 'text-avanzia-orange', fondo: 'bg-orange-50' },
    rojo: { texto: 'text-red-500', fondo: 'bg-red-50' },
    verde: { texto: 'text-green-600', fondo: 'bg-green-50' },
    celeste: { texto: 'text-sky-500', fondo: 'bg-sky-50' },
    ambar: { texto: 'text-amber-500', fondo: 'bg-amber-50' },
    morado: { texto: 'text-avanzia-purple', fondo: 'bg-purple-50' },
};

export const iconoConvenio = (clave: string): Component =>
    ICONOS_CONVENIO[clave] ?? Landmark;

export const colorConvenio = (clave: string) =>
    COLORES_CONVENIO[clave] ?? COLORES_CONVENIO.morado;

/** Nombre del país a partir del código ISO; sin código = internacional. */
const PAISES: Record<string, string> = {
    pe: 'Perú',
    bo: 'Bolivia',
    mx: 'México',
    co: 'Colombia',
    ec: 'Ecuador',
    cl: 'Chile',
    ar: 'Argentina',
    py: 'Paraguay',
};

export const nombrePais = (codigo: string | null): string =>
    codigo ? (PAISES[codigo] ?? codigo.toUpperCase()) : 'Internacional';
