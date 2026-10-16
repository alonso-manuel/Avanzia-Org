<script setup lang="ts">
import { ref } from 'vue';
import AlianzaBanner from '@/components/public/AlianzaBanner.vue';
import BarraRespaldo from '@/components/public/BarraRespaldo.vue';
import CatalogoCursos from '@/components/public/CatalogoCursos.vue';
import EducacionAsincronica from '@/components/public/EducacionAsincronica.vue';
import HeroSection from '@/components/public/HeroSection.vue';
import OpinionesSection from '@/components/public/OpinionesSection.vue';
import OpinionModal from '@/components/public/OpinionModal.vue';
import SeoHead from '@/components/public/SeoHead.vue';
import StudioSection from '@/components/public/StudioSection.vue';
import TemarioModal from '@/components/public/TemarioModal.vue';
import type {
    CategoriaLanding,
    CursoLanding,
    EstadisticasOpiniones,
    OpinionLanding,
    Seo,
} from '@/types';

defineProps<{
    seo: Seo;
    cursos: CursoLanding[];
    categorias: CategoriaLanding[];
    opiniones: OpinionLanding[];
    estadisticas: EstadisticasOpiniones;
    paises: Record<string, string>;
    cursosOpinion: string[];
    umbralInteresados: number;
}>();

// Los modales se montan aquí, fuera de las secciones con blur/transform
const cursoTemario = ref<CursoLanding | null>(null);
const opinando = ref(false);
</script>

<template>
    <SeoHead :seo="seo" />

    <HeroSection />
    <BarraRespaldo />
    <StudioSection />
    <CatalogoCursos
        :cursos="cursos"
        :categorias="categorias"
        :umbral-interesados="umbralInteresados"
        @ver-temario="cursoTemario = $event"
    />
    <EducacionAsincronica />
    <OpinionesSection
        :opiniones="opiniones"
        :estadisticas="estadisticas"
        :pausado="opinando"
        @opinar="opinando = true"
    />
    <AlianzaBanner />

    <TemarioModal :curso="cursoTemario" @cerrar="cursoTemario = null" />
    <OpinionModal
        :abierto="opinando"
        :cursos="cursosOpinion"
        :paises="paises"
        @cerrar="opinando = false"
    />
</template>
