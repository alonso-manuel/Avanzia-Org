<script setup lang="ts">
import { Check, ChevronLeft, ChevronRight, Clock, Flame } from '@lucide/vue';
import { computed, reactive, ref } from 'vue';
import { useCarrito } from '@/lib/public/carrito';
import { registrarInteraccion } from '@/lib/public/interacciones';
import type { TipoInteraccion } from '@/lib/public/interacciones';
import { vReveal } from '@/lib/public/reveal';
import type { CategoriaLanding, CursoLanding } from '@/types';

const props = defineProps<{
    cursos: CursoLanding[];
    categorias: CategoriaLanding[];
    umbralInteresados: number;
}>();

// El modal del temario vive en la página: un ancestro con blur o transform rompería su position: fixed
const emit = defineEmits<{ verTemario: [curso: CursoLanding] }>();

const carrito = useCarrito();

// Interesados devueltos por el servidor tras una interacción (se ven sin recargar)
const interesadosActuales = reactive<Record<number, number>>({});

const interesados = (curso: CursoLanding) =>
    interesadosActuales[curso.id] ?? curso.interesados;

async function interactuar(curso: CursoLanding, tipo: TipoInteraccion) {
    const total = await registrarInteraccion(curso.id, tipo);

    if (total !== null) {
        interesadosActuales[curso.id] = total;
    }
}

function verTemario(curso: CursoLanding) {
    emit('verTemario', curso);
    void interactuar(curso, 'temario');
}

function loQuiero(curso: CursoLanding) {
    if (carrito.contiene(curso.id)) {
        carrito.abierto.value = true;
    } else {
        carrito.agregar(curso);
        void interactuar(curso, 'carrito');
    }
}

// 8 = dos filas completas en la cuadrícula de 4 columnas
const POR_PAGINA = 8;

const categoriaActiva = ref('todos');
const pagina = ref(1);

// Solo se muestran las categorías que tienen cursos publicados
const categorias = computed(() => [
    { id: 'todos', nombre: 'Todos los Cursos' },
    ...props.categorias.filter((c) =>
        props.cursos.some((curso) => curso.categoria === c.id),
    ),
]);

const filtrados = computed(() =>
    categoriaActiva.value === 'todos'
        ? props.cursos
        : props.cursos.filter((c) => c.categoria === categoriaActiva.value),
);

const totalPaginas = computed(() =>
    Math.max(1, Math.ceil(filtrados.value.length / POR_PAGINA)),
);

const visibles = computed(() =>
    filtrados.value.slice(
        (pagina.value - 1) * POR_PAGINA,
        pagina.value * POR_PAGINA,
    ),
);

function elegirCategoria(id: string) {
    categoriaActiva.value = id;
    pagina.value = 1;
}
</script>

