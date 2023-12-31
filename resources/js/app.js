// Import styles
import "./bootstrap";
import "../scss/app.scss";
import "vue-toastification/dist/index.css";

// Import js
import Toast from "vue-toastification";
import { createApp, h } from "vue";
import { createI18n } from "vue-i18n";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";

// Load pusher when filled in
if (import.meta.env.VITE_PUSHER_APP_KEY && import.meta.env.VITE_PUSHER_APP_CLUSTER) {
    // Inject Pusher
    window.Pusher = Pusher;

    // Setup Laravel Echo
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: import.meta.env.VITE_PUSHER_APP_KEY,
        cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
        forceTLS: true
    });
}

// Setup Vue i18n translations
const initialPage = JSON.parse(app.dataset.page);
const i18n = createI18n({
    locale: initialPage.props.locales.currentLocale,
    messages: initialPage.props.translations,
    legacy: false,
    warnHtmlMessage: false
});

// Setup toast options
const options = {
    transition: "Vue-Toastification__fade",
    maxToasts: 5,
    position: "bottom-right",
    timeout: 5000,
    container: document.querySelector('#app'),
    pauseOnFocusLoss: true,
    pauseOnHover: true,
    closeOnClick: true,
    closeButton: "button",
    icon: true,
    newestOnTop: true,
    draggable: true,
    draggablePercent: 0.6,
    showCloseButtonOnHover: false,
    rtl: false
};

createInertiaApp({
    title: (title) => {
        const appName = import.meta.env.VITE_APP_NAME;

        if (!title) {
            return appName;
        }

        return `${title} - ${appName}`;
    },
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(i18n)
            .use(Toast, options)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
