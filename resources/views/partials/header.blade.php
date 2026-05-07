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
                <button class="search-button" type="submit">
                    <i class="fas fa-search"></i>
                </button>
                <!-- Tombol Clear -->
                <button type="button" class="search-clear-btn" onclick="clearSearch()">
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
                        <a href="{{ route('keranjang.index') }}" class="nav-link cart-link">
                            <div class="cart-icon-wrapper">
                                <i class="fas fa-shopping-cart"></i>
                                @php
                                    $cartCount = \App\Models\Keranjang::where('user_id', auth()->id())->count();
                                @endphp
                                @if($cartCount > 0)
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
                                <!-- Menu Produk -->
                                <a href="{{ route('produk.index') }}" class="dropdown-link">
                                    <i class="fas fa-box"></i>
                                    Produk
                                </a>
                                
                                <!-- TAMBAH MENU WISHLIST & PESANAN 👇 -->
                                <a href="{{ route('wishlist.index') }}" class="dropdown-link">
                                    <i class="fas fa-heart"></i>
                                    Wishlist
                                    @php
                                        $wishlistCount = \App\Models\Wishlist::where('user_id', auth()->id())->count();
                                    @endphp
                                    @if($wishlistCount > 0)
                                        <span class="cart-badge dropdown-badge">{{ $wishlistCount }}</span>
                                    @endif
                                </a>
                                
                                <a href="{{ route('transaksi.riwayat') }}" class="dropdown-link">
                                    <i class="fas fa-history"></i>
                                    Pesanan Saya
                                </a>
                                
                                @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="dropdown-link">
                                        <i class="fas fa-cog"></i>
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
        <div class="mobile-toggle">
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <div class="mobile-menu">
        <!-- Search di mobile -->
<form action="{{ route('produk.index') }}" method="GET" class="mobile-search">
    <div class="mobile-search-wrapper">
        <input type="search" name="search" class="mobile-search-input"
               placeholder="Cari produk..." value="{{ request('search') }}">
        <button type="submit" class="mobile-search-btn">
            <i class="fas fa-search"></i>
        </button>
    </div>
</form>
        <ul class="mobile-nav-list">
            <li><a href="{{ route('home') }}">🏠 Home</a></li>
            <li><a href="{{ route('produk.index') }}">📦 Produk</a></li>
            @auth
                <li><a href="{{ route('keranjang.index') }}">🛒 Keranjang</a></li>
                <li><a href="{{ route('wishlist.index') }}">❤️ Wishlist</a></li>
                <li><a href="{{ route('transaksi.riwayat') }}">📋 Pesanan Saya</a></li>
                <li><a href="{{ route('profile.edit') }}">👤 Profil</a></li>
                @if(auth()->user()->role === 'admin')
                    <li><a href="{{ route('admin.dashboard') }}">🔧 Admin</a></li>
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

<style>
.navbar-modern {
    position: sticky;
    top: 0;
    z-index: 1000;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    padding: 1rem 0;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
}

.navbar-modern.scrolled {
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    background: rgba(255, 255, 255, 0.98);
}

.navbar-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 2rem;
}

.navbar-brand {
    flex-shrink: 0;
}

.logo-link {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    text-decoration: none;
    color: #0f172a;
    transition: all 0.3s ease;
}

.logo-icon {
    font-size: 1.8rem;
    animation: bounce 2s infinite;
}

.logo-text {
    font-size: 1.5rem;
    font-weight: 800;
    background: linear-gradient(135deg, #4f46e5, #06b6d4);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.search-container {
    flex: 1;
    max-width: 500px;
    margin: 0 2rem;
}

/* ... (CSS lainnya tetap sama) ... */

.search-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.search-input {
    width: 100%;
    padding: 0.875rem 5rem 0.875rem 1.5rem; /* Ditambahkan padding kanan untuk memberi ruang */
    border: 2px solid #e2e8f0;
    border-radius: 50px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #f8fafc;
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
}

.search-input:focus {
    outline: none;
    border-color: #4f46e5;
    box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
    background: white;
    transform: translateY(-2px);
}

.search-button {
    position: absolute;
    right: 0.5rem; /* Jarak dari kanan */
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    color: white;
    border: none;
    border-radius: 50px;
    padding: 0.75rem 1.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    z-index: 1; /* Agar tetap di atas clear button */
}

.search-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
}

