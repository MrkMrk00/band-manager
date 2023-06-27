import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import solidPlugin from 'vite-plugin-solid';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.ts', 'resources/js/pages/user.tsx'],
            refresh: true,
        }),
        solidPlugin(),
    ],
});
