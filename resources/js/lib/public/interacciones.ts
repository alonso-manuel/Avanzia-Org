import { store } from '@/actions/App/Http/Controllers/Public/InteraccionController';

export type TipoInteraccion = 'temario' | 'carrito';

/** Token CSRF que Laravel deja en la cookie XSRF-TOKEN (la que usa también Inertia). */
function tokenCsrf(): string {
    const cookie = document.cookie
        .split('; ')
        .find((c) => c.startsWith('XSRF-TOKEN='));

    return cookie ? decodeURIComponent(cookie.split('=')[1]) : '';
}

/**
 * Avisa al servidor que el visitante vio el temario o agregó el curso al carrito.
 * El servidor cuenta una sola vez por visitante, curso y tipo, y devuelve los interesados actualizados.
 * Si falla, no se interrumpe nada: el contador es secundario.
 */
export async function registrarInteraccion(
    cursoId: number,
    tipo: TipoInteraccion,
): Promise<number | null> {
    try {
        const respuesta = await fetch(store.url(cursoId), {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
                'X-XSRF-TOKEN': tokenCsrf(),
            },
            body: JSON.stringify({ tipo }),
        });

        if (!respuesta.ok) {
            return null;
        }

        const datos = (await respuesta.json()) as { interesados?: unknown };

        return typeof datos.interesados === 'number' ? datos.interesados : null;
    } catch {
        return null;
    }
}
