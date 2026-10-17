<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { ArrowRight, Earth, HeartHandshake } from '@lucide/vue';
import { computed, onMounted, ref } from 'vue';
import SeoHead from '@/components/public/SeoHead.vue';
import SolicitudConvenioModal from '@/components/public/SolicitudConvenioModal.vue';
import {
    colorConvenio,
    iconoConvenio,
    nombrePais,
} from '@/lib/public/convenios';
import { vReveal } from '@/lib/public/reveal';
import type { ConvenioLanding, OpcionesSolicitud, Seo } from '@/types';

defineProps<{
    seo: Seo;
    opciones: OpcionesSolicitud;
}>();

// Los convenios llegan como prop compartida (middleware CompartirDatosPublicos)
const page = usePage();
const convenios = computed(() =>
    ((page.props.convenios as ConvenioLanding[] | undefined) ?? []).filter(
        (c) => c.mostrar_en_pagina,
    ),
);

const solicitando = ref(false);

// /convenios?solicitar=1 (botón de alianza de la portada) abre el formulario directamente
onMounted(() => {
    if (
        new URL(page.url, window.location.origin).searchParams.has('solicitar')
    ) {
        solicitando.value = true;
    }
});
</script>

<template>
    <SeoHead :seo="seo" />

    <!-- Presentación -->
    <section
        class="relative flex items-center overflow-hidden px-4 pt-40 pb-16"
    >
        <div v-reveal class="mx-auto w-full max-w-7xl text-center">
            <div
                class="mb-6 inline-block rounded-full bg-avanzia-purple/10 px-4 py-1.5 text-xs font-black tracking-widest text-avanzia-purple uppercase"
            >
                Red Global
            </div>
            <h1
                class="mb-6 font-titular text-4xl leading-[1.1] font-black tracking-tight text-slate-900 md:text-5xl lg:text-6xl"
            >
                Respaldo Institucional.
            </h1>
            <p
                class="mx-auto max-w-3xl text-xl leading-relaxed font-medium text-slate-600"
            >
                Trabajamos de la mano con las instituciones educativas y
                organizaciones magisteriales más prestigiosas de América Latina
                para garantizar la excelencia y la certificación oficial de
                nuestras capacitaciones.
            </p>
        </div>
    </section>

    <!-- Convenios -->
    <section class="relative z-10 px-4 py-12">
        <div
            v-reveal
            class="mx-auto grid max-w-7xl grid-cols-[repeat(auto-fit,minmax(260px,300px))] justify-center gap-6"
        >
            <article
                v-for="(convenio, i) in convenios"
                :key="convenio.id"
                class="group flex animate-fade-in flex-col rounded-3xl border border-slate-100 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1.5 hover:shadow-[0_20px_40px_rgba(0,0,0,0.06)]"
                :style="{ animationDelay: `${i * 0.05}s` }"
            >
                <div
                    class="relative mb-6 flex h-28 w-full items-center justify-center overflow-hidden rounded-2xl border border-slate-50 transition-colors group-hover:border-slate-100"
                    :class="
                        convenio.logo
                            ? 'bg-avanzia-navy'
                            : [
                                  colorConvenio(convenio.color).fondo,
                                  'group-hover:bg-white',
                              ]
                    "
                >
                    <!-- Los logos son blancos/para fondo oscuro: su fondo no cambia al pasar el mouse -->
                    <img
                        v-if="convenio.logo"
                        :src="convenio.logo"
                        :alt="convenio.nombre"
                        loading="lazy"
                        class="h-20 w-auto max-w-[80%] object-contain transition-transform duration-500 group-hover:scale-105"
                    />
                    <component
                        :is="iconoConvenio(convenio.icono)"
                        v-else
                        aria-hidden="true"
                        class="size-10 transition-transform duration-500 group-hover:scale-110"
                        :class="colorConvenio(convenio.color).texto"
                    />
                </div>

                <div class="flex flex-grow flex-col">
                    <span
                        v-if="convenio.tipo"
                        class="mb-2 text-[10px] font-black tracking-widest text-slate-400 uppercase"
                        >{{ convenio.tipo }}</span
                    >
                    <h3
                        class="mb-4 text-lg leading-tight font-bold text-slate-800 transition-colors group-hover:text-avanzia-orange"
                    >
                        {{ convenio.nombre }}
                    </h3>

                    <div
                        class="mt-auto flex items-center gap-2.5 border-t border-slate-50 pt-4"
                    >
                        <img
                            v-if="convenio.pais"
                            :src="`https://flagcdn.com/w40/${convenio.pais}.png`"
                            :alt="`Bandera de ${nombrePais(convenio.pais)}`"
                            width="24"
                            height="16"
                            loading="lazy"
                            class="h-4 w-6 shrink-0 rounded-sm object-cover shadow-sm"
                        />
                        <Earth
                            v-else
                            aria-hidden="true"
                            class="size-4 shrink-0 text-sky-500"
                        />
                        <span
                            class="text-xs font-semibold tracking-wide text-slate-500"
                            >{{ nombrePais(convenio.pais) }}</span
                        >
                    </div>
                </div>
            </article>
        </div>
    </section>

    <!-- Llamado a la acción -->
    <section class="relative z-10 px-4 py-20">
        <div
            v-reveal
            class="relative mx-auto max-w-4xl overflow-hidden rounded-[2.5rem] border border-white bg-gradient-to-br from-white/90 to-white/60 p-10 text-center shadow-2xl backdrop-blur-md md:p-16"
        >
            <div
                aria-hidden="true"
                class="absolute top-0 right-0 size-64 translate-x-1/2 -translate-y-1/2 rounded-full bg-avanzia-orange/10 blur-3xl"
            />
            <div
                aria-hidden="true"
                class="absolute bottom-0 left-0 size-64 -translate-x-1/2 translate-y-1/2 rounded-full bg-avanzia-purple/10 blur-3xl"
            />

            <div class="relative z-10">
                <div
                    class="mx-auto mb-6 flex size-16 rotate-3 items-center justify-center rounded-2xl bg-white text-avanzia-orange shadow-md"
                >
                    <HeartHandshake class="size-8" />
                </div>
                <h2
                    class="mb-4 font-titular text-3xl font-black tracking-tight text-slate-900 md:text-4xl"
                >
                    ¿Representas a una institución?
                </h2>
                <p class="mx-auto mb-8 max-w-2xl text-lg text-slate-600">
                    Únete a nuestra red de aliados estratégicos. Juntos podemos
                    transformar la educación y empoderar a la plana docente de
                    tu región con herramientas de vanguardia.
                </p>
                <button
                    type="button"
                    class="inline-flex items-center gap-3 rounded-full bg-avanzia-navy px-10 py-4 text-lg font-bold text-white shadow-xl transition-all hover:-translate-y-1 hover:bg-slate-800"
                    @click="solicitando = true"
                >
                    Establecer Alianza <ArrowRight class="size-4" />
                </button>
            </div>
        </div>
    </section>

    <SolicitudConvenioModal
        :abierto="solicitando"
        :opciones="opciones"
        @cerrar="solicitando = false"
    />
</template>
