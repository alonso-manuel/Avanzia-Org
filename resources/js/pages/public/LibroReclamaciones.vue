<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { BookOpen, ExternalLink } from '@lucide/vue';
import EncabezadoPagina from '@/components/public/EncabezadoPagina.vue';
import SeoHead from '@/components/public/SeoHead.vue';
import {
    DOMICILIO,
    EMAIL,
    RAZON_SOCIAL,
    RUC,
    RUTAS_LEGALES,
} from '@/lib/public/contacto';
import { vReveal } from '@/lib/public/reveal';
import type { Seo } from '@/types';

defineProps<{ seo: Seo }>();

// Formulario de Google Forms del sitio anterior; las respuestas llegan a la cuenta de Avanzia
const FORMULARIO_URL =
    'https://docs.google.com/forms/d/e/1FAIpQLSfZ8CrzCG37_FIRuZ8zDWkIG1X5qoldlQM_w53YebIyQlarhg/viewform';

const datos = [
    { etiqueta: 'Razón social', valor: RAZON_SOCIAL },
    { etiqueta: 'RUC', valor: RUC },
    { etiqueta: 'Domicilio fiscal', valor: DOMICILIO },
    { etiqueta: 'Correo', valor: EMAIL },
    { etiqueta: 'Sitio web', valor: 'avanzia.org' },
];
</script>

<template>
    <SeoHead :seo="seo" />

    <EncabezadoPagina
        antetitulo="Transparencia"
        titulo="Libro de Reclamaciones"
        bajada="Si no estás conforme con alguno de nuestros servicios, registra aquí tu queja o reclamo."
    />

    <section class="px-4 pb-24">
        <div class="mx-auto max-w-4xl space-y-8">
            <!-- Datos del proveedor -->
            <dl
                v-reveal
                class="grid gap-6 rounded-[2rem] border border-slate-100 bg-white p-8 shadow-sm sm:grid-cols-2 md:p-10"
            >
                <div v-for="dato in datos" :key="dato.etiqueta">
                    <dt
                        class="text-xs font-bold tracking-widest text-slate-400 uppercase"
                    >
                        {{ dato.etiqueta }}
                    </dt>
                    <dd class="mt-1 font-semibold text-avanzia-ink">
                        {{ dato.valor }}
                    </dd>
                </div>
            </dl>

            <!-- Formulario -->
            <div
                v-reveal
                class="overflow-hidden rounded-[2rem] border border-slate-100 bg-white shadow-xl"
            >
                <div
                    class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 bg-slate-50 px-6 py-4 md:px-8"
                >
                    <h2
                        class="flex items-center gap-3 font-titular text-xl font-semibold text-avanzia-ink"
                    >
                        <BookOpen class="size-6 text-avanzia-orange" />
                        Formulario de Reclamaciones
                    </h2>
                    <a
                        :href="FORMULARIO_URL"
                        target="_blank"
                        rel="noopener"
                        class="inline-flex items-center gap-1.5 text-sm font-semibold text-avanzia-ochre hover:underline"
                    >
                        Abrir en una pestaña nueva
                        <ExternalLink class="size-4" />
                    </a>
                </div>
                <iframe
                    :src="`${FORMULARIO_URL}?embedded=true`"
                    title="Formulario del Libro de Reclamaciones"
                    loading="lazy"
                    class="block h-[1700px] w-full border-0 sm:h-[1543px]"
                >
                    Cargando…
                </iframe>
            </div>

            <p class="text-center text-sm text-slate-500">
                Consulta también nuestros
                <Link
                    :href="RUTAS_LEGALES.terminos"
                    class="font-semibold text-avanzia-ochre underline underline-offset-2"
                    >Términos y Condiciones</Link
                >.
            </p>
        </div>
    </section>
</template>
