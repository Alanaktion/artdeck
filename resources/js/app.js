require('./bootstrap');

import { createApp } from 'vue';
import ImageInput from './components/ImageInput.vue';
import MarkdownEditor from './components/MarkdownEditor.vue';

createApp({
    components: {
        ImageInput,
        MarkdownEditor,
    },
}).mount('#main');

import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();
