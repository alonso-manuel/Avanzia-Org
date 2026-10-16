<script setup lang="ts">
// Layout de la zona pública (landing, catálogo, validación de certificados).
import { usePage } from '@inertiajs/vue3';
import { computed, nextTick, onBeforeUnmount, onMounted } from 'vue';
import CarritoPanel from '@/components/public/CarritoPanel.vue';
import ConveniosSection from '@/components/public/ConveniosSection.vue';
import SiteFooter from '@/components/public/SiteFooter.vue';
import SiteHeader from '@/components/public/SiteHeader.vue';
import WhatsAppButton from '@/components/public/WhatsAppButton.vue';
import { iniciarCarrito } from '@/lib/public/carrito';
import type { ConvenioLanding } from '@/types';

// Compartidos por el middleware CompartirDatosPublicos en todas las rutas públicas
const page = usePage();
const convenios = computed(
    () => (page.props.convenios as ConvenioLanding[] | undefined) ?? [],
);

onMounted(async () => {
    document.documentElement.style.scrollBehavior = 'smooth';
    iniciarCarrito();

    // El navegador intenta ir al ancla (/#cursos) antes de que Vue pinte la página
    if (window.location.hash) {
        await nextTick();
        document
            .getElementById(decodeURIComponent(window.location.hash.slice(1)))
            ?.scrollIntoView({ behavior: 'instant' });
    }
});

onBeforeUnmount(() => {
    document.documentElement.style.scrollBehavior = '';
});
</script>

<template>
    <!-- La landing siempre es clara: no hereda el modo oscuro del panel -->
    <div
        class="relative isolate flex min-h-screen flex-col overflow-x-clip bg-slate-50 font-landing text-slate-800 antialiased"
    >
        <!-- Marca de agua global -->
        <div
            aria-hidden="true"
            class="pointer-events-none fixed inset-0 -z-10 bg-[url('/images/logo-avanzia.png')] bg-[length:50%] bg-center bg-no-repeat opacity-5"
        />

        <SiteHeader />

        <main class="flex-1">
            <slot />
        </main>

        <!-- Contacto, respaldo institucional y libro de reclamaciones: en todas las páginas -->
        <ConveniosSection
            :convenios="convenios"
            :modo="
                page.component === 'public/Convenios' ? 'enlaces' : 'respaldo'
            "
        />
        <SiteFooter />
        <WhatsAppButton />
        <!-- Carrito: el layout es persistente, así que se mantiene al navegar entre páginas -->
        <CarritoPanel />
    </div>
</template>
