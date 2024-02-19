import { defineConfig } from 'vite';
import solidPlugin from 'vite-plugin-solid';

export default defineConfig({
    plugins: [solidPlugin()],
    root: 'assets',
    build: {
        outDir: 'build',
        manifest: true,
        rollupOptions: {
            input: 'assets/main.ts',
        },
    },
});
