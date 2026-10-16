<script setup lang="ts">
import { BadgeCheck, ShieldCheck } from '@lucide/vue';
import EncabezadoPagina from '@/components/public/EncabezadoPagina.vue';
import SeoHead from '@/components/public/SeoHead.vue';
import { RUC } from '@/lib/public/contacto';
import { vReveal } from '@/lib/public/reveal';
import type { Seo } from '@/types';

defineProps<{ seo: Seo }>();

// Validador de certificados: aplicación de Google Apps Script en la cuenta de Avanzia (no vive en este proyecto)
const VALIDADOR_URL =
    'https://script.google.com/a/macros/avanzia.org/s/AKfycbyRpYCig5kvAcvvMS2NtcGpAZ21U8VAgc9H9qmhEHQKnpSR2OlCTBwOouzepvAgMhoW/exec?page=validador';

const paises = [
    { nombre: 'Perú', archivo: 'peru' },
    { nombre: 'Bolivia', archivo: 'bolivia' },
    { nombre: 'Chile', archivo: 'chile' },
    { nombre: 'Ecuador', archivo: 'ecuador' },
    { nombre: 'México', archivo: 'mexico' },
    { nombre: 'Paraguay', archivo: 'paraguay' },
    { nombre: 'Colombia', archivo: 'colombia' },
    { nombre: 'Panamá', archivo: 'panama' },
    { nombre: 'Argentina', archivo: 'argentina' },
];
</script>

<template>
    <SeoHead :seo="seo" />

    <EncabezadoPagina
        antetitulo="Certificados Avanzia"
        titulo="Validación legal y transparencia del documento certificatorio"
    />

    <section class="px-4 pb-24">
        <div class="mx-auto max-w-5xl space-y-12">
            <!-- Validador -->
            <div
                v-reveal
                class="overflow-hidden rounded-[2rem] border border-slate-100 bg-white shadow-xl"
            >
                <div
                    class="flex items-center gap-3 border-b border-slate-100 bg-slate-50 px-6 py-4 md:px-8"
                >
                    <BadgeCheck class="size-6 shrink-0 text-avanzia-orange" />
                    <h2
                        class="font-titular text-xl font-semibold text-avanzia-ink"
                    >
                        Valida tu certificado
                    </h2>
                </div>
                <iframe
                    :src="VALIDADOR_URL"
                    title="Validador de certificados Avanzia"
                    loading="lazy"
                    class="block h-[720px] w-full border-0 bg-transparent sm:h-[600px]"
                />
            </div>

            <!-- Respaldo legal -->
            <div
                v-reveal
                class="rounded-[2rem] border border-slate-100 bg-white p-8 text-[17px] leading-[1.75] text-slate-600 shadow-sm md:p-12"
            >
                <p>
                    El individuo que posee este certificado ha culminado de
                    manera satisfactoria y aprobado con éxito la formación
                    docente especificada en el presente documento. La
                    institución Avanzia América Latina certifica, valida y
                    respalda la autenticidad de este reconocimiento,
                    garantizando su legalidad y conformidad con la normativa
                    vigente en los países que se nombran a continuación.
                </p>

                <p
                    class="mt-8 text-center text-sm font-black tracking-[0.2em] text-avanzia-purple uppercase"
                >
                    {{ paises.map((p) => p.nombre).join(' – ') }}
                </p>

                <ul
                    class="mt-6 grid grid-cols-3 gap-4 sm:grid-cols-5 md:grid-cols-9"
                >
                    <li
                        v-for="pais in paises"
                        :key="pais.archivo"
                        class="flex flex-col items-center gap-2"
                    >
                        <img
                            :src="`/images/banderas/${pais.archivo}.webp`"
                            :alt="`Bandera de ${pais.nombre}`"
                            width="240"
                            height="160"
                            loading="lazy"
                            class="aspect-[3/2] w-full rounded-lg object-cover shadow-md ring-1 ring-slate-200"
                        />
                        <span class="text-xs font-semibold text-slate-500">{{
                            pais.nombre
                        }}</span>
                    </li>
                </ul>

                <div
                    class="mt-10 flex gap-4 rounded-2xl bg-avanzia-cream/40 p-6"
                >
                    <ShieldCheck
                        class="mt-1 size-6 shrink-0 text-avanzia-ochre"
                    />
                    <p>
                        La institución
                        <strong class="text-avanzia-ink"
                            >Avanzia América Latina SAC</strong
                        >, identificada con el Registro Único de Contribuyentes
                        (RUC) N.° {{ RUC }}, se encuentra debidamente inscrita
                        en los Registros Públicos y formalizada conforme a las
                        disposiciones legales vigentes, garantizando así su
                        pleno reconocimiento y operatividad dentro del marco
                        normativo establecido. En virtud de ello, actúa como
                        garante y respaldo legal de la validez del certificado
                        emitido, asegurando su autenticidad y reconocimiento.
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>
