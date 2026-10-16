<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    ArrowRight,
    BookOpen,
    ChevronRight,
    FileText,
    Globe,
    Link2,
    Mail,
    Phone,
    ShieldHalf,
} from '@lucide/vue';
import { computed } from 'vue';
import {
    EMAIL,
    PORTAL_URL,
    RUC,
    RUTAS_LEGALES,
    STUDIO_URL,
    TELEFONO,
} from '@/lib/public/contacto';
import { vReveal } from '@/lib/public/reveal';
import type { ConvenioLanding } from '@/types';

const props = defineProps<{
    convenios: ConvenioLanding[];
    // En la página de convenios se muestran enlaces rápidos en vez de repetir los aliados
    modo: 'respaldo' | 'enlaces';
}>();

// En el pie solo van los aliados con logo; el resto se ve en /convenios
const conLogo = computed(() => props.convenios.filter((c) => c.logo));
const enPagina = computed(
    () => props.convenios.filter((c) => c.mostrar_en_pagina).length,
);

const enlacesRapidos = [
    { texto: 'Avanzia STUDIO', href: STUDIO_URL, externo: true },
    { texto: 'Catálogo de Cursos', href: '/#cursos', externo: false },
    {
        texto: 'Validación de Certificados',
        href: RUTAS_LEGALES.validacion,
        externo: false,
    },
    { texto: 'Campus Virtual', href: PORTAL_URL, externo: true },
];

const telefonoHref = `tel:${TELEFONO.replace(/\s/g, '')}`;
</script>

<template>
    <section
        id="convenios"
        v-reveal
        class="relative overflow-hidden border-b border-white/5 bg-avanzia-navy pt-24 pb-20 text-white"
    >
        <div
            aria-hidden="true"
            class="pointer-events-none absolute top-0 right-0 size-96 rounded-full bg-avanzia-purple/10 blur-[120px]"
        />
        <div
            class="relative z-10 mx-auto grid max-w-7xl grid-cols-1 gap-12 px-6 lg:grid-cols-12 lg:gap-16"
        >
            <!-- Información institucional -->
            <div class="flex flex-col gap-6 lg:col-span-4">
                <img
                    src="/images/logo-avanzia.png"
                    alt="Logo Avanzia"
                    width="396"
                    height="178"
                    loading="lazy"
                    class="mb-2 h-10 w-fit object-contain brightness-0 invert"
                />
                <p class="max-w-sm text-[13px] leading-relaxed text-slate-300">
                    Capacitación online innovadora con certificaciones para
                    impulsar el desarrollo profesional DOCENTE en América
                    Latina. Potencia tu productividad con
                    <b>Avanzia STUDIO</b> y estudia a tu ritmo con
                    <b>Avanzia Flex</b>.
                </p>
                <div
                    class="mt-2 flex flex-col gap-3 text-[13px] text-slate-400"
                >
                    <a
                        :href="`mailto:${EMAIL}`"
                        class="flex items-center gap-3 transition-colors hover:text-avanzia-orange"
                    >
                        <Mail class="size-4 text-avanzia-orange" /> {{ EMAIL }}
                    </a>
                    <a
                        :href="telefonoHref"
                        class="flex items-center gap-3 transition-colors hover:text-avanzia-orange"
                    >
                        <Phone class="size-4 text-avanzia-orange" />
                        {{ TELEFONO }}
                    </a>
                    <a
                        href="/"
                        class="flex items-center gap-3 transition-colors hover:text-avanzia-orange"
                    >
                        <Globe class="size-4 text-avanzia-orange" /> avanzia.org
                    </a>
                    <span class="flex items-center gap-3 text-slate-500">
                        <FileText class="size-4" /> RUC: {{ RUC }}
                    </span>
                </div>
            </div>

            <!-- Respaldo institucional (o enlaces rápidos en /convenios) -->
            <div v-if="modo === 'respaldo'" class="flex flex-col lg:col-span-6">
                <h4
                    class="mb-6 flex items-center gap-2 text-xs font-semibold tracking-widest text-slate-400 uppercase"
                >
                    <ShieldHalf class="size-4 text-avanzia-purple" />
                    Respaldo Institucional
                </h4>

                <div
                    class="rounded-2xl border border-white/5 bg-white/5 p-8 backdrop-blur-sm"
                >
                    <div
                        class="flex flex-wrap items-center justify-center gap-x-14 gap-y-8"
                    >
                        <component
                            :is="convenio.url ? 'a' : 'div'"
                            v-for="convenio in conLogo"
                            :key="convenio.id"
                            :href="convenio.url ?? undefined"
                            :target="convenio.url ? '_blank' : undefined"
                            :rel="convenio.url ? 'noopener' : undefined"
                            class="opacity-80 transition-opacity hover:opacity-100"
                        >
                            <img
                                :src="convenio.logo!"
                                :alt="convenio.nombre"
                                loading="lazy"
                                class="h-24 w-auto max-w-[180px] object-contain"
                            />
                        </component>
                    </div>
                    <Link
                        v-if="enPagina > 0"
                        :href="RUTAS_LEGALES.convenios"
                        class="mt-8 flex items-center justify-center gap-2 text-sm font-semibold text-slate-300 transition-colors hover:text-avanzia-orange"
                    >
                        Ver los {{ enPagina }} convenios
                        <ArrowRight class="size-4" />
                    </Link>
                </div>
            </div>

            <div v-else class="flex flex-col lg:col-span-6">
                <h4
                    class="mb-6 flex items-center gap-2 text-xs font-semibold tracking-widest text-slate-400 uppercase"
                >
                    <Link2 class="size-4 text-avanzia-purple" />
                    Enlaces Rápidos
                </h4>
                <div class="flex flex-col gap-3 text-sm text-slate-300">
                    <component
                        :is="enlace.externo ? 'a' : Link"
                        v-for="enlace in enlacesRapidos"
                        :key="enlace.texto"
                        :href="enlace.href"
                        :target="enlace.externo ? '_blank' : undefined"
                        :rel="enlace.externo ? 'noopener' : undefined"
                        class="flex items-center gap-2 transition-colors hover:text-avanzia-orange"
                    >
                        <ChevronRight class="size-3 text-slate-500" />
                        {{ enlace.texto }}
                    </component>
                </div>
            </div>

            <!-- Transparencia -->
            <div
                class="flex flex-col items-start gap-6 text-left lg:col-span-2 lg:items-end lg:text-right"
            >
                <h4
                    class="text-xs font-semibold tracking-widest text-slate-400 uppercase"
                >
                    Transparencia
                </h4>
                <Link
                    :href="RUTAS_LEGALES.libroReclamaciones"
                    class="group relative flex aspect-square w-full max-w-[140px] flex-col items-center justify-center rounded-2xl border border-white/20 p-4 text-center transition-all hover:border-white/50"
                >
                    <BookOpen
                        class="mb-3 size-10 text-slate-400 transition-colors group-hover:text-white"
                    />
                    <span
                        class="text-[10px] leading-tight font-medium tracking-widest text-slate-300 uppercase transition-colors group-hover:text-white"
                        >Libro de<br />Reclamaciones</span
                    >
                </Link>
            </div>
        </div>
    </section>
</template>
