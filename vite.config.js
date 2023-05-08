import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from "path";

export default defineConfig({
    plugins: [
        laravel({
            input: 'web/app/app.ts',
            publicDirectory: 'web',
        }),
        vue()
    ],
    resolve: {
        extensions: [
            ".mjs",
            ".js",
            ".ts",
            ".jsx",
            ".tsx",
            ".json",
            ".vue",
            ".scss",
        ],
        alias: {
            "@": path.resolve(__dirname, "./web/app"),
        },
    },
    esbuild: {
        target:"es2018",
    }
});