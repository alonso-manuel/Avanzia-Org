<script setup lang="ts">
import { ArrowRight } from '@lucide/vue';
import EncabezadoPagina from '@/components/public/EncabezadoPagina.vue';
import SeoHead from '@/components/public/SeoHead.vue';
import { vReveal } from '@/lib/public/reveal';
import type { Seo } from '@/types';

defineProps<{
    seo: Seo;
    titulo: string;
}>();
</script>

<!-- Documento legal: el texto va en el slot, con estilos para h2, p y ul -->
<template>
    <SeoHead :seo="seo" />

    <EncabezadoPagina antetitulo="Transparencia" :titulo="titulo" />

    <section class="px-4 pb-24">
        <article
            v-reveal
            class="documento mx-auto max-w-3xl rounded-[2rem] border border-slate-100 bg-white p-8 text-[17px] leading-[1.75] text-slate-600 shadow-sm md:p-12"
        >
            <slot />
        </article>

        <div class="mt-12 text-center">
            <a
                href="/#cursos"
                class="inline-flex items-center gap-2 rounded-full bg-avanzia-orange px-8 py-3.5 font-bold text-white shadow-lg shadow-avanzia-orange/30 transition-all hover:-translate-y-0.5 hover:bg-avanzia-orange-dark"
            >
                Quiero capacitarme <ArrowRight class="size-4" />
            </a>
        </div>
    </section>
</template>

<style scoped>
.documento :slotted(h2) {
    margin: 2.25rem 0 0.75rem;
    font-family: var(--font-titular);
    font-size: 1.375rem;
    font-weight: 600;
    line-height: 1.3;
    color: var(--color-avanzia-ink);
}

.documento :slotted(h2:first-child) {
    margin-top: 0;
}

.documento :slotted(p + p),
.documento :slotted(ul + p),
.documento :slotted(ul) {
    margin-top: 1rem;
}

.documento :slotted(ul) {
    padding-left: 1.25rem;
    list-style: disc;
}

.documento :slotted(li + li) {
    margin-top: 0.5rem;
}

.documento :slotted(a) {
    color: var(--color-avanzia-ochre);
    text-decoration: underline;
    text-underline-offset: 3px;
}

.documento :slotted(strong) {
    color: var(--color-avanzia-ink);
}
</style>
