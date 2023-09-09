import "@fortawesome/fontawesome-free/css/all.min.css";
import '@res/js/bootstrap';
import '@res/css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '@/vendor/tightenco/ziggy/dist/vue.m';

import CKEditor from '@ckeditor/ckeditor5-vue'
import Colors from 'tailwindcss/colors'

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`../vue/Pages/${name}.vue`, import.meta.glob('../vue/Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(CKEditor)
            .mount(el);
    },
    progress: {
        color: Colors.indigo[400],
        showSpinner: true
    },
});
