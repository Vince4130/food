import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/js/chart-custom.js',
                'resources/js/just-gage-custom.js',
            ],
            refresh: true,
        }),
    ],
});