/* Tombol Clear */
.search-clear-btn {
    position: absolute;
    right: 5rem; /* Letakkan sebelum tombol search */
    background: transparent;
    border: none;
    color: #94a3b8; /* Warna abu-abu terang */
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 50%;
    transition: all 0.2s ease;
    z-index: 2; /* Agar bisa diklik */
    display: none; /* Sembunyikan secara default */
}

.search-clear-btn:hover {
    color: #4f46e5; /* Warna saat hover */
    background: rgba(79, 70, 229, 0.1);
}

/* ... (CSS lainnya tetap sama) ... */

.navbar-menu {
    flex-shrink: 0;
}

.nav-list {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    list-style: none;
    margin: 0;
    padding: 0;
}

.nav-item {
    position: relative;
}

.nav-link {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    color: #334155;
    font-weight: 500;
    padding: 0.75rem 1rem;
    border-radius: 12px;
    transition: all 0.3s ease;
    position: relative;
}

.nav-link:hover {
    color: #4f46e5;
    background: rgba(79, 70, 229, 0.1);
    transform: translateY(-2px);
}

.nav-link i {
    font-size: 1.1rem;
}

.cart-item .cart-link {
    padding: 0.75rem;
}

.cart-icon-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.cart-count {
    position: absolute;
    top: -8px;
    right: -8px;
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
    font-size: 0.75rem;
    font-weight: 700;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
}

.user-menu {
    position: relative;
}

