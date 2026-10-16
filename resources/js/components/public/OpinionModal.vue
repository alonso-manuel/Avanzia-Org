<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { CircleCheck, Star, X } from '@lucide/vue';
import { ref, watch } from 'vue';
import { store } from '@/actions/App/Http/Controllers/Public/OpinionController';
import ModalPublico from '@/components/public/ModalPublico.vue';

const props = defineProps<{
    abierto: boolean;
    cursos: string[];
    paises: Record<string, string>;
}>();

const emit = defineEmits<{ cerrar: [] }>();

const enviada = ref(false);
// Lo informa el servidor con el flash "opinion": publicada | en_revision
const resultado = ref<'publicada' | 'en_revision'>('publicada');

const MAX_COMENTARIO = 600;
const estrellaHover = ref(0);

const form = useForm({
    nombre: '',
    pais: 'pe',
    ciudad: '',
    institucion: '',
    curso: '',
    estrellas: 5,
    comentario: '',
    acepta_publicacion: false,
    sitio_web: '',
});

watch(
    () => props.abierto,
    (abierto) => {
        if (abierto) {
            enviada.value = false;
        }
    },
);

function enviar() {
    form.post(store.url(), {
        preserveScroll: true,
        preserveState: true,
        onFlash: (flash) => {
            resultado.value =
                flash.opinion === 'en_revision' ? 'en_revision' : 'publicada';
        },
        onSuccess: () => {
            enviada.value = true;
            form.reset();
        },
    });
}

const campo =
    'w-full rounded-xl border border-slate-200 bg-slate-50 p-4 text-sm transition-all outline-none focus:ring-2 focus:ring-avanzia-orange';
const etiqueta =
    'mb-2 block text-xs font-bold tracking-wide text-slate-500 uppercase';
</script>

