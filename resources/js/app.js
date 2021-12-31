require('./bootstrap');

import { createApp } from 'vue';
import { ZiggyVue } from 'ziggy';
import { i18nVue } from 'laravel-vue-i18n';
import ImageInput from './components/ImageInput.vue';
import TagListEditor from './components/TagListEditor.vue';
import MarkdownEditor from './components/MarkdownEditor.vue';

createApp({
    components: {
        ImageInput,
        TagListEditor,
        MarkdownEditor,
    },
}).use(ZiggyVue, Ziggy).use(i18nVue).mount('#main');

import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();
