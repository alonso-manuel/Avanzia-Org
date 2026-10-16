/** Props de la portada pública (App\Http\Controllers\Public\InicioController). */
export type CursoLanding = {
    id: number;
    titulo: string;
    categoria: string;
    categoriaNombre: string;
    descripcion: string;
    horas: number | null;
    /** Texto cuando la duración no va en horas ("3 días"). */
    duracion: string | null;
    gratuito: boolean;
    imagen: string | null;
    color: string;
    temarioImagen: string | null;
    /** Alumnos de ciclos anteriores + visitantes distintos que vieron el temario o agregaron el curso al carrito. */
    interesados: number;
};

export type CategoriaLanding = {
    id: string;
    nombre: string;
};

export type OpinionLanding = {
    id: number;
    nombre: string;
    pais: string;
    ciudad: string;
    institucion: string | null;
    curso: string;
    estrellas: number;
    comentario: string;
};

export type EstadisticasOpiniones = {
    resenas: number;
    promedio: number;
};

export type ConvenioLanding = {
    id: number;
    nombre: string;
    tipo: string | null;
    /** Código ISO del país; null = internacional. */
    pais: string | null;
    color: string;
    /** false = solo como logo en el pie, no en la página de convenios. */
    mostrar_en_pagina: boolean;
    logo: string | null;
    icono: string;
    url: string | null;
};

/** Opciones del formulario de solicitud de convenio (App\Support\OpcionesConvenio). */
export type OpcionesSolicitud = {
    tiposInstitucion: Record<string, string>;
    intereses: Record<string, string>;
    paises: string[];
};

/** Página de resultados de Laravel (LengthAwarePaginator serializado). */
export type Paginado<T> = {
    data: T[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    from: number | null;
    to: number | null;
    path: string;
};
