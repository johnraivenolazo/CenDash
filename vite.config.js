import { defineConfig } from 'vite';
import { resolve } from 'path';

export default defineConfig({
    // Root directory
    root: '.',

    // Public directory for static assets
    publicDir: 'public',

    // Build configuration
    build: {
        // Output directory
        outDir: 'dist',

        // Generate manifest for PHP asset loading
        manifest: true,

        // Rollup options
        rollupOptions: {
            // Multiple entry points
            input: {
                main: resolve(__dirname, 'index.html'),
                styles: resolve(__dirname, 'src/styles/scss/main.scss'),
                app: resolve(__dirname, 'src/main.js'),
            },
        },

        // Enable CSS code splitting
        cssCodeSplit: true,

        // Minify for production (use esbuild - faster and included)
        minify: 'esbuild',

        // Source maps for debugging
        sourcemap: true,
    },

    // Dev server configuration
    server: {
        port: 5173,
        strictPort: false,

        // Proxy configuration - forward /server/ to PHP server
        proxy: {
            '/server': {
                target: 'http://localhost:8000',
                changeOrigin: true,
            },
        },

        // CORS for PHP integration
        cors: true,

        // HMR
        hmr: {
            overlay: true,
        },

        // Watch options
        watch: {
            usePolling: false,
        },
    },

    // CSS options
    css: {
        devSourcemap: true,
    },

    // Resolve options
    resolve: {
        alias: {
            '@': resolve(__dirname, 'src'),
            '@assets': resolve(__dirname, 'public/assets'),
        },
    },
});
