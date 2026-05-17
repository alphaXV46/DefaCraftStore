@extends('layouts.auth')

@section('title', 'Register')

@section('content')
    <!-- Auth Card - Register Form -->
    <div class="auth-card">
        <!-- Header -->
        <div class="auth-card-header">
            <h1 class="auth-card-title">Buat Akun Baru </h1>
            <p class="auth-card-subtitle">Bergabung dengan DefaCraftStore sekarang!</p>
        </div>
        
        <!-- Body -->
        <div class="auth-card-body">
            <!-- Register Form -->
            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf
                
                <!-- Name -->
                <div class="form-group">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <div class="input-group-icon">
                        <span class="input-icon">👤</span>
                        <input id="name" 
                               type="text" 
                               name="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" 
                               placeholder="Nama lengkap Anda"
                               required 
                               autofocus>
                    </div>
                    @error('name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group-icon">
                        <span class="input-icon">📧</span>
                        <input id="email" 
                               type="email" 
                               name="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email') }}" 
                               placeholder="nama@example.com"
                               required>
                    </div>
                    @error('email')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group-icon">
                        <span class="input-icon">🔒</span>
                        <input id="password" 
                               type="password" 
                               name="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               placeholder="Minimal 8 karakter"
                               required>
                    </div>
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Minimal 8 karakter, kombinasi huruf dan angka</small>
                </div>
                
                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <div class="input-group-icon">
                        <span class="input-icon">🔐</span>
                        <input id="password_confirmation" 
                               type="password" 
                               name="password_confirmation" 
                               class="form-control" 
                               placeholder="Ulangi password Anda"
                               required>
                    </div>
                </div>
                
                <!-- Terms -->
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" 
                               type="checkbox" 
                               id="terms" 
                               name="terms"
                               required>
                        <label class="form-check-label" for="terms">
                            Saya setuju dengan <a href="#" class="text-primary">Syarat & Ketentuan</a>
                        </label>
                    </div>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" class="btn-submit">
                    Daftar Sekarang
                </button>
            </form>
            
            <!-- Divider -->
            <div class="divider">
                <span>atau daftar dengan</span>
            </div>
            
            <!-- Social Login -->
            <a href="{{ url('/auth/google') }}" class="btn-social">
    <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
        <path d="M17.64 9.2c0-.637-.057-1.251-.164-1.84H9v3.481h4.844c-.209 1.125-.843 2.078-1.796 2.717v2.258h2.908c1.702-1.567 2.684-3.874 2.684-6.615z" fill="#4285F4"/>
        <path d="M9.003 18c2.43 0 4.467-.806 5.956-2.183l-2.909-2.259c-.806.54-1.836.86-3.047.86-2.344 0-4.328-1.584-5.036-3.711H.957v2.332C2.438 15.983 5.482 18 9.003 18z" fill="#34A853"/>
        <path d="M3.964 10.712c-.18-.54-.282-1.117-.282-1.71 0-.593.102-1.17.282-1.71V4.96H.957C.347 6.175 0 7.55 0 9.002c0 1.452.348 2.827.957 4.042l3.007-2.332z" fill="#FBBC05"/>
        <path d="M9.003 3.58c1.321 0 2.508.454 3.44 1.345l2.582-2.58C13.464.891 11.428 0 9.002 0 5.48 0 2.438 2.017.957 4.958L3.964 7.29c.708-2.127 2.692-3.71 5.036-3.71z" fill="#EA4335"/>
    </svg>
    Daftar dengan Google
</a>
        </div>
        
        <!-- Footer -->
        <div class="auth-footer">
            <p>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Form submit animation
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        const btn = this.querySelector('.btn-submit');
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Loading...';
        btn.disabled = true;
    });
    
    // Password strength indicator
    const password = document.getElementById('password');
    const passwordConfirm = document.getElementById('password_confirmation');
    
    passwordConfirm.addEventListener('input', function() {
        if (this.value !== password.value) {
            this.setCustomValidity('Password tidak cocok');
        } else {
            this.setCustomValidity('');
        }
    });
</script>
@endpush