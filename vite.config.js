import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import purge from 'vite-plugin-purgecss';

export default defineConfig(({ command, mode }) => {
    const env = loadEnv(mode, process.cwd(), '');
    
    // Deteksi jika APP_URL menggunakan ngrok
    const isNgrok = env.APP_URL && env.APP_URL.includes('ngrok');
    let hmrConfig = undefined;

    if (isNgrok) {
        try {
            const url = new URL(env.APP_URL);
            hmrConfig = {
                host: url.hostname,
                protocol: 'wss',
                clientPort: 443
            };
        } catch (e) {}
    }

    return {
        server: {
            host: '0.0.0.0',
            hmr: hmrConfig,
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
            
            // ✅ Hanya jalankan PurgeCSS saat build production (npm run build)
            // Di mode development (npm run dev), CSS dibiarkan utuh agar HMR lancar
            command === 'build' && purge({
                content: [
                    './resources/views/**/*.blade.php',
                    './resources/js/**/*.js',
                    './resources/js/**/*.vue', // Berjaga-jaga jika menggunakan Vue
                    // Jangan scan file CSS untuk 'content', karena CSS adalah yang akan di-purge, bukan sumber class
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
        ].filter(Boolean), // Filter nilai false/null dari array plugins
    };
});