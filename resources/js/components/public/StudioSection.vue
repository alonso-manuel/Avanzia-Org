<script setup lang="ts">
import { STUDIO_URL } from '@/lib/public/contacto';
import { vReveal } from '@/lib/public/reveal';

const momentos = [
    { etapa: 'Inicio', texto: '¿Qué hay dentro de una semilla?' },
    { etapa: 'Desarrollo', texto: 'Observamos plantas del patio' },
    { etapa: 'Cierre', texto: 'Dibujamos y lo explicamos' },
];

const rubrica = [
    {
        rango: '18–20',
        color: 'bg-[#d99a3a]',
        texto: 'Explica cada parte y su función con ejemplos propios.',
    },
    {
        rango: '14–17',
        color: 'bg-[#ebb866]',
        texto: 'Nombra las partes y explica casi todas sus funciones.',
    },
    {
        rango: '11–13',
        color: 'bg-[#f5d9a6]',
        texto: 'Reconoce algunas partes con apoyo.',
    },
];

const beneficios = [
    {
        titulo: 'Tu sesión, lista para el lunes',
        texto: 'Genera unidades didácticas y sesiones de aprendizaje completas, adaptadas a inicial, primaria, secundaria o superior.',
        forma: 'rounded-[58%_42%_52%_48%/50%_55%_45%_50%]',
        icono: 'libro',
    },
    {
        titulo: 'Rúbricas claras, sin empezar de cero',
        texto: 'Diseña rúbricas cualitativas o escalas vigesimales con descriptores claros, precisos y alineados a tus objetivos de evaluación.',
        forma: 'rounded-[46%_54%_44%_56%/55%_45%_55%_45%]',
        icono: 'lista',
    },
    {
        titulo: 'Tus materiales, tu criterio',
        texto: 'Sube tus propios PDFs o Words. La IA leerá el contexto para generar exámenes y proyectos basados estrictamente en tu material.',
        forma: 'rounded-[52%_48%_58%_42%/44%_56%_44%_56%]',
        icono: 'documento',
    },
];
</script>

