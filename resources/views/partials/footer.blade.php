<footer class="footer-radical">
    <!-- Background Elements -->
    <div class="footer-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>
    
    <!-- Main Footer Content -->
    <div class="footer-container">
        <div class="footer-grid">
            <!-- Brand Section -->
            <div class="footer-column">
                <div class="footer-brand">
                    <div class="logo-container">
                        <div class="logo-circle">
                            <span class="logo-letter">D</span>
                        </div>
                        <h2 class="logo-text">DefaCraft</h2>
                    </div>
                    <p class="footer-description">
                        Membuat dunia lebih berwarna dengan kerajinan tangan yang penuh cinta dan kreativitas
                    </p>
                    <div class="social-icons">
                        <a href="#" class="social-icon">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-tiktok"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Products Section -->
            <div class="footer-column">
                <h3 class="footer-title">Koleksi</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('produk.index') }}">Semua Produk</a></li>
                    <li><a href="{{ route('produk.index', ['kategori' => 'Boneka']) }}">Boneka Lucu</a></li>
                    <li><a href="{{ route('produk.index', ['kategori' => 'Aksesoris']) }}">Aksesoris Unik</a></li>
                    <li><a href="{{ route('produk.index', ['kategori' => 'Dekorasi']) }}">Dekorasi</a></li>
                </ul>
            </div>

            <!-- Support Section -->
            <div class="footer-column">
                <h3 class="footer-title">Bantuan</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('bantuan.pengembalian') }}">Kebijakan Pengembalian</a></li>
                    <li><a href="{{ route('bantuan.cara-pesan') }}">Cara Pemesanan</a></li>
                    <li><a href="{{ route('bantuan.pengiriman') }}">Pengiriman</a></li>
                    <li><a href="{{ route('bantuan.faq') }}">FAQ</a></li>
                    <li><a href="{{ route('bantuan.kontak') }}">Kontak Kami</a></li>
                </ul>
            </div>

            <!-- Contact Section -->
            <div class="footer-column">
                <h3 class="footer-title">Hubungi Kami</h3>
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Bogor, Jawa Barat, Indonesia</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <span>dendyfadhlullah46@gmail.com</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <span>+6285658080575</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-clock"></i>
                        <span>Senin-Sabtu: 09.00-18.00 WIB</span>
                    </div>
                </div>
                <a href="https://wa.me/6285658080575" target="_blank" 
                   class="whatsapp-button"> 
                    <i class="fab fa-whatsapp"></i>
                    Chat WhatsApp
                </a>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="footer-bottom">
            <div class="copyright">
                <p>&copy; 2026 DefaCraftStore.</p>
            </div>
        </div>
    </div>
</footer>

<link rel="stylesheet" href="{{ asset('css/partials-footer.css') }}">

<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">