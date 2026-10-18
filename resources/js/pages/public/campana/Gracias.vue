<script setup lang="ts">
import {
    ArrowUp,
    Award,
    BookOpen,
    Check,
    ChevronsDown,
    CircleCheck,
    Lock,
    MessageCircle,
    OctagonAlert,
} from '@lucide/vue';
import { computed } from 'vue';
import SeoHead from '@/components/public/SeoHead.vue';
import type { CampanaGracias, Seo } from '@/types';

const props = defineProps<{
    seo: Seo;
    campana: CampanaGracias;
}>();

// Colores de la campaña como variables CSS (las clases usan var(--campana) y var(--campana-oscuro))
const colores = computed(() => ({
    '--campana': props.campana.color,
    '--campana-oscuro': props.campana.color_oscuro,
}));

// Color de la etiqueta y los íconos de cada día, como en la plantilla original
const ESTILO_DIA = [
    { etiqueta: 'bg-[var(--campana)]', icono: 'text-[var(--campana)]' },
    { etiqueta: 'bg-slate-800', icono: 'text-slate-800' },
    { etiqueta: 'bg-[#dca843]', icono: 'text-[#dca843]' },
];

const estiloDia = (i: number) => ESTILO_DIA[i % ESTILO_DIA.length];

function irArriba() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
</script>

<!--
    Página de agradecimiento de campaña, sin layout (ver app.ts). Los textos y datos están en config/campanas.php;
    aquí solo el diseño (cambiarlo requiere compilar con npm run build y subir build/). Plantilla original: page-gracias-ingenieria.php.
    Se muestra dentro del marco de landing.avanzia.org (redirección enmascarada de Spaceship).
