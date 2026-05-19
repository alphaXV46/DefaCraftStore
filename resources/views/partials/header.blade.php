<nav class="navbar-modern">
    <div class="navbar-container">
        <!-- Logo -->
        <div class="navbar-brand">
            <a href="{{ route('home') }}" class="logo-link">
                <div class="logo-icon"></div>
                <span class="logo-text">DefaCraft</span>
            </a>
        </div>
        
        <!-- Search Bar -->
        <form action="{{ route('produk.index') }}" method="GET" class="search-container">
            <div class="search-input-wrapper">
                <input class="search-input" type="search" name="search" 
                    placeholder="Cari produk lucu dan unik..." value="{{ request('search') }}">
                <button class="search-button" type="submit" aria-label="Cari Produk">
                    <i class="fas fa-search"></i>
                </button>
                <!-- Tombol Clear -->
                <button type="button" class="search-clear-btn" onclick="clearSearch()" aria-label="Bersihkan pencarian">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </form>

        <!-- Navigation Menu -->
        <div class="navbar-menu">
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('produk.index') }}" class="nav-link">
                        <i class="fas fa-box"></i>
                        <span>Produk</span>
                    </a>
                </li>
                
                @auth
                    <!-- Cart with Badge -->
                    <li class="nav-item cart-item">
                        <a href="{{ route('keranjang.index') }}" class="nav-link cart-link" aria-label="Keranjang Belanja">
                            <div class="cart-icon-wrapper">
                                <i class="fas fa-shopping-cart"></i>
                                @if(($cartCount ?? 0) > 0)
                                    <span class="cart-count">{{ $cartCount }}</span>
                                @endif
                            </div>
                        </a>
                    </li>
                    
                    <!-- User Dropdown -->
                    <li class="nav-item dropdown-item">
                        <div class="user-menu">
                            <div class="user-trigger">
                                <span class="user-name">{{ auth()->user()->name }}</span>
                                <i class="fas fa-user-circle user-icon"></i>
                            </div>
                            <div class="dropdown-content">
                                @if(auth()->user()->role === 'superadmin')
                                    <a href="{{ route('superadmin.manage') }}" class="dropdown-link text-primary font-weight-bold" style="color: #4A2E80 !important; font-weight: 700;">
                                        <i class="fas fa-users-cog"></i>
                                        Kelola Admin
                                    </a>
                                    <a href="{{ route('superadmin.logs') }}" class="dropdown-link text-primary font-weight-bold" style="color: #4A2E80 !important; font-weight: 700;">
                                        <i class="fas fa-history"></i>
                                        Log Aktivitas
                                    </a>
                                    <div class="dropdown-divider"></div>
                                @endif

                                <a href="{{ route('produk.index') }}" class="dropdown-link">
                                    <i class="fas fa-box"></i>
                                    Produk
                                </a>
                                
                                <!-- TAMBAH MENU WISHLIST & PESANAN 👇 -->
                                <a href="{{ route('wishlist.index') }}" class="dropdown-link">
                                    <i class="fas fa-heart"></i>
                                    Wishlist
                                    @if(($wishlistCount ?? 0) > 0)
                                        <span class="cart-badge dropdown-badge">{{ $wishlistCount }}</span>
                                    @endif
                                </a>
                                
                                <a href="{{ route('transaksi.riwayat') }}" class="dropdown-link">
                                    <i class="fas fa-history"></i>
                                    Pesanan Saya
                                </a>
                                
                                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin')
                                    <a href="{{ route('admin.users.index') }}" class="dropdown-link" style="color: #4A2E80; font-weight: 600;">
                                        <i class="fas fa-users"></i>
                                        Kelola Pelanggan
                                    </a>
                                    <a href="{{ route('admin.dashboard') }}" class="dropdown-link" style="color: #4A2E80; font-weight: 600;">
                                        <i class="fas fa-tachometer-alt"></i>
                                        Dashboard Admin
                                    </a>
                                    <div class="dropdown-divider"></div>
                                @endif

                                <a href="{{ route('profile.edit') }}" class="dropdown-link">
                                    <i class="fas fa-user"></i>
                                    Profil
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="dropdown-form">
                                    @csrf
                                    <button type="submit" class="dropdown-link logout-btn">
                                        <i class="fas fa-sign-out-alt"></i>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="login-button">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Login</span>
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
        
        <!-- Mobile Toggle -->
        <button class="mobile-toggle" aria-label="Buka Menu" aria-expanded="false">
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </button>
    </div>
    
    <!-- Mobile Menu -->
    <div class="mobile-menu">
        <!-- Search di mobile -->
        <form action="{{ route('produk.index') }}" method="GET" class="mobile-search">
            <div class="mobile-search-wrapper">
                <input type="search" name="search" class="mobile-search-input"
                       placeholder="Cari produk..." value="{{ request('search') }}">
                <button type="submit" class="mobile-search-btn" aria-label="Cari">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
        <ul class="mobile-nav-list">
            <li><a href="{{ route('home') }}">🏠 Home</a></li>
            <li><a href="{{ route('produk.index') }}">📦 Produk</a></li>
            @auth
                @if(auth()->user()->role === 'superadmin')
                    <li class="bg-light"><a href="{{ route('superadmin.manage') }}">👥 Kelola Admin</a></li>
                    <li class="bg-light"><a href="{{ route('superadmin.logs') }}">📜 Log Aktivitas</a></li>
                @endif

                <li><a href="{{ route('keranjang.index') }}">🛒 Keranjang</a></li>
                <li><a href="{{ route('wishlist.index') }}">❤️ Wishlist</a></li>
                <li><a href="{{ route('transaksi.riwayat') }}">📋 Pesanan Saya</a></li>
                <li><a href="{{ route('profile.edit') }}">👤 Profil</a></li>
                
                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin')
                    <li class="bg-light"><a href="{{ route('admin.users.index') }}">👥 Kelola Pelanggan</a></li>
                    <li class="bg-light"><a href="{{ route('admin.dashboard') }}">🔧 Dashboard Admin</a></li>
                @endif
                
                <li>
                    <form method="POST" action="{{ route('logout') }}" class="mobile-logout">
                        @csrf
                        <button type="submit" class="mobile-logout-btn">🚪 Logout</button>
                    </form>
                </li>
            @else
                <li><a href="{{ route('login') }}">🔑 Login</a></li>
            @endauth
        </ul>
    </div>
