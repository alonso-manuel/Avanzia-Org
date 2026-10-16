<script setup lang="ts">
import { X } from '@lucide/vue';
import ModalPublico from '@/components/public/ModalPublico.vue';
import { whatsapp } from '@/lib/public/contacto';
import type { CursoLanding } from '@/types';

defineProps<{ curso: CursoLanding | null }>();

const emit = defineEmits<{ cerrar: [] }>();
</script>

<template>
    <ModalPublico
        :abierto="curso !== null"
        fondo="bg-slate-900/90"
        @cerrar="emit('cerrar')"
    >
        <div
            v-if="curso"
            class="relative flex w-full max-w-5xl flex-col rounded-[2rem] bg-white p-2 shadow-2xl"
        >
            <button
                type="button"
                aria-label="Cerrar temario"
                class="absolute -top-4 -right-4 z-10 flex size-12 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-800 shadow-lg transition-colors hover:text-avanzia-orange"
                @click="emit('cerrar')"
            >
                <X class="size-5" />
            </button>
            <div class="border-b border-slate-100 p-6 pb-4">
                <h3 class="pr-6 text-2xl font-black text-slate-800">
                    {{ curso.titulo }}
                </h3>
            </div>
            <div
                class="flex min-h-[400px] w-full items-center justify-center overflow-hidden rounded-b-[1.5rem] bg-slate-100"
            >
                <img
                    v-if="curso.temarioImagen"
                    :src="curso.temarioImagen"
                    :alt="`Temario de ${curso.titulo}`"
                    class="h-auto max-h-[70vh] w-full object-contain"
                />
                <div v-else class="max-w-md p-10 text-center">
                    <p class="mb-6 text-lg font-medium text-slate-600">
                        Estamos preparando el temario detallado de este curso.
                        Escríbenos y te lo enviamos al instante.
                    </p>
                    <a
                        :href="
                            whatsapp(
                                `Hola, quiero el temario del curso «${curso.titulo}».`,
                            )
                        "
                        target="_blank"
                        rel="noopener"
                        class="inline-block rounded-xl bg-avanzia-orange px-8 py-3 font-black text-white shadow-md transition-colors hover:bg-avanzia-orange-dark"
                    >
                        Pedir temario por WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </ModalPublico>
</template>
