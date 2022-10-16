import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/adjuta_ducument.css',
                'resources/js/app.js',
                'resources/js/adjuntar_document.js',
                'resources/js/estado.js',
            ],
            refresh: true,
        }),
    ],
});