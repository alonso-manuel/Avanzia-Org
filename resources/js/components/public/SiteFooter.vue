<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { RAZON_SOCIAL, RUC, RUTAS_LEGALES } from '@/lib/public/contacto';

const enlaces = [
    { texto: 'Copyright', href: RUTAS_LEGALES.copyright },
    { texto: 'Descargo de Responsabilidad', href: RUTAS_LEGALES.descargo },
    { texto: 'Validación', href: RUTAS_LEGALES.validacion },
    { texto: 'Política de Privacidad', href: RUTAS_LEGALES.privacidad },
    { texto: 'Términos y Condiciones', href: RUTAS_LEGALES.terminos },
];
</script>

<template>
    <footer
        class="relative z-30 flex flex-col items-center justify-center bg-avanzia-navy px-4 py-12 text-center"
    >
        <div
            class="mb-8 flex flex-col gap-1 text-[13px] leading-relaxed font-medium text-slate-400"
        >
            <p>
                Creado y administrado por
                <span class="font-black text-slate-200">{{
                    RAZON_SOCIAL
                }}</span>
            </p>
            <p>RUC {{ RUC }}</p>
            <p>Todos los derechos reservados ®</p>
        </div>
        <div
            class="flex flex-wrap items-center justify-center gap-x-6 gap-y-4 text-[11px] font-black tracking-widest text-slate-500 uppercase"
        >
            <template v-for="(enlace, i) in enlaces" :key="enlace.texto">
                <span v-if="i > 0" class="hidden text-slate-700 sm:inline"
                    >|</span
                >
                <Link
                    :href="enlace.href"
                    class="transition-colors hover:text-avanzia-orange"
                    >{{ enlace.texto }}</Link
                >
            </template>
        </div>
    </footer>
</template>
