import { computed, reactive, readonly, watch } from 'vue';
import { whatsapp } from '@/lib/public/contacto';
import type { CursoLanding } from '@/types';

/**
 * Carrito de cursos de la zona pública.
 * Aún no hay pasarela de pago: el pedido se envía como mensaje de WhatsApp.
 * Vive en el navegador del visitante (localStorage), así que se mantiene al navegar y al recargar.
 */

export type ItemCarrito = {
    id: number;
    titulo: string;
    categoria: string;
    horas: number | null;
    // Opcionales: los carritos guardados antes de existir estos campos no los traen
    duracion?: string | null;
    gratuito?: boolean;
    imagen: string | null;
};

const CLAVE = 'avanzia:carrito';

const estado = reactive({
    items: [] as ItemCarrito[],
    abierto: false,
});

let iniciado = false;

function esItemValido(item: unknown): item is ItemCarrito {
    const i = item as Partial<ItemCarrito> | null;

    return (
        typeof i?.id === 'number' &&
        typeof i.titulo === 'string' &&
        typeof i.categoria === 'string'
    );
}

/**
 * Recupera el carrito guardado y empieza a guardarlo en cada cambio.
 * Se llama desde PublicLayout en onMounted (solo navegador; compatible con SSR).
 */
export function iniciarCarrito(): void {
    if (iniciado) {
        return;
    }

    iniciado = true;

    try {
        const guardado: unknown = JSON.parse(
            localStorage.getItem(CLAVE) ?? '[]',
        );

        if (Array.isArray(guardado)) {
            estado.items = guardado.filter(esItemValido);
        }
    } catch {
        // Navegación privada o datos corruptos: se empieza con el carrito vacío
    }

    watch(
        () => estado.items,
        (items) => {
            try {
                localStorage.setItem(CLAVE, JSON.stringify(items));
            } catch {
                // Sin almacenamiento disponible: el carrito dura hasta recargar
            }
        },
        { deep: true },
    );
}

function contiene(id: number): boolean {
    return estado.items.some((item) => item.id === id);
}

function agregar(curso: CursoLanding): void {
    if (!contiene(curso.id)) {
        estado.items.push({
            id: curso.id,
            titulo: curso.titulo,
            categoria: curso.categoriaNombre,
            horas: curso.horas,
            duracion: curso.duracion,
            gratuito: curso.gratuito,
            imagen: curso.imagen,
        });
    }

    estado.abierto = true;
}

function quitar(id: number): void {
    estado.items = estado.items.filter((item) => item.id !== id);
}

function vaciar(): void {
    estado.items = [];
}

/** Mensaje de WhatsApp con la lista de cursos elegidos. */
function enlacePedido(): string {
    const lista = estado.items
        .map(
            (item, i) =>
                `${i + 1}. ${item.titulo}${item.gratuito ? ' (gratuito)' : ''}`,
        )
        .join('\n');

    // Si todo es gratuito no tiene sentido preguntar por precio ni pago
    const pregunta = estado.items.every((item) => item.gratuito)
        ? '¿Me ayudan con las fechas y la inscripción?'
        : '¿Me ayudan con las fechas, el precio y la forma de pago?';

    return whatsapp(
        `Hola, quiero inscribirme en ${estado.items.length === 1 ? 'este curso' : 'estos cursos'}:\n\n${lista}\n\n${pregunta}`,
    );
}

export function useCarrito() {
    return {
        items: computed(() => readonly(estado.items)),
        cantidad: computed(() => estado.items.length),
        abierto: computed({
            get: () => estado.abierto,
            set: (valor: boolean) => {
                estado.abierto = valor;
            },
        }),
        contiene,
        agregar,
        quitar,
        vaciar,
        enlacePedido,
    };
}
