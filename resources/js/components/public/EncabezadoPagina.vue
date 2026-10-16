<script setup lang="ts">
defineProps<{
    titulo: string;
    antetitulo?: string;
    bajada?: string;
}>();
</script>

<!-- Cabecera de las páginas internas; deja espacio para el header fijo -->
<template>
    <!-- Sin overflow-hidden: el resplandor se desvanece sin cortes (el layout ya recorta el desborde horizontal) -->
    <header class="relative isolate px-4 pt-40 pb-12 text-center">
        <div
            aria-hidden="true"
            class="absolute top-16 left-1/2 -z-10 h-72 w-[min(900px,100%)] -translate-x-1/2 rounded-full bg-gradient-to-r from-avanzia-orange/15 via-avanzia-cream/40 to-avanzia-purple/15 blur-3xl"
        />
        <p
            v-if="antetitulo"
            class="mb-3 font-manuscrita text-[26px] leading-none font-bold text-avanzia-ochre"
        >
            {{ antetitulo }}
        </p>
        <h1
            class="mx-auto max-w-4xl font-titular text-4xl leading-[1.1] font-extrabold tracking-tight text-avanzia-ink md:text-5xl lg:text-6xl"
        >
            {{ titulo }}
        </h1>
        <p
            v-if="bajada"
            class="mx-auto mt-6 max-w-2xl text-lg leading-relaxed text-slate-600"
        >
            {{ bajada }}
        </p>
    </header>
</template>
