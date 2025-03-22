import { router } from "@inertiajs/vue3";
import 'bootstrap/dist/css/bootstrap.css';
import "./bootstrap";
import './Assets/css/main.css'
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import NProgress from "nprogress";
import Vue3EasyDataTable from "vue3-easy-data-table";
import "vue3-easy-data-table/dist/style.css";

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        return pages[`./Pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });
        app.use(plugin);
        app.component("EasyDataTable", Vue3EasyDataTable);
        app.mount(el);
    },
});

router.on("start", () => {
    NProgress.start();
});
router.on("finish", () => {
    NProgress.done();
});
