<script setup lang="ts">
import { vReveal } from '@/lib/public/reveal';

// Avatares decorativos de la plantilla; reemplazar por fotos reales con permiso
const avatares = [1, 5, 9, 12].map((n) => `https://i.pravatar.cc/100?img=${n}`);
</script>

<template>
    <div
        v-reveal
        class="w-full bg-gradient-to-r from-avanzia-purple to-avanzia-purple-dark py-5 text-white shadow-inner"
    >
        <div
            class="mx-auto flex max-w-7xl items-center justify-center gap-6 px-4 text-center"
        >
            <div class="hidden -space-x-4 opacity-95 sm:flex">
                <img
                    v-for="avatar in avatares"
                    :key="avatar"
                    :src="avatar"
                    alt=""
                    width="40"
                    height="40"
                    loading="lazy"
                    class="size-10 rounded-full border-2 border-avanzia-purple-dark transition-transform hover:-translate-y-1"
                />
            </div>
            <p class="font-bold tracking-wide md:text-xl">
                Respaldado por más de
                <span class="animate-pulse text-2xl font-black text-amber-300"
                    >2000 docentes</span
                >
                a nivel internacional.
            </p>
        </div>
    </div>
</template>