</nav>

<script>
    // Fungsi untuk membersihkan input pencarian
    function clearSearch() {
        const searchInput = document.querySelector('.search-input');
        if (searchInput) {
            searchInput.value = '';
            searchInput.closest('form').submit();
        }
    }

    // Tampilkan/hide tombol clear berdasarkan input
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        // Cek nilai awal
        toggleClearButton();
        
        // Tambahkan event listener
        searchInput.addEventListener('input', toggleClearButton);
        searchInput.addEventListener('change', toggleClearButton);
    }

    function toggleClearButton() {
        const clearBtn = document.querySelector('.search-clear-btn');
        if (clearBtn && searchInput) {
            if (searchInput.value.trim() !== '') {
                clearBtn.style.display = 'flex';
            } else {
                clearBtn.style.display = 'none';
            }
        }
    }

    // Hamburger toggle
    document.addEventListener('DOMContentLoaded', function() {
        const hamburger = document.querySelector('.hamburger');
        const mobileMenu = document.querySelector('.mobile-menu');
        const navbar = document.querySelector('.navbar-modern');

        if (hamburger && mobileMenu) {
            hamburger.addEventListener('click', function() {
                mobileMenu.classList.toggle('active');
                hamburger.classList.toggle('open');
            });

            // Tutup menu kalau klik di luar
            document.addEventListener('click', function(e) {
                if (navbar && !navbar.contains(e.target)) {
                    mobileMenu.classList.remove('active');
                    hamburger.classList.remove('open');
                }
            });

            // Tutup menu kalau klik link di dalam mobile menu
            mobileMenu.querySelectorAll('a, button').forEach(el => {
                el.addEventListener('click', function() {
                    mobileMenu.classList.remove('active');
                    hamburger.classList.remove('open');
                });
            });
        }
    });
</script>