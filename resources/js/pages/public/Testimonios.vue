<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ChevronLeft, ChevronRight, SquarePen, Star } from '@lucide/vue';
import { computed, ref } from 'vue';
import EncabezadoPagina from '@/components/public/EncabezadoPagina.vue';
import OpinionModal from '@/components/public/OpinionModal.vue';
import SeoHead from '@/components/public/SeoHead.vue';
import TarjetaOpinion from '@/components/public/TarjetaOpinion.vue';
import { RUTAS_LEGALES } from '@/lib/public/contacto';
import { vReveal } from '@/lib/public/reveal';
import type {
    EstadisticasOpiniones,
    OpinionLanding,
    Paginado,
    Seo,
} from '@/types';

const props = defineProps<{
    seo: Seo;
    opiniones: Paginado<OpinionLanding>;
    estadisticas: EstadisticasOpiniones;
    paises: Record<string, string>;
    cursosOpinion: string[];
}>();

const opinando = ref(false);
const formatoNumero = new Intl.NumberFormat('es-PE');

const urlPagina = (n: number) =>
    n === 1
        ? RUTAS_LEGALES.testimonios
        : `${RUTAS_LEGALES.testimonios}?page=${n}`;

// Números a mostrar: primera, última y dos alrededor de la actual; null = "…"
const paginas = computed<(number | null)[]>(() => {
    const { current_page: actual, last_page: ultima } = props.opiniones;
    const lista: (number | null)[] = [];

    for (let n = 1; n <= ultima; n++) {
        if (n === 1 || n === ultima || Math.abs(n - actual) <= 2) {
            lista.push(n);
        } else if (lista.at(-1) !== null) {
            lista.push(null);
        }
    }

    return lista;
});
</script>

<template>
    <SeoHead :seo="seo" />

    <EncabezadoPagina
        antetitulo="Comunidad Avanzia"
        titulo="Lo que opinan de nuestros cursos"
        bajada="Docentes de toda América Latina cuentan cómo les ayudó capacitarse con Avanzia."
    />

    <section class="px-4 pb-24">
        <div class="mx-auto max-w-7xl">
            <!-- Estadísticas y llamado -->
            <div
                v-reveal
                class="mb-12 flex flex-col items-center justify-center gap-6 sm:flex-row"
            >
                <div class="flex gap-4">
                    <div
                        class="min-w-[150px] rounded-3xl border border-slate-50 bg-white p-6 text-center shadow-md"
                    >
                        <div class="text-4xl font-black text-avanzia-purple">
                            {{ formatoNumero.format(estadisticas.resenas) }}
                        </div>
                        <div
                            class="mt-2 text-xs font-bold tracking-widest text-slate-400 uppercase"
                        >
                            Testimonios
                        </div>
                    </div>
                    <div
                        v-if="estadisticas.resenas > 0"
                        class="min-w-[150px] rounded-3xl border border-slate-50 bg-white p-6 text-center shadow-md"
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
                <button
                    type="button"
                    class="flex items-center gap-3 rounded-2xl border-[3px] border-avanzia-orange bg-white px-10 py-4 text-lg font-black text-avanzia-orange shadow-lg transition-all hover:-translate-y-1 hover:bg-avanzia-orange hover:text-white hover:shadow-xl"
                    @click="opinando = true"
                >
                    <SquarePen class="size-5" /> Añadir testimonio
                </button>
            </div>

            <!-- Testimonios -->
            <p
                v-if="opiniones.total === 0"
                class="py-16 text-center text-lg text-slate-400"
            >
                Aún no hay testimonios. ¡Sé el primero en contar tu experiencia!
            </p>

            <div v-else class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                <TarjetaOpinion
                    v-for="(opinion, i) in opiniones.data"
                    :key="opinion.id"
                    :opinion="opinion"
                    :retraso="(i % 3) * 0.1"
                />
            </div>

            <!-- Paginación -->
            <nav
                v-if="opiniones.last_page > 1"
                aria-label="Páginas de testimonios"
                class="mt-14 flex flex-wrap items-center justify-center gap-2"
            >
                <Link
                    v-if="opiniones.current_page > 1"
                    :href="urlPagina(opiniones.current_page - 1)"
                    aria-label="Página anterior"
                    class="flex size-11 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 transition-colors hover:border-avanzia-orange hover:text-avanzia-orange"
                >
                    <ChevronLeft class="size-5" />
                </Link>

                <template v-for="(n, i) in paginas" :key="n ?? `salto-${i}`">
                    <span v-if="n === null" class="px-1 text-slate-400">…</span>
                    <span
                        v-else-if="n === opiniones.current_page"
                        aria-current="page"
                        class="flex size-11 items-center justify-center rounded-full bg-avanzia-orange font-bold text-white shadow-md"
                        >{{ n }}</span
                    >
                    <Link
                        v-else
                        :href="urlPagina(n)"
                        class="flex size-11 items-center justify-center rounded-full border border-slate-200 bg-white font-bold text-slate-600 transition-colors hover:border-avanzia-orange hover:text-avanzia-orange"
                        >{{ n }}</Link
                    >
                </template>

                <Link
                    v-if="opiniones.current_page < opiniones.last_page"
                    :href="urlPagina(opiniones.current_page + 1)"
                    aria-label="Página siguiente"
                    class="flex size-11 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 transition-colors hover:border-avanzia-orange hover:text-avanzia-orange"
                >
                    <ChevronRight class="size-5" />
                </Link>
            </nav>
        </div>
    </section>

    <OpinionModal
        :abierto="opinando"
        :cursos="cursosOpinion"
        :paises="paises"
        @cerrar="opinando = false"
    />
</template>
