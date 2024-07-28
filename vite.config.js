import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        hmr: {
            host: '192.168.1.4',
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss', // Our new line you can change app.scss to whatever.scss
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