<template>
    <ModalPublico :abierto="abierto" @cerrar="emit('cerrar')">
        <div
            class="relative w-full max-w-lg rounded-[2rem] bg-white p-8 shadow-2xl md:p-10"
        >
            <button
                type="button"
                aria-label="Cerrar"
                class="absolute top-6 right-6 flex size-8 items-center justify-center rounded-full bg-slate-100 text-slate-400 transition-colors hover:text-slate-800"
                @click="emit('cerrar')"
            >
                <X class="size-4" />
            </button>

            <div v-if="enviada" class="py-8 text-center">
                <CircleCheck class="mx-auto mb-4 size-14 text-green-500" />
                <h3 class="mb-2 text-3xl font-black text-slate-800">
                    ¡Gracias!
                </h3>
                <p v-if="resultado === 'publicada'" class="mb-8 text-slate-500">
                    Tu testimonio ya está publicado. Gracias por ayudar a otros
                    docentes a conocernos.
                </p>
                <p v-else class="mb-8 text-slate-500">
                    Recibimos tu testimonio. Lo revisaremos antes de publicarlo.
                </p>
                <button
                    type="button"
                    class="w-full rounded-2xl bg-avanzia-black py-4 text-lg font-black text-white shadow-xl transition-all hover:bg-slate-800"
                    @click="emit('cerrar')"
                >
                    Cerrar
                </button>
            </div>

            <template v-else>
                <h3 class="mb-2 text-3xl font-black text-slate-800">
                    Tu experiencia
                </h3>
                <p class="mb-8 text-sm font-medium text-slate-500">
                    Completa los campos para publicar tu opinión y ayudar a
                    otros docentes.
                </p>

                <form @submit.prevent="enviar">
                    <div class="space-y-5">
                        <div>
                            <label for="op-nombre" :class="etiqueta"
                                >Nombre Completo
                                <span class="text-red-500">*</span></label
                            >
                            <input
                                id="op-nombre"
                                v-model="form.nombre"
                                type="text"
                                required
                                minlength="3"
                                maxlength="80"
                                autocomplete="name"
                                placeholder="Ej. Ana Pérez"
                                :class="campo"
                            />
                            <p
                                v-if="form.errors.nombre"
                                class="mt-1 text-xs text-red-600"
                            >
                                {{ form.errors.nombre }}
                            </p>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-1/2">
                                <label for="op-pais" :class="etiqueta"
                                    >País
                                    <span class="text-red-500">*</span></label
                                >
                                <select
                                    id="op-pais"
                                    v-model="form.pais"
                                    required
                                    :class="[campo, 'cursor-pointer']"
                                >
                                    <option
                                        v-for="(nombre, codigo) in paises"
                                        :key="codigo"
                                        :value="codigo"
                                    >
                                        {{ nombre }}
                                    </option>
                                </select>
                            </div>
                            <div class="w-1/2">
                                <label for="op-ciudad" :class="etiqueta"
                                    >Ciudad
                                    <span class="text-red-500">*</span></label
                                >
                                <input
                                    id="op-ciudad"
                                    v-model="form.ciudad"
                                    type="text"
                                    required
                                    maxlength="60"
                                    placeholder="Ej. Lima"
                                    :class="campo"
                                />
                            </div>
                        </div>
                        <p
                            v-if="form.errors.pais || form.errors.ciudad"
                            class="-mt-3 text-xs text-red-600"
                        >
                            {{ form.errors.pais || form.errors.ciudad }}
                        </p>

                        <div>
                            <label for="op-institucion" :class="etiqueta"
                                >Institución (Opcional)</label
                            >
                            <input
                                id="op-institucion"
                                v-model="form.institucion"
                                type="text"
                                maxlength="100"
                                placeholder="Ej. Univ. Nacional"
                                :class="campo"
                            />
                            <p
                                v-if="form.errors.institucion"
                                class="mt-1 text-xs text-red-600"
                            >
                                {{ form.errors.institucion }}
                            </p>
                        </div>

                        <div>
                            <label for="op-curso" :class="etiqueta"
                                >Curso / Servicio Llevado
                                <span class="text-red-500">*</span></label
                            >
                            <select
                                id="op-curso"
                                v-model="form.curso"
                                required
                                :class="[campo, 'cursor-pointer']"
                            >
                                <option value="" disabled>
                                    Elige una opción
                                </option>
                                <option
                                    v-for="curso in cursos"
                                    :key="curso"
                                    :value="curso"
                                >
                                    {{ curso }}
                                </option>
                            </select>
                            <p
                                v-if="form.errors.curso"
                                class="mt-1 text-xs text-red-600"
                            >
                                {{ form.errors.curso }}
                            </p>
                        </div>

                        <div>
                            <span :class="etiqueta"
                                >Calificación
                                <span class="text-red-500">*</span></span
                            >
                            <div
                                class="flex gap-2"
                                role="radiogroup"
                                aria-label="Calificación"
                                @mouseleave="estrellaHover = 0"
                            >
                                <button
                                    v-for="n in 5"
                                    :key="n"
                                    type="button"
                                    role="radio"
                                    :aria-checked="form.estrellas === n"
                                    :aria-label="`${n} de 5`"
                                    class="transition-colors"
                                    :class="
                                        n <= (estrellaHover || form.estrellas)
                                            ? 'text-amber-400'
                                            : 'text-slate-200'
                                    "
                                    @mouseenter="estrellaHover = n"
                                    @click="form.estrellas = n"
                                >
                                    <Star class="size-8 fill-current" />
                                </button>
                            </div>
                        </div>

                        <div>
                            <label for="op-comentario" :class="etiqueta"
                                >Comentario
                                <span class="text-red-500">*</span></label
                            >
                            <textarea
                                id="op-comentario"
                                v-model="form.comentario"
                                required
                                rows="3"
                                minlength="15"
                                :maxlength="MAX_COMENTARIO"
                                placeholder="¿Cómo te ha ayudado la IA en tu labor docente?"
                                :class="[campo, 'resize-none']"
                            />
                            <div
                                class="mt-1 flex justify-between gap-3 text-xs"
                            >
                                <p
                                    v-if="form.errors.comentario"
                                    class="text-red-600"
                                >
                                    {{ form.errors.comentario }}
                                </p>
                                <span class="ml-auto shrink-0 text-slate-400"
                                    >{{ form.comentario.length }}/{{
                                        MAX_COMENTARIO
                                    }}</span
                                >
                            </div>
                        </div>

                        <!-- Trampa para bots: oculta para las personas -->
                        <div class="hidden" aria-hidden="true">
                            <label for="op-sitio">Sitio web</label>
                            <input
                                id="op-sitio"
                                v-model="form.sitio_web"
                                type="text"
                                tabindex="-1"
                                autocomplete="off"
                            />
                        </div>

                        <label
                            class="flex items-start gap-3 text-xs text-slate-500"
                        >
                            <input
                                v-model="form.acepta_publicacion"
                                type="checkbox"
                                required
                                class="mt-0.5 size-4 accent-avanzia-orange"
                            />
                            <span
                                >Autorizo a Avanzia a publicar mi nombre,
                                ciudad, institución y comentario en su sitio
                                web.</span
                            >
                        </label>
                        <p
                            v-if="form.errors.acepta_publicacion"
                            class="-mt-3 text-xs text-red-600"
                        >
                            {{ form.errors.acepta_publicacion }}
                        </p>
                    </div>

                    <button
                        type="submit"
                        class="mt-8 w-full rounded-2xl bg-avanzia-black py-4 text-lg font-black text-white shadow-xl transition-all hover:-translate-y-1 hover:bg-slate-800 disabled:opacity-60"
                        :disabled="form.processing"
                    >
                        {{ form.processing ? 'Enviando…' : 'Publicar Reseña' }}
                    </button>
                </form>
            </template>
        </div>
    </ModalPublico>
</template>