-->
<template>
    <SeoHead :seo="seo" />

    <div
        class="flex min-h-screen items-center justify-center bg-gray-100 bg-gradient-to-br from-[color-mix(in_srgb,var(--campana)_20%,transparent)] to-gray-200 px-4 py-6 font-landing text-gray-800 antialiased"
        :style="colores"
    >
        <main
            class="w-full max-w-3xl overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-2xl"
        >
            <!-- Atención inmediata: el botón para unirse al grupo -->
            <div
                class="relative overflow-hidden bg-gradient-to-b from-[var(--campana)] to-[var(--campana-oscuro)] px-6 pt-10 pb-12 text-center"
            >
                <div class="relative z-10 flex flex-col items-center">
                    <!-- Progreso: registro hecho, falta el paso final -->
                    <div class="mb-6 flex items-center gap-2">
                        <span
                            class="flex items-center gap-1 rounded-full bg-green-500 px-3 py-1 text-xs font-bold text-white shadow-sm"
                        >
                            <Check class="size-3" />
                            {{ campana.textos.progreso_hecho }}
                        </span>
                        <div class="h-0.5 w-8 bg-white/40" />
                        <span
                            class="animate-pulse rounded-full bg-white px-3 py-1 text-xs font-bold text-[var(--campana)] shadow-sm"
                        >
                            {{ campana.textos.progreso_pendiente }}
                        </span>
                    </div>

                    <h1
                        class="mb-4 text-3xl leading-tight font-black tracking-tight text-white drop-shadow-md md:text-5xl"
                    >
                        {{ campana.textos.titulo }}
                    </h1>
                    <p
                        class="mb-8 max-w-lg text-lg font-medium text-white/95 md:text-xl"
                    >
                        {{ campana.textos.mensaje_antes }}
                        <span
                            class="rounded bg-yellow-400 px-2 py-0.5 font-bold text-black"
                            >{{ campana.textos.mensaje_resaltado }}</span
                        >
                        {{ campana.textos.mensaje_despues }}
                    </p>

                    <div class="flecha mb-3 text-yellow-300">
                        <ChevronsDown class="size-12 drop-shadow-md" />
                    </div>

                    <div class="mx-auto w-full max-w-sm">
                        <a
                            :href="campana.grupo_whatsapp"
                            target="_blank"
                            rel="noopener"
                            class="latido flex w-full flex-col items-center justify-center gap-1 rounded-2xl border-b-4 border-green-800 bg-[#25D366] px-6 py-6 text-2xl font-black text-white shadow-[0_10px_20px_rgba(37,211,102,0.3)] transition-all duration-300 hover:bg-[#128C7E] hover:shadow-[0_15px_30px_rgba(37,211,102,0.4)]"
                        >
                            <span class="flex items-center gap-3">
                                <MessageCircle class="size-8" />
                                {{ campana.textos.boton }}
                            </span>
                            <span
                                class="mt-1 text-xs font-medium tracking-widest uppercase opacity-90"
                                >{{ campana.textos.boton_ayuda }}</span
                            >
                        </a>
                    </div>
                </div>
            </div>

            <!-- Advertencia, justo debajo del botón -->
            <div
                class="border-y border-red-200 bg-red-50 p-5 text-center md:p-6"
            >
                <div
                    class="flex flex-col items-center justify-center gap-3 md:flex-row"
                >
                    <OctagonAlert class="size-8 flex-shrink-0 text-red-500" />
                    <p
                        class="text-sm leading-tight font-medium text-red-700 md:text-base"
                    >
                        <strong>{{ campana.textos.advertencia_titulo }}</strong>
                        {{ campana.textos.advertencia_antes }}
                        <strong class="underline">{{
                            campana.textos.advertencia_resaltado
                        }}</strong>
                        {{ campana.textos.advertencia_despues }}
                    </p>
                </div>
                <p
                    class="mt-4 flex items-center justify-center gap-1 text-xs font-medium text-gray-500"
                >
                    <Lock class="size-3" />
                    {{ campana.textos.nota_grupo }}
                </p>
            </div>

            <!-- Resumen de la inscripción -->
            <div class="bg-white p-6 md:p-10">
                <div class="mb-8 text-center">
                    <h3 class="text-xl font-bold text-slate-800">
                        {{ campana.textos.resumen }}
                    </h3>
                    <div
                        class="mx-auto mt-3 h-1 w-16 rounded-full bg-[var(--campana)]"
                    />
                </div>

                <!-- Capacitador -->
                <div
                    class="mb-10 flex flex-col items-center gap-6 rounded-xl border border-rose-100 bg-rose-50 p-6 shadow-sm md:flex-row"
                >
                    <div class="relative shrink-0">
                        <img
                            :src="campana.capacitador.foto"
                            :alt="campana.capacitador.nombre"
                            width="96"
                            height="96"
                            class="size-24 rounded-full border-4 border-white object-cover object-top shadow-md"
                        />
                        <div
                            class="absolute -right-2 -bottom-2 flex size-8 items-center justify-center rounded-full border border-gray-100 bg-white p-1.5 shadow-md"
                        >
                            <!-- "G" de Google -->
                            <svg
                                viewBox="0 0 48 48"
                                class="size-5"
                                aria-hidden="true"
                            >
                                <path
                                    fill="#FFC107"
                                    d="M43.6 20.5H42V20H24v8h11.3C33.7 32.7 29.2 36 24 36c-6.6 0-12-5.4-12-12s5.4-12 12-12c3.1 0 5.8 1.2 7.9 3.1l5.7-5.7C34 6.1 29.3 4 24 4 13 4 4 13 4 24s9 20 20 20 20-9 20-20c0-1.3-.1-2.6-.4-3.5z"
                                />
                                <path
                                    fill="#FF3D00"
                                    d="m6.3 14.7 6.6 4.8C14.7 15.1 19 12 24 12c3.1 0 5.8 1.2 7.9 3.1l5.7-5.7C34 6.1 29.3 4 24 4 16.3 4 9.7 8.3 6.3 14.7z"
                                />
                                <path
                                    fill="#4CAF50"
                                    d="M24 44c5.2 0 9.9-2 13.4-5.2l-6.2-5.2C29.2 35.1 26.7 36 24 36c-5.2 0-9.6-3.3-11.3-8l-6.5 5C9.5 39.6 16.2 44 24 44z"
                                />
                                <path
                                    fill="#1976D2"
                                    d="M43.6 20.5H42V20H24v8h11.3c-.8 2.2-2.2 4.2-4.1 5.6l6.2 5.2C37 39.2 44 34 44 24c0-1.3-.1-2.6-.4-3.5z"
                                />
                            </svg>
                        </div>
                    </div>
                    <div class="text-center md:text-left">
                        <p
                            class="mb-1 text-xs font-bold tracking-wider text-[var(--campana)] uppercase"
                        >
                            {{ campana.textos.etiqueta_capacitador }}
                        </p>
                        <h2 class="mb-2 text-2xl font-bold text-slate-800">
                            {{ campana.capacitador.nombre }}
                        </h2>
                        <span
                            class="inline-flex items-center gap-1.5 rounded-full border border-blue-200 bg-blue-50 px-4 py-1.5 text-xs font-bold text-blue-700 shadow-sm"
                        >
                            <Award class="size-4" />
                            {{ campana.capacitador.insignia }}
                        </span>
                    </div>
                </div>

                <h4
                    class="mb-6 flex items-center gap-2 text-lg font-bold text-gray-800"
                >
                    <BookOpen class="size-5 text-[var(--campana)]" />
                    {{ campana.textos.titulo_temario }}
                </h4>

                <div class="space-y-4">
                    <div
                        v-for="(dia, i) in campana.temario"
                        :key="dia.titulo"
                        class="rounded-xl border border-gray-100 bg-gray-50 p-5 transition-colors hover:border-[color-mix(in_srgb,var(--campana)_30%,transparent)]"
                    >
                        <div class="mb-3 flex items-center gap-3">
                            <span
                                class="shrink-0 rounded px-2.5 py-1 text-xs font-bold text-white"
                                :class="estiloDia(i).etiqueta"
                                >DÍA {{ i + 1 }}</span
                            >
                            <h5
                                class="text-lg leading-tight font-bold text-slate-800"
                            >
                                {{ dia.titulo }}<br />{{ dia.subtitulo }}
                            </h5>
                        </div>
                        <ul class="space-y-2 pl-1 text-sm text-gray-600">
                            <li
                                v-for="tema in dia.temas"
                                :key="tema"
                                class="flex items-start gap-2"
                            >
                                <CircleCheck
                                    class="mt-0.5 size-4 flex-shrink-0"
                                    :class="estiloDia(i).icono"
                                />
                                {{ tema }}
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Llamado secundario por si bajan hasta el final -->
                <div class="mt-10 border-t border-gray-200 pt-8 text-center">
                    <p class="mb-4 text-sm font-medium text-gray-500">
                        {{ campana.textos.pregunta_final }}
                    </p>
                    <button
                        type="button"
                        class="inline-flex items-center justify-center gap-2 rounded-full bg-gray-900 px-8 py-3 font-bold text-white shadow-md transition-colors hover:bg-black"
                        @click="irArriba"
                    >
                        <ArrowUp class="size-4" />
                        {{ campana.textos.boton_final }}
                    </button>
                </div>
            </div>
        </main>
    </div>
</template>

<style scoped>
/* Latido intenso del botón, como en la plantilla original */
@keyframes latido {
    0%,
    28%,
    70%,
    100% {
        transform: scale(1);
    }
    14%,
    42% {
        transform: scale(1.05);
        box-shadow: 0 10px 25px rgba(37, 211, 102, 0.5);
    }
}

.latido {
    animation: latido 2.5s infinite;
}

/* Flecha que apunta al botón */
@keyframes rebote {
    0%,
    100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(10px);
    }
}

.flecha {
    animation: rebote 1.5s infinite;
}
</style>
