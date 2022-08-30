import './bootstrap';

import { createApp, defineAsyncComponent } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { i18nVue } from 'laravel-vue-i18n';

createApp({
    components: {
        ImageInput: defineAsyncComponent(() => import('./components/ImageInput.vue')),
        TagListEditor: defineAsyncComponent(() => import('./components/TagListEditor.vue')),
        TextEditor: defineAsyncComponent(() => import('./components/TextEditor.vue')),
    },
}).use(ZiggyVue, Ziggy).use(i18nVue).mount('#main');

import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();
