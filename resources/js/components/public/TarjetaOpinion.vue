<script setup lang="ts">
import { Star } from '@lucide/vue';
import { computed } from 'vue';
import type { OpinionLanding } from '@/types';

const props = defineProps<{
    opinion: OpinionLanding;
    // Retraso de la animación de entrada (en segundos), para escalonar las tarjetas
    retraso?: number;
}>();

const ubicacion = computed(() =>
    props.opinion.institucion
        ? `${props.opinion.ciudad} • ${props.opinion.institucion}`
        : props.opinion.ciudad,
);
</script>

<!-- Testimonio con la bandera del país difuminada. `pais` viene validado de una lista cerrada (seguro en url()) -->
<template>
    <article
        class="card-testimonial flex animate-fade-in flex-col rounded-3xl border border-slate-100 p-8 shadow-lg md:p-10"
        :style="{
            '--flag-url': `url('https://flagcdn.com/w160/${opinion.pais}.png')`,
            animationDelay: `${retraso ?? 0}s`,
        }"
    >
        <div class="relative z-10 flex h-full flex-col">
            <div
                class="mb-6 flex text-amber-400"
                :aria-label="`${opinion.estrellas} de 5 estrellas`"
            >
                <Star
                    v-for="n in 5"
                    :key="n"
                    class="size-5"
                    :class="
                        n <= opinion.estrellas
                            ? 'fill-current'
                            : 'fill-slate-200 text-slate-200'
                    "
                />
            </div>
            <!-- Texto plano: respeta saltos de línea y corta palabras larguísimas para no romper la tarjeta -->
            <p
                class="mb-8 flex-grow text-lg leading-relaxed [overflow-wrap:anywhere] whitespace-pre-line text-slate-600 italic"
            >
                "{{ opinion.comentario }}"
            </p>
            <div class="mt-auto border-t border-slate-100 pt-6">
                <h4
                    class="mb-1 text-xl font-black [overflow-wrap:anywhere] text-slate-900"
                >
                    {{ opinion.nombre }}
                </h4>
                <p class="text-sm font-medium text-slate-500">
                    {{ ubicacion }}
                </p>
                <p
                    class="mt-3 inline-block rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-bold text-slate-600"
                >
                    {{ opinion.curso }}
                </p>
            </div>
        </div>
    </article>
</template>
