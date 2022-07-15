import { fileURLToPath, URL } from 'url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

module.exports = {
    publicPath: process.env.NODE_ENV === 'production' ?
        '/production-sub-path/' :
        '/'
}

// https://vitejs.dev/config/
export default defineConfig({
    plugins: [vue()],
    resolve: {
        alias: {
            '@': fileURLToPath(new URL('./js',
                import.meta.url))
        }
    },
    build: {
        outDir: './build/js'
    }
})