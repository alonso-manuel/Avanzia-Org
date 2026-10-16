<script setup lang="ts">
import { vReveal } from '@/lib/public/reveal';
</script>

<template>
    <section
        v-reveal
        class="relative bg-gradient-to-br from-avanzia-purple/10 to-transparent px-4 py-24"
    >
        <div class="mx-auto max-w-5xl text-center">
            <div
                class="mb-6 inline-block rounded-full bg-avanzia-purple px-4 py-1.5 text-xs font-black tracking-widest text-white uppercase shadow-md transition-transform hover:scale-105"
            >
                Avanzia Flex
            </div>
            <h2
                class="mb-8 text-4xl font-black tracking-tighter text-slate-900 md:text-6xl"
            >
                Educación continua asincrónica.
            </h2>
            <p class="mx-auto max-w-3xl text-xl leading-relaxed text-slate-600">
                Estudia a tu propio ritmo con una lectura amigable y formal.
                Obtén acceso ilimitado a grabaciones de alta calidad, materiales
                descargables y evaluaciones automatizadas para certificar tus
                conocimientos sin depender de horarios fijos.
            </p>
        </div>
    </section>
</template>
