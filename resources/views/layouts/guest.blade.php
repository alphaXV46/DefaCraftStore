<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'DefaCraftStore') }} - @yield('title', 'Login')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/layouts-guest.css') }}">
    
    @stack('styles')
</head>
<body>
    <!-- Background Elements -->
    <div class="background-elements">
        <div class="bg-element bg-element-1"></div>
        <div class="bg-element bg-element-2"></div>
        <div class="bg-element bg-element-3"></div>
    </div>
    
    <div class="auth-container">
        
        
        <!-- Flash Messages -->
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show auth-alert" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show auth-alert" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        <!-- Auth Card -->
        <div class="auth-card">
            <div class="auth-card-header">
                <h2 class="auth-card-title">Selamat Datang</h2>
                <p class="auth-card-subtitle">Silakan masuk untuk melanjutkan</p>
            </div>
            <div class="auth-card-body">
                <!-- Form login akan ditambahkan di sini -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group-icon">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <div class="input-group-icon">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                    
                    <div class="form-extras">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Ingat Saya</label>
                        </div>
                        <a href="#" class="forgot-link">Lupa Kata Sandi?</a>
                    </div>
                    
                    <button type="submit" class="btn-submit">
                        Masuk
                    </button>
                </form>
                
                <div class="divider">
                    <span>Atau</span>
                </div>
                
                <div class="social-login">
                    <button class="btn-social">
                        <i class="fab fa-google"></i>
                        Google
                    </button>
                    <button class="btn-social">
                        <i class="fab fa-facebook"></i>
                        Facebook
                    </button>
                </div>
                
                <!-- Auth Footer - DIPERBAIKI -->
                <div class="auth-footer">
                    <p>Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
                </div>
            </div>
        </div>
        
        <!-- Back to Home -->
        <div class="back-home">
            <a href="{{ route('home') }}">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Beranda
            </a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>