import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/scss/styles.scss',
                'resources/libs/jquery/dist/jquery.min.js',
                'resources/libs/bootstrap/dist/js/bootstrap.bundle.min.js',
                'resources/js/dashboard.js',
                'resources/js/main.js',
                'resources/libs/apexcharts/dist/apexcharts.min.js',
                'resources/libs/simplebar/dist/simplebar.js',
            ],
            refresh: true,
        }),
    ],
});
