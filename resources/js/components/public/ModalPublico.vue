<script setup lang="ts">
import { onBeforeUnmount, watch } from 'vue';

const props = defineProps<{
    abierto: boolean;
    fondo?: string;
}>();

const emit = defineEmits<{ cerrar: [] }>();

const alPresionarTecla = (e: KeyboardEvent) => {
    if (e.key === 'Escape') {
        emit('cerrar');
    }
};

// Solo se ejecuta en el navegador: el modal arranca cerrado
watch(
    () => props.abierto,
    (abierto) => {
        if (abierto) {
            document.addEventListener('keydown', alPresionarTecla);
        } else {
            document.removeEventListener('keydown', alPresionarTecla);
        }
    },
);

onBeforeUnmount(() =>
    document.removeEventListener('keydown', alPresionarTecla),
);
</script>

<template>
    <Transition
        enter-from-class="opacity-0 [&>div]:scale-95"
        leave-to-class="opacity-0 [&>div]:scale-95"
        enter-active-class="transition-opacity duration-300 [&>div]:transition-transform [&>div]:duration-300"
        leave-active-class="transition-opacity duration-300 [&>div]:transition-transform [&>div]:duration-300"
    >
        <div
            v-if="abierto"
            class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto px-4 py-8 backdrop-blur-md"
            :class="fondo ?? 'bg-slate-900/80'"
            role="dialog"
            aria-modal="true"
            @click.self="emit('cerrar')"
        >
            <slot />
        </div>
    </Transition>
</template>
