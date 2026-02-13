@extends('layouts.auth')
@section('title', 'Login')

@section('content')
    <div class="auth-container">
        <!-- Auth Card -->
        <div class="auth-card">
            <div class="auth-card-header">
                <h2 class="auth-card-title">Masuk ke Akun</h2>
                <p class="auth-card-subtitle">Silakan masukkan email dan password Anda</p>
            </div>
            <div class="auth-card-body">
                <!-- Tambahkan notifikasi ini -->
                @if ($errors->any())
                    <div class="alert alert-danger auth-alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('status'))
                    <div class="alert alert-info auth-alert">
                        {{ session('status') }}
                    </div>
                @endif
                <!-- /Tambahkan notifikasi ini -->

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group-icon">
                            <span class="input-icon">📧</span>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="nama@example.com">

                        </div>
                         @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group-icon">
                            <span class="input-icon">🔒</span>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="••••••••">
                        </div>
                         @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-extras">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                Ingat Saya
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <a class="forgot-link" href="{{ route('password.request') }}">
                                Lupa Password?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="btn-submit">
                        Masuk
                    </button>
                </form>

                <div class="divider">
                    <span>atau</span>
                </div>

                <div class="social-login">
                    <button type="button" class="btn-social">
                        <i class="fab fa-google"></i>
                        Google
                    </button>
                    <button type="button" class="btn-social">
                        <i class="fab fa-facebook"></i>
                        Facebook
                    </button>
                </div>
            </div>

            <div class="auth-footer">
                <p>Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
            </div>
        </div>
    </div>
@endsection