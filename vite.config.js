import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/role-dashboard.css',
                'resources/css/bc-template-dashboard.css',
                'resources/css/barangay_captain/bc-dashboard.css',
                'resources/css/barangay_captain/bc-requests.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