.user-trigger {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    cursor: pointer;
    padding: 0.75rem;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.user-trigger:hover {
    background: rgba(79, 70, 229, 0.1);
}

.user-name {
    font-weight: 600;
    color: #334155;
}

.user-icon {
    font-size: 1.5rem;
    color: #4f46e5;
}

.dropdown-content {
    position: absolute;
    top: 100%;
    right: 0;
    background: white;
    border-radius: 16px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    padding: 1rem 0;
    min-width: 220px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(10px);
    transition: all 0.3s ease;
    z-index: 1000;
    border: 1px solid rgba(0, 0, 0, 0.1);
}

.user-menu:hover .dropdown-content {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-link {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem 1.5rem;
    text-decoration: none;
    color: #334155;
    transition: all 0.3s ease;
    font-weight: 500;
}

.dropdown-link:hover {
    background: rgba(79, 70, 229, 0.1);
    color: #4f46e5;
    transform: translateX(5px);
}

.dropdown-divider {
    height: 1px;
    background: rgba(0, 0, 0, 0.1);
    margin: 0.5rem 0;
}

.dropdown-form {
    margin: 0;
}

.logout-btn {
    width: 100%;
    text-align: left;
    background: none;
    border: none;
    cursor: pointer;
    font-family: inherit;
}

.login-button {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
}

.login-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(79, 70, 229, 0.4);
}

/* Badge untuk dropdown */
.dropdown-badge {
    position: absolute;
    top: 50%;
    right: 1rem;
    transform: translateY(-50%);
    font-size: 0.75rem;
    font-weight: 700;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
    box-shadow: 0 2px 4px rgba(239, 68, 68, 0.3);
}

/* Mobile Toggle */
.mobile-toggle {
    display: none;
    cursor: pointer;
    padding: 0.5rem;
}

.hamburger {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.hamburger span {
    width: 25px;
    height: 3px;
    background: #334155;
    border-radius: 2px;
    transition: all 0.3s ease;
}

/* Animasi hamburger jadi X */
.hamburger.open span:nth-child(1) {
    transform: translateY(7px) rotate(45deg);
}
.hamburger.open span:nth-child(2) {
    opacity: 0;
    transform: scaleX(0);
}
.hamburger.open span:nth-child(3) {
    transform: translateY(-7px) rotate(-45deg);
}

/* Mobile Menu */
.mobile-menu {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    padding: 1rem;
    z-index: 999;
}

.mobile-nav-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.mobile-nav-list li {
    margin-bottom: 0.5rem;
}

.mobile-nav-list a {
    display: block;
    padding: 1rem;
    text-decoration: none;
    color: #334155;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.mobile-nav-list a:hover {
    background: rgba(79, 70, 229, 0.1);
    color: #4f46e5;
}

.mobile-logout {
    margin: 0;
}

.mobile-logout-btn {
    width: 100%;
    padding: 1rem;
    text-align: left;
    background: none;
    border: none;
    color: #334155;
    cursor: pointer;
    border-radius: 12px;
    transition: all 0.3s ease;
    font-family: inherit;
}

.mobile-logout-btn:hover {
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
}
.mobile-search {
    padding: 0.5rem 0 1rem 0;
    border-bottom: 1px solid #f1f5f9;
    margin-bottom: 0.5rem;
}
.mobile-search-wrapper {
    display: flex;
    gap: 0.5rem;
}
.mobile-search-input {
    flex: 1;
    padding: 0.75rem 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 50px;
    font-size: 0.9rem;
    outline: none;
}
.mobile-search-input:focus {
    border-color: #4f46e5;
}

.mobile-search-btn {
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    color: white;
    border: none;
    border-radius: 50px;
    padding: 0.75rem 1.2rem;
    cursor: pointer;
}

/* Animations */
@keyframes bounce {
    0%, 20%, 53%, 80%, 100% {
        transform: translate3d(0,0,0);
    }
    40%, 43% {
        transform: translate3d(0,-8px,0);
    }
    70% {
        transform: translate3d(0,-4px,0);
    }
    90% {
        transform: translate3d(0,-2px,0);
    }
}

/* Responsive Design */
@media (max-width: 1024px) {
    .navbar-container {
        padding: 0 1.5rem;
    }
    
    .search-container {
        max-width: 300px;
    }
}

@media (max-width: 768px) {
    .navbar-container {
        padding: 0 1rem;
    }
    
    .search-container {
        display: none;
    }
    
    .mobile-toggle {
        display: block;
    }
    
    .navbar-menu {
        display: none;
    }
    
    .mobile-menu.active {
        display: block;
    }
    
    .logo-text {
        font-size: 1.25rem;
    }
    
    .logo-icon {
        font-size: 1.5rem;
    }
}

@media (max-width: 480px) {
    .navbar-container {
        padding: 0 0.75rem;
        gap: 1rem;
    }
    
    .logo-link {
        gap: 0.5rem;
    }
    
    .logo-text {
        font-size: 1.1rem;
    }
    
    .logo-icon {
        font-size: 1.3rem;
    }
}
</style>

<script>
    // Fungsi untuk membersihkan input pencarian
    function clearSearch() {
        const searchInput = document.querySelector('.search-input');
        searchInput.value = '';
        // Submit otomatis form jika diperlukan
        searchInput.closest('form').submit();
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
        if (searchInput.value.trim() !== '') {
            clearBtn.style.display = 'flex';
        } else {
            clearBtn.style.display = 'none';
        }
    }

    // Hamburger toggle
document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.querySelector('.hamburger');
    const mobileMenu = document.querySelector('.mobile-menu');
    const navbar     = document.querySelector('.navbar-modern');

    if (hamburger && mobileMenu) {
        hamburger.addEventListener('click', function() {
            mobileMenu.classList.toggle('active');
            hamburger.classList.toggle('open');
        });

        // Tutup menu kalau klik di luar
        document.addEventListener('click', function(e) {
            if (!navbar.contains(e.target)) {
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