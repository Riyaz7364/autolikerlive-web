import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import viteCompression from 'vite-plugin-compression';
import { terser } from 'rollup-plugin-terser';
import commonjs from '@rollup/plugin-commonjs';
export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/js/game-app.js',
            ],
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
        viteCompression(),
    ],
    server: {
        // Add this configuration to support serving legacy JavaScript for development
        fs: {
            strict: false,
        },
    },
    build: {
        target: 'es2015',
        polyfillDynamicImport: false,
        minify: true,
        sourcemap: false,
        rollupOptions: {
            plugins: [
                commonjs(),
                terser({
                    compress: {
                        keep_infinity: true,
                        drop_console: true,
                    },
                    format: {
                        comments: false,
                    },
                }),
            ],
        },
    },
});
