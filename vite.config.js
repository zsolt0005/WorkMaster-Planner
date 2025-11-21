import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import fg from 'fast-glob';

const jsPageEntries = fg.sync('resources/js/pages/**/*.js', { dot: false });
const cssPageEntries = fg.sync('resources/css/pages/**/*.css', { dot: false });

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                ...cssPageEntries,

                'resources/js/app.js',
                ...jsPageEntries,
            ],
            refresh: true,
        }),
    ],
});
