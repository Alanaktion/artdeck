import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel([
            'resources/css/app.css',
            'resources/js/app.js',
        ]),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            'ziggy': 'vendor/tightenco/ziggy/dist/vue.es.js',
            'vue': 'vue/dist/vue.esm-bundler.js',
        }
    },
    optimizeDeps: {
        include: ["ziggy"],
    },
});
