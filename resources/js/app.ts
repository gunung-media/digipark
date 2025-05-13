import './bootstrap';
import '../css/app.css';
import '../css/tailwind.css';
import 'vue3-toastify/dist/index.css';
import '@programic/vue3-tooltip/dist/index.css';

import { createApp, h, DefineComponent } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/src/js/vue';
import Vue3Toastify, { type ToastContainerOptions } from 'vue3-toastify';
import Tooltip from '@programic/vue3-tooltip';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(Vue3Toastify, {
                autoClose: 3000,
            } as ToastContainerOptions)
            .use(Tooltip, {
            })
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
