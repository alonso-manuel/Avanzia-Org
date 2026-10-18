<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import type { Seo } from '@/types';

defineProps<{ seo: Seo }>();
</script>

<!-- Mantiene título y metadatos al navegar entre páginas sin recargar; la primera carga los escribe app.blade.php -->
<template>
    <Head :title="seo.title">
        <meta
            head-key="description"
            name="description"
            :content="seo.description"
        />
        <meta head-key="og:title" property="og:title" :content="seo.title" />
        <meta
            head-key="og:description"
            property="og:description"
            :content="seo.description"
        />
        <meta head-key="og:url" property="og:url" :content="seo.url" />
        <meta head-key="og:image" property="og:image" :content="seo.image" />
        <meta
            v-if="!seo.indexar"
            head-key="robots"
            name="robots"
            content="noindex, nofollow"
        />
    </Head>
</template>
