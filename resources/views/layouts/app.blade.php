<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- PASTIKAN META TAG CSRF ADA -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DefaCraftStore - Kerajinan Tangan Modern')</title>

    <!-- Bootstrap 5.3.8 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Modern CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

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

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Global Scripts -->
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

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
    </script>

    @stack('scripts')
</body>
</html>