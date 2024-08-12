import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/role-dashboard.css',
                'resources/css/bc-template-dashboard.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
