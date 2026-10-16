<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Handshake } from '@lucide/vue';
import { RUTAS_LEGALES } from '@/lib/public/contacto';
</script>

<template>
    <section
        class="relative z-10 flex justify-center border-b border-slate-100 bg-white px-4 py-10"
    >
        <div
            class="flex w-full max-w-5xl flex-col items-center justify-between gap-6 rounded-[2rem] border border-slate-100 bg-slate-50/50 px-8 py-4 md:flex-row md:rounded-full"
        >
            <div class="flex items-center gap-4 text-slate-700">
                <div
                    class="flex size-12 shrink-0 items-center justify-center rounded-full bg-avanzia-purple/10 text-avanzia-purple"
                >
                    <Handshake class="size-6" />
                </div>
                <div>
                    <h4 class="text-base font-semibold">
                        ¿Representas a una institución educativa?
                    </h4>
                    <p class="text-xs text-slate-500">
                        Conversemos sobre cómo potenciar a tu plana docente.
                    </p>
                </div>
            </div>
            <!-- Abre directamente el formulario de la página de convenios -->
            <Link
                :href="`${RUTAS_LEGALES.convenios}?solicitar=1`"
                class="flex items-center gap-2 rounded-full border border-slate-200 bg-white px-8 py-3 text-sm font-medium text-slate-700 shadow-sm transition-all hover:border-avanzia-purple hover:text-avanzia-purple"
            >
                Establecer Alianza Estratégica
            </Link>
        </div>
    </section>
</template>
