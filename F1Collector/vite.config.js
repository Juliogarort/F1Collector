import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js', // <--- ¡Este es el fix importante!
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/js/modalAuth.js',
                'resources/js/profileModal.js',
            ],
            refresh: true,
        }),
        vue(), // <--- Añade el plugin de Vue aquí
    ],
});
