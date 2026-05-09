import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import purge from 'vite-plugin-purgecss';

export default defineConfig({
    server: {
        host: '0.0.0.0',
        hmr: {
            host: 'christen-nondeafened-empirically.ngrok-free.dev', 
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/css/partials-header.css',
                'resources/css/partials-footer.css',
                'resources/css/home.css',
                'resources/css/produk-show.css',
                'resources/css/profile-edit.css',
                'resources/css/keranjang-index.css',
                'resources/css/transaksi-checkout.css',
                'resources/css/transaksi-riwayat.css',
                'resources/css/transaksi-show.css',
                'resources/css/transaksi-success.css',
                'resources/css/layouts-auth.css',
                'resources/css/admin-dashboard.css',
                'resources/css/admin-transaksi-show.css'
            ],
            refresh: true,
        }),
        purge({
            content: [
                './resources/views/**/*.blade.php',
                './resources/js/**/*.js',
                './resources/css/**/*.css'
            ],
            safelist: {
                standard: [
                    'html', 'body', 'show', 'active', 'collapsing', 'fade', 
                    'modal-backdrop', 'scrolled', 'navbar-modern', 'animate'
                ],
                greedy: [
                    /^nav-/, /^btn-/, /^alert-/, /^modal-/, /^toast-/, 
                    /^card-/, /^badge-/, /^fa-/
                ]
            }
        }),
    ],
});