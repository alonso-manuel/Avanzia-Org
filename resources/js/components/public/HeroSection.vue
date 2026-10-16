<script setup lang="ts">
import { ArrowRight } from '@lucide/vue';
import { onBeforeUnmount, onMounted, ref } from 'vue';
import { STUDIO_URL } from '@/lib/public/contacto';
import { vReveal } from '@/lib/public/reveal';

const TITULAR = 'Ahorra hasta 15 horas semanales en tu labor docente.';

// Sin JS (o con SSR) se ve el titular completo; en el navegador se escribe letra por letra
const titular = ref(TITULAR);
let temporizador: ReturnType<typeof setTimeout> | undefined;

onMounted(() => {
    titular.value = '';
    let i = 0;

    const escribir = () => {
        if (i < TITULAR.length) {
            titular.value += TITULAR.charAt(i++);
            temporizador = setTimeout(escribir, 40);
        }
    };

    temporizador = setTimeout(escribir, 500);
});

onBeforeUnmount(() => clearTimeout(temporizador));
</script>

<template>
    <section
        id="inicio"
        class="relative isolate flex min-h-[85vh] flex-col items-center justify-center overflow-hidden px-4 pt-32 pb-10 text-center lg:pt-40 lg:pb-12"
    >
        <video
            autoplay
            loop
            muted
            playsinline
            preload="metadata"
            poster="/images/hero-poster.webp"
            aria-hidden="true"
            class="pointer-events-none absolute inset-0 -z-20 h-full w-full object-cover"
        >
            <source src="/videos/avanzia-docentes.webm" type="video/webm" />
        </video>

        <!-- Overlay oscuro para garantizar contraste -->
        <div
            class="absolute inset-0 -z-10 bg-slate-900/40 mix-blend-multiply"
        />

        <div
            v-reveal
            class="glass-gradient relative z-10 mx-auto w-full max-w-[95%] rounded-[3rem] p-8 md:p-14 lg:p-20 xl:max-w-7xl"
        >
            <h1
                class="cursor-blink mb-8 min-h-[100px] text-4xl leading-[1.2] font-black tracking-tighter text-white md:min-h-[80px] md:text-5xl lg:text-6xl"
                :aria-label="TITULAR"
            >
                {{ titular }}
            </h1>
            <p
                class="mx-auto mb-12 max-w-4xl text-base leading-relaxed font-medium text-white/90 md:text-xl"
            >
                La primera plataforma educativa que integra un asistente de IA
                capaz de estructurar sesiones, analizar documentos y generar
                rúbricas en segundos, respetando normativas oficiales y
                liberando tu tiempo.
            </p>
            <div
                class="flex flex-col items-center justify-center gap-6 sm:flex-row"
            >
                <a
                    :href="STUDIO_URL"
                    target="_blank"
                    rel="noopener"
                    class="flex w-full items-center justify-center gap-3 rounded-full bg-white px-12 py-4 text-lg font-semibold text-avanzia-black shadow-xl transition-all hover:-translate-y-1 hover:bg-slate-100 sm:w-auto"
                >
                    CREAR CON IA
                    <ArrowRight class="size-4" />
                </a>
            </div>
        </div>
    </section>
</template>
