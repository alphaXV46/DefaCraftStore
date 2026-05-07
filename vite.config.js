import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: '0.0.0.0',
        hmr: {
            // Ganti ini dengan alamat ngrok yang Anda dapatkan
            host: 'https://christen-nondeafened-empirically.ngrok-free.dev', 
        },
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});