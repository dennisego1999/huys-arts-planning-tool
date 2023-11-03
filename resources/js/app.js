import './bootstrap';
import '../scss/app.scss';

import { createApp, h } from 'vue';
import { createI18n } from 'vue-i18n'
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

//Setup Vue i18n translations
const initialPage = JSON.parse(app.dataset.page);
const i18n = createI18n({
    locale: initialPage.props.locales.currentLocale,
    messages: initialPage.props.translations,
    legacy: false,
    warnHtmlMessage: false
});

createInertiaApp({
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(i18n)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
