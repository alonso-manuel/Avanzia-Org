<script setup lang="ts">
import {
    ArrowUpCircle,
    BookOpen,
    Check,
    CheckCircle,
    CheckCircle2,
    ChevronsDown,
    Clock,
    MessageCircle,
    ShieldCheck,
    TriangleAlert,
} from '@lucide/vue';
import { computed } from 'vue';
import SeoHead from '@/components/public/SeoHead.vue';
import type { CampanaGracias, Seo } from '@/types';

const props = defineProps<{
    seo: Seo;
    campana: CampanaGracias;
}>();

// Colores de la campaña como variables CSS (las clases usan var(--campana) y var(--campana-acento))
const colores = computed(() => ({
    '--campana': props.campana.color,
    '--campana-acento': props.campana.color_acento,
}));
</script>

<!--
    Página de agradecimiento de campaña, sin layout (ver app.ts). Plantilla original: "Landing Gracias Avanzia Investigacion". Se muestra dentro del marco de landing.avanzia.org.
    Los textos y datos están en config/campanas.php; aquí solo el diseño (cambiarlo requiere npm run build y subir build/).
-->
<template>
    <SeoHead :seo="seo" />

    <div
        class="flex min-h-screen items-center justify-center bg-gray-100 bg-gradient-to-br from-[color-mix(in_srgb,var(--campana)_10%,transparent)] to-gray-200 px-4 py-10 font-landing text-gray-800 antialiased"
        :style="colores"
    >
        <main
            class="w-full max-w-3xl overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-xl"
        >
            <!-- Cabecera -->
            <div
                class="relative overflow-hidden bg-[var(--campana)] px-6 py-10 text-center"
            >
                <div class="textura absolute inset-0 opacity-10" />

                <div
                    class="relative z-10 mb-6 flex flex-wrap items-center justify-center gap-3"
                >
                    <span
                        class="flex items-center gap-1 rounded-full border border-green-500/30 bg-green-500/20 px-3 py-1 text-xs font-bold text-green-300"
                    >
                        <CheckCircle2 class="size-4" />
                        {{ campana.textos.progreso_hecho }}
                    </span>
                    <span
                        class="flex animate-pulse items-center gap-1 rounded-full border border-[color-mix(in_srgb,var(--campana-acento)_30%,transparent)] bg-[color-mix(in_srgb,var(--campana-acento)_20%,transparent)] px-3 py-1 text-xs font-bold text-[var(--campana-acento)]"
                    >
                        <Clock class="size-4" />
                        {{ campana.textos.progreso_pendiente }}
                    </span>
                </div>

                <h1
                    class="relative z-10 mb-3 text-3xl leading-tight font-extrabold text-white md:text-5xl"
                >
                    {{ campana.textos.titulo }}
                </h1>
                <p
                    class="relative z-10 mx-auto max-w-xl text-lg font-medium text-white/80"
                >
                    {{ campana.textos.inscripcion_antes }}
                    <strong>{{ campana.textos.inscripcion_resaltado }}</strong
                    >.
                </p>
            </div>

            <!-- Botón de WhatsApp -->
            <div
                class="border-b border-gray-200 bg-gray-50 p-6 md:px-10 md:pt-10 md:pb-6"
            >
                <p class="mb-6 text-center text-lg font-medium text-gray-700">
                    {{ campana.textos.mensaje_antes }}
                    <span class="font-bold text-gray-900">{{
                        campana.textos.mensaje_resaltado
                    }}</span>
                    {{ campana.textos.mensaje_despues }}
                </p>

                <div class="mb-2 flex flex-col items-center">
                    <ChevronsDown
                        class="flecha mb-3 size-8 text-[var(--campana-acento)]"
                    />

                    <a
                        :href="campana.grupo_whatsapp"
                        target="_blank"
                        rel="noopener"
                        class="latido group relative flex w-full max-w-xl flex-col items-center justify-center gap-1 overflow-hidden rounded-2xl bg-[#25D366] px-6 py-5 text-xl font-extrabold text-white shadow-[0_0_20px_rgba(37,211,102,0.4)] transition-all duration-300 hover:bg-[#128C7E] hover:shadow-[0_0_30px_rgba(37,211,102,0.6)] md:text-2xl"
                    >
                        <div
                            class="absolute inset-0 -translate-x-full -skew-x-12 transform bg-white/20 transition-transform duration-700 group-hover:translate-x-full"
                        />
                        <div class="flex items-center gap-3">
                            <MessageCircle class="size-8 shrink-0" />
                            {{ campana.textos.boton }}
                        </div>
                        <span class="text-sm font-normal opacity-90">{{
                            campana.textos.boton_ayuda
                        }}</span>
                    </a>
                </div>

                <p
                    class="mt-4 flex items-center justify-center gap-1 text-center text-xs font-medium text-gray-500"
                >
                    <ShieldCheck class="size-4 text-green-500" />
                    {{ campana.textos.nota_grupo }}
                </p>

                <!-- Advertencia -->
                <div
                    class="mx-auto mt-8 max-w-xl rounded-xl border border-red-200 bg-red-50 p-4 text-left shadow-sm"
                >
                    <div class="flex items-start gap-3">
                        <TriangleAlert
                            class="mt-0.5 size-6 shrink-0 text-red-500"
                        />
                        <div>
                            <h3 class="mb-1 text-sm font-bold text-red-800">
                                {{ campana.textos.advertencia_titulo }}
                            </h3>
                            <p class="text-xs leading-relaxed text-red-700">
                                {{ campana.textos.advertencia_antes }}
                                <strong>{{
                                    campana.textos.advertencia_resaltado
                                }}</strong>
                                {{ campana.textos.advertencia_despues }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Capacitador y temario -->
            <div class="p-6 md:p-10">
                <div
                    class="relative mb-10 flex flex-col items-center gap-6 overflow-hidden rounded-xl border border-gray-100 bg-white p-6 shadow-sm md:flex-row"
                >
                    <div
                        class="absolute top-0 right-0 rounded-bl-lg bg-[var(--campana-acento)] px-3 py-1 text-xs font-bold text-white shadow-sm"
                    >
                        {{ campana.textos.etiqueta_certificacion }}
                    </div>

                    <img
                        :src="campana.capacitador.foto"
                        :alt="campana.capacitador.nombre"
                        width="96"
                        height="96"
                        class="size-24 rounded-full border-4 border-gray-50 object-cover object-top shadow-md"
                    />
                    <div class="text-center md:text-left">
                        <p
                            class="mb-1 text-xs font-bold tracking-wider text-gray-500 uppercase"
                        >
                            {{ campana.textos.etiqueta_capacitador }}
                        </p>
                        <h2 class="mb-2 text-xl font-bold text-gray-900">
                            {{ campana.capacitador.nombre }}
                        </h2>
                        <span
                            class="inline-flex items-center gap-1 rounded-full border border-gray-200 bg-gray-50 px-3 py-1 text-xs font-semibold text-[var(--campana)]"
                        >
                            <CheckCircle
                                class="size-3 text-[var(--campana-acento)]"
                            />
                            {{ campana.capacitador.insignia }}
                        </span>
                    </div>
                </div>

                <h4
                    class="mb-6 flex items-center justify-center gap-2 text-center text-xl font-bold text-gray-900"
                >
                    <BookOpen class="size-6 text-[var(--campana-acento)]" />
                    {{ campana.textos.titulo_temario }}
                </h4>

                <div class="grid gap-6">
                    <div
                        v-for="(dia, i) in campana.temario"
                        :key="dia.titulo"
                        class="relative rounded-xl border border-gray-100 bg-gray-50 p-6"
                    >
                        <div
                            class="absolute top-0 bottom-0 left-0 w-1.5 rounded-l-xl bg-[var(--campana)]"
                        />
                        <div class="mb-4 flex items-center gap-3 pl-2">
                            <span
                                class="shrink-0 rounded bg-[var(--campana)] px-2.5 py-1 text-xs font-bold tracking-wide text-white uppercase"
                                >Día {{ i + 1 }}</span
                            >
                            <h5
                                class="text-lg leading-tight font-bold text-gray-900"
                            >
                                {{ dia.titulo }}
                            </h5>
                        </div>
                        <ul class="space-y-3 pl-2">
                            <li
                                v-for="tema in dia.temas"
                                :key="tema"
                                class="flex items-start gap-2"
                            >
                                <Check
                                    class="mt-0.5 size-4 shrink-0 text-[var(--campana-acento)]"
                                />
                                <span class="text-sm text-gray-600">{{
                                    tema
                                }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Como en la plantilla original, este enlace lleva directo al grupo -->
                <div class="mt-10 text-center">
                    <a
                        :href="campana.grupo_whatsapp"
                        target="_blank"
                        rel="noopener"
                        class="inline-flex items-center gap-2 font-bold text-[var(--campana)] transition-colors hover:text-[#25D366]"
                    >
                        <ArrowUpCircle class="size-5" />
                        {{ campana.textos.boton_final }}
                    </a>
                </div>
            </div>
        </main>
    </div>
</template>

<style scoped>
/* Ruta pública fija: la imagen vive en el docroot, no la procesa Vite */
.textura {
    background-image: url('/images/campanas/textura-cubos.png');
}

@keyframes latido {
    0%,
    100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.02);
    }
}

.latido {
    animation: latido 2s infinite;
}

@keyframes rebote {
    0%,
    100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(5px);
    }
}

.flecha {
    animation: rebote 1.5s infinite;
}
</style>