<template>
    <section
        id="nosotros"
        class="relative overflow-hidden bg-transparent px-4 py-24 font-studio text-avanzia-ink"
    >
        <div v-reveal class="mx-auto flex max-w-[1160px] flex-col gap-16">
            <div class="flex flex-wrap items-center gap-14">
                <!-- Texto -->
                <div
                    class="flex min-w-[min(300px,100%)] flex-1 flex-col items-start gap-6"
                >
                    <p
                        class="font-manuscrita text-[28px] leading-none font-bold text-avanzia-ochre"
                    >
                        Para ti, docente de Latinoamérica
                    </p>
                    <h2
                        class="font-titular text-[clamp(38px,5.2vw,64px)] leading-[1.04] font-extrabold tracking-tight"
                    >
                        Menos papeleo.<br />Más tiempo para
                        <span class="resaltado">tus estudiantes</span>.
                    </h2>
                    <p
                        class="max-w-[500px] text-[19px] leading-[1.65] text-[#3e382e]"
                    >
                        <strong class="text-avanzia-ink">Avanzia STUDIO</strong>
                        es tu asistente 24/7, pensado para la realidad de las
                        aulas en América Latina. Te ayudamos a dejar atrás el
                        trabajo mecánico y la burocracia documental, para que
                        recuperes tu tiempo y lo dediques a lo que te llevó a
                        enseñar.
                    </p>
                    <a
                        :href="STUDIO_URL"
                        target="_blank"
                        rel="noopener"
                        class="inline-flex min-h-[52px] items-center gap-2.5 rounded-full bg-avanzia-ink px-7 py-3.5 text-[17px] font-semibold text-[#fffdf8] shadow-[0_10px_22px_rgba(31,42,68,.22)] transition-transform duration-150 hover:-translate-y-0.5"
                    >
                        Pruébalo gratis
                        <svg
                            aria-hidden="true"
                            width="18"
                            height="18"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M5 12h14M13 6l6 6-6 6" />
                        </svg>
                    </a>
                    <p class="text-[15px] leading-normal text-[#6b6256]">
                        Para inicial, primaria, secundaria y superior.
                    </p>
                </div>

                <!-- Ilustración: hoja de sesión, archivo y rúbrica -->
                <div
                    aria-hidden="true"
                    class="relative max-w-[620px] min-w-[min(300px,100%)] flex-1 px-2.5 pt-[70px] pb-12"
                >
                    <div
                        class="absolute top-10 right-[-2%] bottom-5 left-[2%] z-0 rounded-[52%_48%_44%_56%/46%_54%_46%_54%] bg-avanzia-cream"
                    />

                    <div
                        class="absolute top-1.5 right-[-8px] z-[4] w-[124px] rotate-[5deg] bg-[#ffe08f] px-3.5 pt-3.5 pb-4 font-manuscrita text-[22px] leading-[1.1] font-bold text-avanzia-ink shadow-[0_10px_18px_rgba(90,56,10,0.2)]"
                    >
                        Tú pones la vocación.
                    </div>

                    <!-- Hoja de cuaderno -->
                    <div
                        class="hoja-cuaderno relative z-[1] ml-1 -rotate-[1.6deg] rounded-[8px_16px_16px_8px] pt-11 pr-7 pb-7 pl-[60px] shadow-[0_22px_44px_rgba(90,56,10,0.2),0_2px_0_rgba(90,56,10,0.06)]"
                    >
                        <div
                            class="absolute -top-[13px] left-1/2 -ml-[45px] h-[26px] w-[90px] -rotate-3 bg-[rgba(243,206,134,0.78)] shadow-[0_1px_2px_rgba(0,0,0,0.1)]"
                        />
                        <div
                            class="absolute top-0 bottom-0 left-[46px] w-0.5 bg-[#edb1a8]"
                        />
                        <div
                            class="absolute top-7 left-3.5 flex flex-col gap-11"
                        >
                            <div
                                v-for="n in 6"
                                :key="n"
                                class="size-3.5 rounded-full bg-[#f1e7d3] shadow-[inset_0_1px_3px_rgba(90,56,10,0.35)]"
                            />
                        </div>

                        <p
                            class="text-xs leading-8 font-bold tracking-[0.08em] text-[#6b6256] uppercase"
                        >
                            Sesión de aprendizaje
                        </p>
                        <p
                            class="font-manuscrita text-[32px] leading-8 font-bold text-avanzia-ink"
                        >
                            Las partes de una planta
                        </p>
                        <p class="text-[15px] leading-8 text-[#6b6256]">
                            Ciencia y Tecnología · 3.er grado de primaria
                        </p>
                        <p class="text-[15px] leading-8 text-[#2e2a22]">
                            <strong>Propósito:</strong> reconocer y nombrar las
                            partes de una planta.
                        </p>

                        <div class="flex flex-col">
                            <div
                                v-for="momento in momentos"
                                :key="momento.etapa"
                                class="flex items-start gap-2.5 text-[15px] leading-8 text-[#2e2a22]"
                            >
                                <svg
                                    width="22"
                                    height="22"
                                    viewBox="0 0 22 22"
                                    class="mt-[5px] flex-none"
                                >
                                    <circle
                                        cx="11"
                                        cy="11"
                                        r="8.5"
                                        fill="none"
                                        stroke="#B3640A"
                                        stroke-width="1.6"
                                    />
                                    <path
                                        d="M6.8 11.4l3 3 5.6-6.6"
                                        fill="none"
                                        stroke="#B3640A"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />
                                </svg>
                                <span
                                    ><strong>{{ momento.etapa }} ·</strong>
                                    {{ momento.texto }}</span
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Etiquetas -->
                    <div
                        class="relative z-[2] -mt-[26px] flex flex-wrap items-end justify-between gap-x-5 gap-y-4 px-1"
                    >
                        <div class="flex flex-col items-start gap-2.5 pb-5">
                            <div
                                class="inline-flex -rotate-[2.5deg] items-center gap-2.5 rounded-[14px] border border-[#e6d9bf] bg-white py-2.5 pr-4 pl-2.5 shadow-[0_10px_22px_rgba(90,56,10,0.14)]"
                            >
                                <span
                                    class="flex size-[34px] items-center justify-center rounded-[10px] bg-avanzia-cream"
                                >
                                    <svg
                                        width="20"
                                        height="20"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="#1F2A44"
                                        stroke-width="1.8"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <path
                                            d="M7 3.5h7l4 4V20a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5V4a.5.5 0 0 1 .5-.5z"
                                        />
                                        <path d="M14 3.5V8h4M9 13h6M9 16.5h4" />
                                    </svg>
                                </span>
                                <span
                                    class="text-sm font-semibold text-avanzia-ink"
                                    >unidad_2_ciencias.pdf</span
                                >
                            </div>
                            <p
                                class="ml-2 max-w-[200px] -rotate-2 font-manuscrita text-[23px] leading-[1.05] font-bold text-avanzia-ochre"
                            >
                                Avanzia lee tu propio material
                            </p>
                        </div>

                        <div
                            class="max-w-[320px] flex-[1_1_270px] rotate-[1.8deg] rounded-[14px] bg-white px-5 pt-[18px] pb-5 shadow-[0_18px_36px_rgba(90,56,10,0.18)]"
                        >
                            <p
                                class="mb-3 font-titular text-base leading-tight font-semibold text-avanzia-ink"
                            >
                                Rúbrica: explica las partes de la planta
                            </p>
                            <div class="flex flex-col gap-2.5">
                                <div
                                    v-for="nivel in rubrica"
                                    :key="nivel.rango"
                                    class="flex items-start gap-2.5"
                                >
                                    <span
                                        class="min-w-[58px] flex-none rounded-full px-2 py-[3px] text-center text-xs leading-[1.3] font-bold text-avanzia-ink"
                                        :class="nivel.color"
                                        >{{ nivel.rango }}</span
                                    >
                                    <span
                                        class="text-sm leading-[1.4] text-[#4a4338]"
                                        >{{ nivel.texto }}</span
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lápiz -->
                    <svg
                        width="176"
                        height="22"
                        viewBox="0 0 176 22"
                        class="absolute right-[30px] bottom-1.5 z-[3] -rotate-[7deg] drop-shadow-[0_4px_4px_rgba(90,56,10,0.22)]"
                    >
                        <rect
                            x="0"
                            y="3"
                            width="16"
                            height="16"
                            rx="4"
                            fill="#E88F86"
                        />
                        <rect
                            x="16"
                            y="3"
                            width="12"
                            height="16"
                            fill="#B8BEC9"
                        />
                        <rect
                            x="28"
                            y="3"
                            width="102"
                            height="16"
                            fill="#E9B04A"
                        />
                        <rect
                            x="28"
                            y="10"
                            width="102"
                            height="2"
                            fill="#D79A32"
                        />
                        <polygon
                            points="130,3 160,8.5 160,13.5 130,19"
                            fill="#F3DDB5"
                        />
                        <polygon points="154,9 176,11 154,13" fill="#2B2A28" />
                    </svg>
                </div>
            </div>

            <!-- Beneficios -->
            <div
                class="flex flex-wrap gap-x-12 gap-y-10 border-t-[1.5px] border-dashed border-[#d8c7a3] pt-11"
            >
                <div
                    v-for="beneficio in beneficios"
                    :key="beneficio.titulo"
                    class="flex min-w-0 flex-[1_1_280px] flex-col gap-3.5"
                >
                    <div
                        class="flex size-14 items-center justify-center bg-avanzia-cream"
                        :class="beneficio.forma"
                    >
                        <svg
                            aria-hidden="true"
                            width="26"
                            height="26"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="#1F2A44"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <template v-if="beneficio.icono === 'libro'">
                                <path
                                    d="M12 6.5C10.3 5.2 8 4.8 4.5 5v12c3.5-.2 5.8.2 7.5 1.5 1.7-1.3 4-1.7 7.5-1.5V5c-3.5-.2-5.8.2-7.5 1.5z"
                                />
                                <path d="M12 6.5v12" />
                            </template>
                            <template v-else-if="beneficio.icono === 'lista'">
                                <rect
                                    x="4"
                                    y="4"
                                    width="16"
                                    height="16"
                                    rx="3"
                                />
                                <path
                                    d="M8 9l1.5 1.5L12 8M8 15l1.5 1.5L12 14M14.5 9.5H17M14.5 15.5H17"
                                />
                            </template>
                            <template v-else>
                                <path
                                    d="M7 3.5h7l4 4V20a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5V4a.5.5 0 0 1 .5-.5z"
                                />
                                <path d="M14 3.5V8h4M9 13h6M9 16.5h4" />
                            </template>
                        </svg>
                    </div>
                    <h3
                        class="font-titular text-[23px] leading-[1.2] font-semibold"
                    >
                        {{ beneficio.titulo }}
                    </h3>
                    <p class="text-[16.5px] leading-[1.65] text-[#4a4338]">
                        {{ beneficio.texto }}
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>
