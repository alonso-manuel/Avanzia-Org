<script setup lang="ts">
import { Cpu, Eye, Laptop, Lightbulb, Users } from '@lucide/vue';
import SeoHead from '@/components/public/SeoHead.vue';
import { vReveal } from '@/lib/public/reveal';
import type { Seo } from '@/types';

defineProps<{ seo: Seo }>();

const metricas = [
    { valor: '+2,000', texto: 'Docentes capacitados.' },
    { valor: '20', texto: 'Cursos de especialización.' },
    { valor: '26', texto: 'Herramientas de vanguardia.' },
];

// Patrón sutil de fondo para las tarjetas ilustrativas de misión y visión
const patron =
    'bg-[linear-gradient(30deg,#64748b_12%,transparent_12.5%,transparent_87%,#64748b_87.5%),linear-gradient(150deg,#64748b_12%,transparent_12.5%,transparent_87%,#64748b_87.5%)] bg-[length:40px_70px]';
</script>

<template>
    <SeoHead :seo="seo" />

    <!-- Presentación -->
    <section
        class="relative flex min-h-[80vh] items-center overflow-hidden bg-white/50 px-4 pt-40 pb-20 backdrop-blur-sm"
    >
        <div v-reveal class="mx-auto w-full max-w-7xl">
            <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-20">
                <!-- Imagen -->
                <div class="relative order-2 lg:order-1">
                    <div
                        aria-hidden="true"
                        class="absolute -inset-4 -z-10 rounded-[3rem] bg-gradient-to-tr from-avanzia-orange/20 to-transparent blur-xl"
                    />
                    <img
                        src="https://images.unsplash.com/photo-1573164713988-8665fc963095?auto=format&fit=crop&w=800&q=80"
                        alt="Docente innovando con tecnología"
                        width="800"
                        height="1000"
                        class="relative z-10 aspect-[4/5] h-auto w-full rounded-3xl object-cover shadow-2xl md:aspect-square lg:aspect-[4/5]"
                    />
                    <div
                        class="absolute -right-2 -bottom-6 z-20 max-w-[200px] animate-pulse-soft rounded-2xl border border-slate-100 bg-white p-6 shadow-xl md:-right-10 md:bottom-10"
                    >
                        <Lightbulb class="mb-2 size-8 text-avanzia-orange" />
                        <p class="text-sm font-bold text-slate-800">
                            Empoderando docentes cada día.
                        </p>
                    </div>
                </div>

                <!-- Texto -->
                <div class="relative order-1 pt-10 lg:order-2 lg:pt-0">
                    <div
                        aria-hidden="true"
                        class="pointer-events-none absolute -top-5 left-0 z-0 font-titular text-[clamp(60px,12vw,150px)] font-black tracking-[-0.05em] text-avanzia-orange opacity-15 select-none"
                    >
                        Nosotros
                    </div>

                    <div class="relative z-10">
                        <h1
                            class="mb-8 font-titular text-4xl leading-[1.1] font-black tracking-tight text-slate-900 md:text-5xl lg:text-6xl"
                        >
                            Innovación Educativa.
                        </h1>

                        <div
                            class="space-y-6 text-lg leading-relaxed font-medium text-slate-600"
                        >
                            <p>
                                En
                                <strong class="text-slate-900">Avanzia</strong>,
                                conectamos a los docentes con las herramientas
                                tecnológicas más avanzadas para modernizar el
                                proceso de enseñanza-aprendizaje.
                            </p>
                            <p>
                                Nos especializamos en capacitar a educadores en
                                el uso de IA generativa, ofimática inteligente y
                                metodologías de gamificación, garantizando que
                                cada nueva habilidad sea aplicable de inmediato
                                en el salón de clases para beneficio de sus
                                estudiantes.
                            </p>
                        </div>

                        <div
                            class="mt-12 grid grid-cols-3 gap-6 border-t border-slate-200 pt-10"
                        >
                            <div
                                v-for="metrica in metricas"
                                :key="metrica.texto"
                            >
                                <div
                                    class="mb-2 font-titular text-3xl font-black text-avanzia-purple sm:text-4xl"
                                >
                                    {{ metrica.valor }}
                                </div>
                                <p
                                    class="text-sm font-semibold text-avanzia-orange"
                                >
                                    {{ metrica.texto }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Misión y visión -->
    <section class="relative overflow-hidden bg-slate-50 px-4 py-24">
        <div
            aria-hidden="true"
            class="absolute top-0 right-0 size-96 translate-x-1/2 -translate-y-1/2 rounded-full bg-avanzia-orange/5 blur-3xl"
        />
        <div
            aria-hidden="true"
            class="absolute bottom-0 left-0 size-96 -translate-x-1/2 translate-y-1/2 rounded-full bg-avanzia-purple/5 blur-3xl"
        />

        <div v-reveal class="relative mx-auto max-w-6xl space-y-24">
            <!-- Misión -->
            <div
                class="flex flex-col items-center gap-12 md:flex-row lg:gap-20"
            >
                <div
                    aria-hidden="true"
                    class="group relative flex aspect-video w-full items-center justify-center overflow-hidden rounded-3xl border border-slate-100 bg-white p-8 shadow-sm md:w-1/2"
                >
                    <div
                        class="absolute inset-0 opacity-[0.06] transition-transform duration-700 group-hover:scale-105"
                        :class="patron"
                    />
                    <Users
                        class="relative z-10 size-24 text-avanzia-purple/20 transition-colors group-hover:text-avanzia-purple/40"
                    />
                </div>
                <div class="w-full md:w-1/2">
                    <h2
                        class="mb-6 font-titular text-4xl font-black text-avanzia-navy lg:text-5xl"
                    >
                        Misión
                    </h2>
                    <p
                        class="text-xl leading-relaxed font-medium text-slate-600"
                    >
                        Hacer accesible la mejor formación online para toda
                        América Latina, promoviendo el desarrollo de habilidades
                        clave que impulsen el progreso de personas, empresas y
                        comunidades.
                    </p>
                    <div class="mt-6 space-y-4">
                        <div class="flex items-start gap-4">
                            <Laptop
                                class="mt-1 size-5 shrink-0 text-avanzia-orange"
                            />
                            <p class="text-slate-600">
                                <strong class="text-slate-900"
                                    >Avanzia Flex:</strong
                                >
                                Democratizamos la educación continua asincrónica
                                con excelencia pedagógica.
                            </p>
                        </div>
                        <div class="flex items-start gap-4">
                            <Cpu
                                class="mt-1 size-5 shrink-0 text-avanzia-purple"
                            />
                            <p class="text-slate-600">
                                <strong class="text-slate-900"
                                    >Avanzia STUDIO:</strong
                                >
                                Brindamos herramientas de IA que devuelven a los
                                docentes su tiempo invaluable.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Visión -->
            <div
                class="flex flex-col items-center gap-12 md:flex-row-reverse lg:gap-20"
            >
                <div
                    aria-hidden="true"
                    class="group relative flex aspect-video w-full items-center justify-center overflow-hidden rounded-3xl border border-slate-100 bg-white p-8 shadow-sm md:w-1/2"
                >
                    <div
                        class="absolute inset-0 opacity-[0.06] transition-transform duration-700 group-hover:scale-105"
                        :class="patron"
                    />
                    <Eye
                        class="relative z-10 size-24 text-avanzia-orange/20 transition-colors group-hover:text-avanzia-orange/40"
                    />
                </div>
                <div class="w-full text-left md:w-1/2 md:text-right">
                    <h2
                        class="mb-6 font-titular text-4xl font-black text-avanzia-navy lg:text-5xl"
                    >
                        Visión
                    </h2>
                    <p
                        class="text-xl leading-relaxed font-medium text-slate-600"
                    >
                        Ser la plataforma de capacitación en línea preferida en
                        América Latina, conocida por su calidad educativa,
                        innovación tecnológica y compromiso con el desarrollo
                        regional.
                    </p>
                    <p class="mt-6 leading-relaxed text-slate-600">
                        Visualizamos un futuro donde cada educador esté
                        potenciado por asistentes virtuales como
                        <strong>Avanzia STUDIO</strong> y apoyado en la libertad
                        de aprendizaje que ofrece <strong>Avanzia Flex</strong>.
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>
