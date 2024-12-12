import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/admin.css',
                'resources/css/guest.css',
                'resources/js/admin.js',
                'resources/js/guest.js',
            ],
            refresh: false,
        }),
    ],
});
