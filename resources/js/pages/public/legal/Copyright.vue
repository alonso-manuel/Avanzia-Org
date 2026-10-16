<script setup lang="ts">
import PaginaLegal from '@/components/public/PaginaLegal.vue';
import type { Seo } from '@/types';

defineProps<{ seo: Seo }>();
</script>

<!-- Texto tomado del sitio anterior (avanzia.org/copyright) -->
<template>
    <PaginaLegal :seo="seo" titulo="Copyright">
        <p>
            Este sitio web y su contenido son propiedad de Avanzia América
            Latina – © Avanzia América Latina 2025. Todos los derechos
            reservados.
        </p>
        <p>
            Cualquier redistribución o reproducción de parte o de la totalidad
            del contenido en cualquier forma está prohibida, salvo en los
            siguientes casos:
        </p>
        <ul>
            <li>
                Puedes imprimir o descargar extractos a un disco duro local para
                tu uso personal y no comercial únicamente.
            </li>
            <li>
                Puedes copiar el contenido a terceros individuales para su uso
                personal, pero solo si reconoces el sitio web como la fuente del
                material.
            </li>
        </ul>
        <p>
            No puedes, excepto con nuestro permiso expreso por escrito,
            distribuir o explotar comercialmente el contenido. Tampoco puedes
            transmitirlo o almacenarlo en cualquier otro sitio web u otro
            sistema de recuperación electrónica.
        </p>
    </PaginaLegal>
</template>
