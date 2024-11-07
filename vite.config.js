import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/welcome.scss',
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/sass/table.scss',
            ],
            refresh: true,
        }),
    ],
});
