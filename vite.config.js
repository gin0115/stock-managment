import { fileURLToPath, URL } from 'url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vitejs.dev/config/
export default defineConfig({
    plugins: [vue()],
    resolve: {
        alias: {
            '@': fileURLToPath(new URL('./js',
                import.meta.url)),
            'balm-ui-plus': 'balm-ui/dist/balm-ui-plus.esm.js',
            'balm-ui-css': 'balm-ui/dist/balm-ui.css'
        }
    },
    filenameHashing: false,
    build: {
        outDir: './build/js',
        manifest: true


    },
})