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
    
    <style>
        /* Auth Layout Specific Styles */
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            min-height: 100vh;
            padding: 2rem 0;
            position: relative;
            overflow-x: hidden;
            overflow-y: auto;
        }
        
        /* Animated Background Elements */
        .background-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }
        
        .bg-element {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.3;
            animation: float 8s ease-in-out infinite;
        }
        
        .bg-element-1 {
            width: 300px;
            height: 300px;
            background: linear-gradient(45deg, #4f46e5, transparent);
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .bg-element-2 {
            width: 250px;
            height: 250px;
            background: linear-gradient(45deg, #06b6d4, transparent);
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }
        
        .bg-element-3 {
            width: 200px;
            height: 200px;
            background: linear-gradient(45deg, #f59e0b, transparent);
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }
        
        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(20px, -20px) rotate(120deg); }
            66% { transform: translate(-20px, 20px) rotate(240deg); }
        }
        
        /* Auth Container */
        .auth-container {
            width: 100%;
            max-width: 500px;
            padding: 1rem;
            margin: 4rem auto;
            position: relative;
            z-index: 2;
            animation: fadeInUp 0.8s ease-out;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Brand Logo */
        .auth-brand {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        
        .auth-brand a {
            text-decoration: none;
        }
        
        .auth-logo-container {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border-radius: 50%;
            margin: 0 auto 1.5rem;
            box-shadow: 0 20px 40px rgba(79, 70, 229, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .auth-logo-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.2), transparent);
            transform: rotate(45deg);
            animation: shine 3s infinite;
        }
        
        @keyframes shine {
            0% { transform: rotate(45deg) translateX(-100%); }
            100% { transform: rotate(45deg) translateX(100%); }
        }
        
        .auth-logo {
            font-size: 2.5rem;
            color: white;
            z-index: 1;
        }
        
        .auth-brand-name {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 2.25rem;
            font-weight: 800;
            background: linear-gradient(135deg, #4f46e5, #06b6d4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }
        
        .auth-brand-tagline {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.1rem;
            font-weight: 500;
        }
        
        /* Auth Card */
        .auth-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.1);
            overflow: hidden;
            position: relative;
        }
        
        .auth-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #4f46e5, #06b6d4, #f59e0b);
        }
        
        .auth-card-header {
            padding: 3rem 2.5rem 2rem;
            text-align: center;
            position: relative;
        }
        
        .auth-card-title {
            font-size: 2rem;
            font-weight: 800;
            color: white;
            margin-bottom: 0.75rem;
        }
        
        .auth-card-subtitle {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1rem;
            line-height: 1.6;
        }
        
        .auth-card-body {
            padding: 0 2.5rem 2.5rem;
        }
        
        /* Form Styles */
        .form-group {
            margin-bottom: 1.75rem;
            position: relative;
        }
        
        .form-label {
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
            display: block;
        }
        
        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 1rem 1.25rem;
            font-size: 1rem;
            color: white;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            width: 100%;
        }
        
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        
        .form-control:focus {
            outline: none;
            border-color: #4f46e5;
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.2);
        }
        
        .form-control.is-invalid {
            border-color: #ef4444;
        }
        
        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.2);
        }
        
        .invalid-feedback {
            color: #f87171;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: block;
        }
        
        /* Input Icon */
        .input-group-icon {
            position: relative;
        }
        
        .input-group-icon .form-control {
            padding-left: 3rem;
        }
        
        .input-icon {
            position: absolute;
            left: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.6);
            z-index: 4;
        }
        
        /* Remember Me & Forgot Password */
        .form-extras {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.75rem;
        }
        
        .form-check {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .form-check-input {
            width: 1.25rem;
            height: 1.25rem;
            background-color: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
        }
        
        .form-check-input:checked {
            background-color: #4f46e5;
            border-color: #4f46e5;
        }
        
        .form-check-label {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.95rem;
            margin: 0;
        }
        
        .forgot-link {
            color: #818cf8;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .forgot-link:hover {
            color: #a5b4fc;
            transform: translateX(3px);
        }
        
        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 1.125rem;
            font-weight: 700;
            font-size: 1.1rem;
            border-radius: 16px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            border: none;
            color: white;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
        }
        
        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }
        
        .btn-submit:hover::before {
            left: 100%;
        }
        
        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(79, 70, 229, 0.4);
        }
        
        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 2rem 0;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .divider span {
            padding: 0 1.5rem;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.95rem;
            font-weight: 600;
        }
        
        /* Social Login */
        .social-login {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
            margin-bottom: 1.75rem;
        }
        
        .btn-social {
            padding: 1rem;
            border-radius: 16px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            backdrop-filter: blur(10px);
        }
        
        .btn-social:hover {
            border-color: #4f46e5;
            background: rgba(79, 70, 229, 0.2);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.2);
        }
        
        .btn-social i {
            font-size: 1.25rem;
        }
        
        /* Auth Footer - DIPERBAIKI */
        .auth-footer {
            padding: 2rem 2.5rem;
            background: rgba(255, 255, 255, 0.1); /* ← Background lebih gelap */
            text-align: center;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0 0 24px 24px; /* ← Border radius bawah card */
        }
        
        .auth-footer p {
            color: rgba(255, 255, 255, 0.9); /* ← Warna teks lebih terang */
            margin: 0;
            font-size: 1rem;
        }
        
        .auth-footer a {
            color: #818cf8; /* ← Warna link tetap */
            text-decoration: none;
            font-weight: 700;
            font-size: 1rem;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .auth-footer a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: #818cf8;
            transition: width 0.3s ease;
        }
        
        .auth-footer a:hover {
            color: #a5b4fc;
            text-decoration: none; /* ← Hapus garis bawah default */
        }
        
        .auth-footer a:hover::after {
            width: 100%;
        }
        
        /* Back to Home */
        .back-home {
            text-align: center;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }
        
        .back-home a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .back-home a:hover {
            color: white;
            transform: translateX(-5px);
        }
        
        /* Alert */
        .auth-alert {
            border-radius: 16px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.75rem;
            border: none;
            font-size: 0.95rem;
            backdrop-filter: blur(10px);
        }
        
        .auth-alert.alert-success {
            background: rgba(16, 185, 129, 0.15);
            color: #a7f3d0;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }
        
        .auth-alert.alert-danger {
            background: rgba(239, 68, 68, 0.15);
            color: #fecaca;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }
        
        /* Loading State */
        .btn-submit:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }
        
        /* Responsive */
        @media (max-width: 576px) {
            .auth-container {
                padding: 0.75rem;
                margin: 2rem auto;
            }
            
            .auth-card-header,
            .auth-card-body,
            .auth-footer {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
            
            .auth-brand-name {
                font-size: 1.75rem;
            }
            
            .auth-card-title {
                font-size: 1.75rem;
            }
            
            .social-login {
                grid-template-columns: 1fr;
            }
            
            .form-extras {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }
        }
        
        /* Additional Animations */
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .pulse-animation {
            animation: pulse 2s infinite;
        }
    </style>
    
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