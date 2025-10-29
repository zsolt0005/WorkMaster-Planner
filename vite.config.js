import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import fg from 'fast-glob';

const pageEntries = fg.sync('resources/js/pages/**/*.js', { dot: false });

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                ...pageEntries,
            ],
            refresh: true,
        }),
    ],
});
