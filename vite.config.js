import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.scss',
                'resources/js/app.js',
                'resources/js/campaigns/map.js'
            ],
            refresh: true,
        }),
    ],
    server: {
        hmr: {
            host: 'lp2.ddev.site',
            protocol: 'wss',
        },
    },
});
