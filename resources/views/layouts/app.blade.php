<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="DefaCraftStore - Pusat kerajinan tangan handmade, boneka rajut, aksesoris unik, dan dekorasi rumah berkualitas terbaik.">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DefaCraftStore - Kerajinan Tangan Modern')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" media="print" onload="this.media='all'">

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

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="{{ Vite::asset('resources/css/partials-header.css') }}" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/partials-footer.css') }}" media="print" onload="this.media='all'">

    @stack('styles')
</head>
<body>

    @include('partials.header')

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

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <div id="toastContainer" class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999;"></div>

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

        // Toggle Wishlist (Global Function) - DIPERBARUI
        function toggleWishlist(produkId, buttonElement) {
            // Cek apakah user guest
            @auth
                // Ambil token CSRF dari meta tag
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Tampilkan loading sementara
                const span = buttonElement.querySelector('span');
                const originalIcon = span.textContent; // Simpan ikon asli
                span.textContent = '⏳'; // Ikon loading

                // Kirim permintaan POST ke rute yang benar
                fetch('{{ route('wishlist.toggle') }}', { // Gunakan route helper
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest', // Opsional
                        'X-CSRF-TOKEN': csrfToken // Gunakan token dari meta tag
                    },
                    body: JSON.stringify({
                        produk_id: produkId // Kirim ID produk dalam body JSON
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        // Tangani error HTTP (4xx, 5xx)
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    // Kembalikan ikon loading ke status baru setelah respons
                    if (data.status === 'added') {
                        span.textContent = '❤️'; // Ikon sudah ada di wishlist
                        showToast(data.message || 'Ditambahkan ke Wishlist!', 'success');
                    } else if (data.status === 'removed') {
                        span.textContent = '🤍'; // Ikon belum ada di wishlist
                        showToast(data.message || 'Dihapus dari Wishlist!', 'info');
                    } else {
                        // Jika status tidak dikenal
                        span.textContent = originalIcon; // Kembalikan ke sebelumnya
                        showToast(data.message || 'Status tak terduga.', 'warning');
                    }
                })
                .catch(error => {
                    console.error('Error toggling wishlist:', error);
                    // Kembalikan ikon ke sebelumnya jika error
                    span.textContent = originalIcon;
                    showToast('Gagal memperbarui wishlist. Silakan coba lagi.', 'danger');
                });
            @else
                // Jika user guest, redirect ke login
                alert('Silakan login terlebih dahulu untuk menambahkan ke wishlist.');
                window.location.href = "{{ route('login') }}";
            @endauth
        }

        // Toast Notification
        function showToast(message, type = 'success') {
            const toastContainer = document.getElementById('toastContainer');
            if (!toastContainer) {
                console.error('Toast container not found!');
                return;
            }

            // Buat elemen toast
            const toastElement = document.createElement('div');
            toastElement.className = `toast align-items-center text-white bg-${type} border-0`;
            toastElement.setAttribute('role', 'alert');
            toastElement.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            `;

            // Tambahkan ke container
            toastContainer.appendChild(toastElement);

            // Inisialisasi dan tampilkan toast
            const bsToast = new bootstrap.Toast(toastElement, {
                autohide: true,
                delay: 3000
            });
            bsToast.show();

            // Hapus elemen dari DOM setelah toast ditutup
            toastElement.addEventListener('hidden.bs.toast', function () {
                toastElement.remove();
            });
        }

        // 🔴 SKRIP OTOMATIS: NYELIPIN MENU DASHBOARD ADMIN DI DROPDOWN PROFILE DIMAS 🔴
        document.addEventListener("DOMContentLoaded", function() {
            @auth
                @if(auth()->user()->role == 'admin' || auth()->user()->role == 'superadmin')
                    // Cari semua elemen link/menu di halaman yang punya teks "Kelola Admin"
                    const links = document.querySelectorAll('a.dropdown-item');
                    let targetLink = null;
                    
                    links.forEach(link => {
                        if (link.textContent.includes('Kelola Admin')) {
                            targetLink = link;
                        }
                    });
                    
                    // Kalau ketemu menu Kelola Admin, kita selipin menu Dashboard Admin tepat di atasnya
                    if (targetLink) {
                        const newMenu = document.createElement('a');
                        newMenu.className = 'dropdown-item d-flex align-items-center py-2';
                        newMenu.href = "{{ route('admin.dashboard') }}";
                        newMenu.style.color = '#4A2E80';
                        newMenu.style.fontWeight = '600';
                        newMenu.innerHTML = '<i class="fas fa-fw fa-tachometer-alt me-2 text-secondary"></i> Dashboard Admin';
                        
                        // Eksekusi taruh di atasnya
                        targetLink.parentNode.insertBefore(newMenu, targetLink);
                    }
                @endif
            @endauth
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    @include('partials.header') @stack('scripts')
</body>
</html>