import { createInertiaApp } from '@inertiajs/vue3';
import { initializeTheme } from '@/composables/useAppearance';
import PublicLayout from '@/layouts/public/PublicLayout.vue';
import { initializeFlashToast } from '@/lib/flashToast';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

void createInertiaApp({
    title: (title) => {
        if (!title) {
            return appName;
        }

        // Los títulos SEO de las páginas públicas ya incluyen la marca
        return title.includes(appName) ? title : `${title} - ${appName}`;
    },
    // Por ahora solo existe la zona pública. Al agregar admin/ o instituto/, asignar su layout
    // por prefijo aquí (los del kit están en archivo/kit-admin/).
    // Las páginas de campaña ("¡Falta un paso!") van sin layout: sin menú ni pie que distraigan.
    layout: (name) =>
        name.startsWith('public/campana/') ? undefined : PublicLayout,
    withApp: (app) => {
        app.directive('focus', {
            mounted: (el: HTMLElement, shouldFocus) => {
                if (shouldFocus.value !== false) {
                    el.focus();
                }
            },
        });
    },
    progress: {
        color: '#4B5563',
    },
});

// This will set light / dark mode on page load...
initializeTheme();

// This will listen for flash toast data from the server...
initializeFlashToast();
