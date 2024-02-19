import { defineConfig } from 'vite'

export default defineConfig({
	root: 'assets',
	build: {
		outDir: 'build',
		manifest: true,
		rollupOptions: {
			input: 'assets/src/main.ts',
		},
	},
});

