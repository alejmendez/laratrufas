import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
            '@Users': path.resolve(__dirname, './Modules/Users/Resources'),
            '@Tasks': path.resolve(__dirname, './Modules/Tasks/Resources'),
            '@Dashboard': path.resolve(__dirname, './Modules/Dashboard/Resources'),
            '@Core': path.resolve(__dirname, './Modules/Core/Resources'),
            '@Fields': path.resolve(__dirname, './Modules/Fields/Resources'),
            'ziggy-js': path.resolve(__dirname, './vendor/tightenco/ziggy'),
        },
    },
});
