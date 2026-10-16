import type { Directive } from 'vue';

const observados = new WeakMap<HTMLElement, IntersectionObserver>();

/**
 * Hace aparecer el elemento al entrar en pantalla (clases .reveal/.active de app.css).
 * Solo actúa en el navegador (hook mounted), así que es compatible con SSR.
 */
export const vReveal: Directive<HTMLElement> = {
    mounted(el) {
        el.classList.add('reveal');

        if (!('IntersectionObserver' in window)) {
            el.classList.add('active');

            return;
        }

        const observer = new IntersectionObserver(
            (entries) => {
                if (entries.some((entry) => entry.isIntersecting)) {
                    el.classList.add('active');
                    observer.disconnect();
                }
            },
            { threshold: 0.1 },
        );

        observer.observe(el);
        observados.set(el, observer);
    },
    unmounted(el) {
        observados.get(el)?.disconnect();
        observados.delete(el);
    },
};
