import './bootstrap';
import '../css/app.css';
import 'material-icons/iconfont/material-icons.css';
import 'izitoast/dist/css/iziToast.min.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { createPinia } from 'pinia';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import Store from './Store';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ 
            render: () => h(App, props),
            beforeMount() {
                const store = Store();
                store.fetchData();                
            } 
        });           
        app.use(createPinia())
            .use(plugin)
            .use(ZiggyVue)               
            .mount(el);
        return app
    },
    progress: {
        color: '#4B5563',
    },
});
