require('./bootstrap');
require('./markdown-editor');

import { createApp } from 'vue';
import ImageInput from './components/ImageInput.vue';

createApp({
    components: {
        ImageInput,
    },
}).mount('#main');

import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();
