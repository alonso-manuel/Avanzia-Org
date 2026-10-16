<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { MessagesSquare, SquarePen, Star } from '@lucide/vue';
import { computed, onBeforeUnmount, onMounted, ref, watch } from 'vue';
import TarjetaOpinion from '@/components/public/TarjetaOpinion.vue';
import { RUTAS_LEGALES } from '@/lib/public/contacto';
import { vReveal } from '@/lib/public/reveal';
import type { EstadisticasOpiniones, OpinionLanding } from '@/types';

const props = defineProps<{
    opiniones: OpinionLanding[];
    estadisticas: EstadisticasOpiniones;
    pausado: boolean;
}>();

const emit = defineEmits<{ opinar: [] }>();

const POR_PAGINA = 6;
const ROTACION_MS = 10_000;

const pagina = ref(0);
// Reinicia la animación de la barra de progreso en cada cambio de página
const ciclo = ref(0);
const enMarcha = ref(false);
let intervalo: ReturnType<typeof setInterval> | undefined;

const totalPaginas = computed(() =>
    Math.ceil(props.opiniones.length / POR_PAGINA),
);

const visibles = computed(() =>
    props.opiniones.slice(
        pagina.value * POR_PAGINA,
        (pagina.value + 1) * POR_PAGINA,
    ),
);

const formatoNumero = new Intl.NumberFormat('es-PE');

function detener() {
    clearInterval(intervalo);
    enMarcha.value = false;
}

function iniciar() {
    detener();

    if (totalPaginas.value <= 1) {
        return;
    }

    enMarcha.value = true;
    ciclo.value++;
    intervalo = setInterval(() => {
        pagina.value = (pagina.value + 1) % totalPaginas.value;
        ciclo.value++;
    }, ROTACION_MS);
}

onMounted(iniciar);
onBeforeUnmount(detener);

// Al publicar un testimonio llega la lista nueva: volver a la primera página para verlo
watch(
    () => props.opiniones,
    () => {
        pagina.value = 0;
        ciclo.value++;
    },
);

watch(
    () => props.pausado,
    (pausado) => (pausado ? detener() : iniciar()),
);
</script>

<template>
    <section
        id="comentarios"
        class="relative border-y border-slate-100 bg-white px-4 py-24"
    >
        <div v-reveal class="mx-auto max-w-7xl">
            <!-- Cabecera y estadísticas -->
            <div
                class="mb-16 flex flex-col items-center justify-between gap-10 rounded-[2.5rem] border border-slate-100 bg-slate-50 p-8 shadow-sm md:p-12 lg:flex-row"
            >
                <div class="text-left lg:w-1/2">
                    <h2
                        class="mb-4 text-4xl font-black tracking-tight text-slate-900 md:text-5xl"
                    >
                        Lo que opinan de nuestros cursos.
                    </h2>
                    <p class="text-xl leading-relaxed text-slate-500">
                        Únete a la red global de educadores que están liderando
                        la transformación digital en sus aulas.
                    </p>
                </div>

                <div
                    class="flex w-full flex-wrap justify-center gap-4 sm:flex-nowrap sm:gap-6 lg:w-1/2 lg:justify-end"
                >
                    <div
                        class="max-w-[180px] flex-1 rounded-3xl border border-slate-50 bg-white p-6 text-center shadow-md transition-transform hover:-translate-y-1"
                    >
                        <div class="text-4xl font-black text-avanzia-orange">
                            2,000
                        </div>
                        <div
                            class="mt-2 text-xs font-bold tracking-widest text-slate-400 uppercase"
                        >
                            Docentes Capacitados
                        </div>
                    </div>
                    <div
                        class="max-w-[180px] flex-1 rounded-3xl border border-slate-50 bg-white p-6 text-center shadow-md transition-transform hover:-translate-y-1"
                    >
                        <div class="text-4xl font-black text-avanzia-purple">
                            {{ formatoNumero.format(estadisticas.resenas) }}
                        </div>
                        <div
                            class="mt-2 text-xs font-bold tracking-widest text-slate-400 uppercase"
                        >
                            Total de Reseñas
                        </div>
                    </div>
                    <div
                        v-if="estadisticas.resenas > 0"
                        class="max-w-[180px] flex-1 rounded-3xl border border-slate-50 bg-white p-6 text-center shadow-md transition-transform hover:-translate-y-1"
                    >
                        <div
                            class="flex items-center justify-center gap-2 text-4xl font-black text-amber-400"
                        >
                            {{ estadisticas.promedio.toFixed(2) }}
                            <Star class="size-6 fill-current" />
                        </div>
                        <div
                            class="mt-2 text-xs font-bold tracking-widest text-slate-400 uppercase"
                        >
                            Calificación Prom.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarjetas (rotan cada 10 s) -->
            <div class="mb-16 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                <p
                    v-if="opiniones.length === 0"
                    class="col-span-full py-10 text-center text-lg text-slate-400"
                >
                    Sé el primero en contar tu experiencia.
                </p>

                <TarjetaOpinion
                    v-for="(opinion, i) in visibles"
                    :key="`${pagina}-${opinion.id}`"
                    :opinion="opinion"
                    :retraso="i * 0.1"
                />
            </div>

            <div
                class="flex flex-col items-center justify-center gap-6 sm:flex-row"
            >
                <button
                    type="button"
                    class="flex items-center gap-3 rounded-2xl border-[3px] border-avanzia-orange bg-white px-10 py-4 text-lg font-black text-avanzia-orange shadow-lg transition-all hover:-translate-y-1 hover:bg-avanzia-orange hover:text-white hover:shadow-xl"
                    @click="emit('opinar')"
                >
                    <SquarePen class="size-5" /> Añadir testimonio
                </button>
                <Link
                    v-if="estadisticas.resenas > 0"
                    :href="RUTAS_LEGALES.testimonios"
                    class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-100 px-10 py-4 text-lg font-bold text-slate-700 transition-all hover:bg-slate-200"
                >
                    <MessagesSquare class="size-5" /> Mostrar todos
                </Link>
            </div>

            <!-- Barra de progreso de la rotación -->
            <div
                v-if="totalPaginas > 1"
                class="mx-auto mt-10 h-1.5 w-full max-w-md overflow-hidden rounded-full bg-slate-100"
            >
                <div
                    :key="ciclo"
                    class="h-full rounded-full bg-avanzia-orange"
                    :class="enMarcha ? 'barra-progreso' : 'w-0'"
                    :style="{ animationDuration: `${ROTACION_MS}ms` }"
                />
            </div>
        </div>
    </section>
</template>

<style scoped>
.barra-progreso {
    animation-name: llenar;
    animation-timing-function: linear;
    animation-fill-mode: forwards;
}

@keyframes llenar {
    from {
        width: 0;
    }
    to {
        width: 100%;
    }
}
</style>
