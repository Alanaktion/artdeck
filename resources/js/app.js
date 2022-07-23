import './bootstrap';

import { createApp } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { i18nVue } from 'laravel-vue-i18n';

createApp({
    components: {
        ImageInput: () => import('./components/ImageInput.vue'),
        TagListEditor: () => import('./components/TagListEditor.vue'),
        MarkdownEditor: () => import('./components/MarkdownEditor.vue'),
    },
}).use(ZiggyVue, Ziggy).use(i18nVue).mount('#main');

import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();
