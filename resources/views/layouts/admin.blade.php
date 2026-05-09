<!-- resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin - DefaCraftStore')</title>

    <!-- Bootstrap 5.3.3 CSS -->
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
            if (navbar && window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else if (navbar) {
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
