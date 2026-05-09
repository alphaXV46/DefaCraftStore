<!-- resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin - DefaCraftStore')</title>

    <!-- Preconnect to external domains -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>

    <!-- Google Fonts Optimized (Non-blocking) -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" media="print" onload="this.media='all'">

    <!-- Preload WOFF2 Fonts from Vite Manifest -->
    @php
        $manifestPath = public_path('build/manifest.json');
        if (file_exists($manifestPath)) {
            $manifest = json_decode(file_get_contents($manifestPath), true);
            foreach ($manifest as $key => $asset) {
                if (isset($asset['file']) && str_ends_with($asset['file'], '.woff2')) {
                    echo '<link rel="preload" href="/build/' . $asset['file'] . '" as="font" type="font/woff2" crossorigin>' . "\n    ";
                }
            }
        }
    @endphp

    <!-- Vite Assets (Core/Critical) includes Bootstrap & FontAwesome -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Deferred Non-Critical CSS -->
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/partials-header.css') }}" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/partials-footer.css') }}" media="print" onload="this.media='all'">

    <!-- Stack untuk CSS khusus per halaman -->
    @stack('styles')
</head>
<body>

    @include('partials.header')

    <!-- Flash Messages Modern -->
    @if(session('success'))
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show slide-in-right" role="alert">
                <strong>✓ Berhasil!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show slide-in-right" role="alert">
                <strong>✗ Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <!-- Toast Container -->
    <div id="toastContainer" class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999;"></div>



    <!-- Global Scripts -->
    <script>
        // Navbar scroll effect (Optimized to prevent forced reflow)
        let isScrolled = false;
        let ticking = false;
        const navbar = document.querySelector('.navbar-modern');
        
        window.addEventListener('scroll', function() {
            if (!navbar) return;
            
            if (!ticking) {
                window.requestAnimationFrame(function() {
                    const currentScrollY = window.scrollY; // DOM Read phase
                    
                    // DOM Write phase
                    if (currentScrollY > 50) {
                        if (!isScrolled) {
                            navbar.classList.add('scrolled');
                            isScrolled = true;
                        }
                    } else {
                        if (isScrolled) {
                            navbar.classList.remove('scrolled');
                            isScrolled = false;
                        }
                    }
                    ticking = false;
                });
                ticking = true;
            }
        }, { passive: true });

        // Auto dismiss alerts
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Toast Notification
        function showToast(message, type = 'success') {
            const toastContainer = document.getElementById('toastContainer');
            if (!toastContainer) return;
            const toastElement = document.createElement('div');
            toastElement.className = `toast align-items-center text-white bg-${type} border-0`;
            toastElement.setAttribute('role', 'alert');
            toastElement.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            `;
            toastContainer.appendChild(toastElement);
            const bsToast = new bootstrap.Toast(toastElement, { autohide: true, delay: 3000 });
            bsToast.show();
            toastElement.addEventListener('hidden.bs.toast', function () {
                toastElement.remove();
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
