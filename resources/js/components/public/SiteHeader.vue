<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { Menu, X } from '@lucide/vue';
import { ref } from 'vue';
import { PORTAL_URL, RUTAS_LEGALES, STUDIO_URL } from '@/lib/public/contacto';

type Enlace = {
    texto: string;
    href: string;
    // pagina: navegación de Inertia (sin recargar); ancla: sección de la portada; externo: otra web
    tipo: 'pagina' | 'ancla' | 'externo';
};

const menuAbierto = ref(false);
const page = usePage();

const enlaces: Enlace[] = [
    { texto: 'Inicio', href: '/#inicio', tipo: 'ancla' },
    { texto: 'Portal Educativo', href: PORTAL_URL, tipo: 'externo' },
    {
        texto: 'Quienes Somos',
        href: RUTAS_LEGALES.quienesSomos,
        tipo: 'pagina',
    },
    { texto: 'Cursos', href: '/#cursos', tipo: 'ancla' },
    { texto: 'Convenios', href: RUTAS_LEGALES.convenios, tipo: 'pagina' },
    { texto: 'Validación', href: RUTAS_LEGALES.validacion, tipo: 'pagina' },
];

const esActivo = (enlace: Enlace) =>
    enlace.tipo === 'pagina' && page.url.split(/[?#]/)[0] === enlace.href;

const atributos = (enlace: Enlace) =>
    enlace.tipo === 'externo' ? { target: '_blank', rel: 'noopener' } : {};
</script>

<template>
    <div class="fixed top-4 z-50 flex w-full justify-center px-4">
        <header
            class="flex w-full max-w-7xl items-center justify-between rounded-full border border-white/50 bg-white/90 px-6 py-3 shadow-[0_8px_30px_rgb(0,0,0,0.08)] backdrop-blur-md transition-all duration-300"
        >
            <a href="/#inicio" class="flex shrink-0 items-center gap-3">
                <img
                    src="/images/logo-avanzia.png"
                    alt="Logo Avanzia"
                    width="396"
                    height="178"
                    class="h-10 w-auto object-contain md:h-12"
                />
            </a>

            <nav
                class="hidden items-center gap-8 text-sm font-bold text-slate-600 lg:flex"
            >
                <component
                    :is="enlace.tipo === 'pagina' ? Link : 'a'"
                    v-for="enlace in enlaces"
                    :key="enlace.texto"
                    :href="enlace.href"
                    v-bind="atributos(enlace)"
                    class="transition-colors hover:text-avanzia-orange"
                    :class="{ 'text-avanzia-orange': esActivo(enlace) }"
                    :aria-current="esActivo(enlace) ? 'page' : undefined"
                >
                    {{ enlace.texto }}
                </component>
            </nav>

            <a
                :href="STUDIO_URL"
                target="_blank"
                rel="noopener"
                class="hidden animate-heartbeat rounded-full bg-avanzia-orange px-8 py-2.5 font-bold text-white shadow-lg shadow-avanzia-orange/30 transition-colors hover:scale-105 hover:bg-avanzia-orange-dark lg:inline-block"
            >
                Pruébalo gratis
            </a>

            <button
                type="button"
                class="text-avanzia-black transition-colors hover:text-avanzia-orange focus:outline-none lg:hidden"
                aria-label="Abrir menú"
                :aria-expanded="menuAbierto"
                @click="menuAbierto = true"
            >
                <Menu class="size-7" />
            </button>
        </header>
    </div>

    <div
        v-if="menuAbierto"
        class="fixed inset-0 z-[60] flex flex-col items-center justify-center gap-8 bg-white/95 text-xl font-black text-slate-800 backdrop-blur-xl"
    >
        <button
            type="button"
            class="absolute top-8 right-8 text-slate-400 transition-colors hover:text-avanzia-orange"
            aria-label="Cerrar menú"
            @click="menuAbierto = false"
        >
            <X class="size-9" />
        </button>
        <component
            :is="enlace.tipo === 'pagina' ? Link : 'a'"
            v-for="enlace in enlaces"
            :key="enlace.texto"
            :href="enlace.href"
            v-bind="atributos(enlace)"
            class="transition-colors hover:text-avanzia-orange"
            :class="{ 'text-avanzia-orange': esActivo(enlace) }"
            :aria-current="esActivo(enlace) ? 'page' : undefined"
            @click="menuAbierto = false"
        >
            {{ enlace.texto }}
        </component>
        <a
            :href="STUDIO_URL"
            target="_blank"
            rel="noopener"
            class="mt-4 animate-heartbeat rounded-full bg-avanzia-orange px-10 py-4 text-lg font-bold text-white shadow-xl"
            @click="menuAbierto = false"
        >
            Pruébalo gratis
        </a>
    </div>
</template>