<template>
    <section
        id="cursos"
        class="relative isolate overflow-hidden border-y border-slate-700/50 bg-slate-900/85 px-4 py-24 backdrop-blur-xl"
    >
        <div
            aria-hidden="true"
            class="absolute inset-0 -z-10 bg-[radial-gradient(#da9645_1.5px,transparent_1.5px)] bg-[length:40px_40px] opacity-10"
        />

        <div v-reveal class="mx-auto max-w-7xl">
            <div class="mb-12 text-left">
                <h2
                    class="mb-4 text-4xl font-black tracking-tight text-white md:text-5xl"
                >
                    Catálogo de Especialización
                </h2>
                <p class="max-w-2xl text-xl text-slate-300">
                    Capacítate con expertos y domina herramientas tecnológicas
                    que transformarán tu perfil profesional.
                </p>
            </div>

            <div
                class="mb-10 flex flex-wrap gap-3 border-b border-slate-700 pb-6"
            >
                <button
                    v-for="categoria in categorias"
                    :key="categoria.id"
                    type="button"
                    class="rounded-full border px-5 py-2.5 text-sm font-bold shadow-sm transition-all"
                    :class="
                        categoria.id === categoriaActiva
                            ? 'border-avanzia-orange bg-avanzia-orange text-white'
                            : 'border-slate-600 bg-slate-800 text-slate-300 hover:bg-slate-700'
                    "
                    @click="elegirCategoria(categoria.id)"
                >
                    {{ categoria.nombre }}
                </button>
            </div>

            <div
                class="mb-12 grid min-h-[400px] gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
            >
                <p
                    v-if="visibles.length === 0"
                    class="col-span-full py-10 text-center text-slate-400"
                >
                    No se encontraron cursos en esta categoría.
                </p>

                <article
                    v-for="(curso, i) in visibles"
                    :key="`${categoriaActiva}-${pagina}-${curso.id}`"
                    class="group flex animate-fade-in flex-col overflow-hidden rounded-3xl border border-slate-700/50 bg-slate-800 shadow-2xl transition-all duration-300 hover:border-slate-600 hover:shadow-[0_20px_40px_rgba(218,150,69,0.15)]"
                    :style="{ animationDelay: `${i * 0.1}s` }"
                >
                    <!-- Afiche del curso (sin la franja inferior), completo y sin superposiciones para no tapar su texto.
                         Proporción común 13:10; si un afiche es más alto, quedan bordes laterales del tono del afiche -->
                    <div
                        class="relative aspect-[13/10] overflow-hidden bg-[#e9eced]"
                    >
                        <img
                            v-if="curso.imagen"
                            :src="curso.imagen"
                            :alt="curso.titulo"
                            width="800"
                            height="620"
                            loading="lazy"
                            class="h-full w-full object-contain transition-transform duration-700 group-hover:scale-105"
                        />
                    </div>
                    <div class="flex flex-grow flex-col bg-slate-800 p-5">
                        <div class="mb-3 flex flex-wrap items-center gap-2">
                            <span
                                class="rounded-full border border-white/15 bg-white/5 px-3 py-1 text-[10px] font-black text-slate-200 uppercase"
                                >{{ curso.categoriaNombre }}</span
                            >
                            <span
                                v-if="curso.horas || curso.duracion"
                                class="inline-flex items-center gap-1 rounded-full border border-white/10 bg-black/30 px-3 py-1 text-[10px] font-bold text-white uppercase"
                            >
                                <Clock class="size-3 text-avanzia-orange" />
                                {{
                                    curso.horas
                                        ? `${curso.horas} Hrs`
                                        : curso.duracion
                                }}
                            </span>
                            <span
                                v-if="curso.gratuito"
                                class="rounded-full bg-emerald-500 px-3 py-1 text-[10px] font-black text-white uppercase shadow-sm"
                                >Gratis</span
                            >
                        </div>
                        <h3
                            class="mb-2 text-lg leading-tight font-black text-white transition-colors group-hover:text-avanzia-orange"
                        >
                            {{ curso.titulo }}
                        </h3>
                        <p
                            class="mb-4 flex-grow text-sm leading-relaxed text-slate-400"
                        >
                            {{ curso.descripcion }}
                        </p>
                        <!-- Interesados: alumnos de ciclos anteriores + visitantes reales (ver Curso::conInteresados) -->
                        <p
                            v-if="interesados(curso) >= umbralInteresados"
                            class="mb-2 inline-flex items-center gap-1.5 text-xs font-bold text-slate-300"
                            :title="`${interesados(curso)} docentes vieron el temario o lo agregaron al carrito`"
                        >
                            <Flame class="size-4 text-avanzia-orange" />
                            {{ interesados(curso) }}
                            {{
                                interesados(curso) === 1
                                    ? 'docente interesado'
                                    : 'docentes interesados'
                            }}
                        </p>
                        <div class="mt-auto grid grid-cols-2 gap-3 pt-4">
                            <button
                                type="button"
                                class="rounded-xl border border-slate-600 py-3 text-sm font-black text-slate-300 transition-all hover:border-slate-400 hover:bg-slate-700"
                                @click="verTemario(curso)"
                            >
                                Ver temario
                            </button>
                            <button
                                type="button"
                                class="flex items-center justify-center gap-1.5 rounded-xl py-3 text-sm font-black shadow-md transition-all"
                                :class="
                                    carrito.contiene(curso.id)
                                        ? 'border border-avanzia-orange bg-transparent text-avanzia-orange hover:bg-avanzia-orange/10'
                                        : 'bg-avanzia-orange text-white hover:bg-avanzia-orange-dark hover:shadow-avanzia-orange/30'
                                "
                                @click="loQuiero(curso)"
                            >
                                <template v-if="carrito.contiene(curso.id)">
                                    <Check class="size-4" /> En tu carrito
                                </template>
                                <template v-else>Lo quiero</template>
                            </button>
                        </div>
                    </div>
                </article>
            </div>

            <div
                v-if="totalPaginas > 1"
                class="flex items-center justify-center gap-4"
            >
                <button
                    type="button"
                    aria-label="Página anterior"
                    class="flex size-12 items-center justify-center rounded-full bg-white/10 text-white transition-all hover:bg-white/20 disabled:opacity-30"
                    :disabled="pagina === 1"
                    @click="pagina--"
                >
                    <ChevronLeft class="size-5" />
                </button>
                <span class="text-lg font-bold text-white"
                    >{{ pagina }} / {{ totalPaginas }}</span
                >
                <button
                    type="button"
                    aria-label="Página siguiente"
                    class="flex size-12 items-center justify-center rounded-full bg-white/10 text-white transition-all hover:bg-white/20 disabled:opacity-30"
                    :disabled="pagina === totalPaginas"
                    @click="pagina++"
                >
                    <ChevronRight class="size-5" />
                </button>
            </div>
        </div>
    </section>
</template>
