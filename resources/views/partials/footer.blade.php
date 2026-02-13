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
                    <li><a href="{{ route('produk.index', ['kategori' => 'Hiasan']) }}">Hiasan Rumah</a></li>
                    <li><a href="{{ route('produk.index', ['kategori' => 'Hadiah']) }}">Hadiah Spesial</a></li>
                </ul>
            </div>

            <!-- Support Section -->
            <div class="footer-column">
                <h3 class="footer-title">Bantuan</h3>
                <ul class="footer-links">
                    <li><a href="#">Kebijakan Pengembalian</a></li>
                    <li><a href="#">Cara Pemesanan</a></li>
                    <li><a href="#">Pengiriman</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Kontak Kami</a></li>
                </ul>
            </div>

            <!-- Contact Section -->
            <div class="footer-column">
                <h3 class="footer-title">Hubungi Kami</h3>
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Bogor, West Java, Indonesia</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <span>info@defacraft.com</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <span>+62 812-3456-7890</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-clock"></i>
                        <span>Senin-Sabtu: 09.00-18.00 WIB</span>
                    </div>
                </div>
                <a href="https://wa.me/6281234567890" target="_blank" 
                   class="whatsapp-button">
                    <i class="fab fa-whatsapp"></i>
                    Chat WhatsApp
                </a>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="footer-bottom">
            <div class="copyright">
                <p>&copy; 2025 DefaCraftStore. Dibuat dengan penuh cinta ❤️</p>
            </div>
        </div>
    </div>
</footer>

<style>
.footer-radical {
    position: relative;
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
    color: white;
    overflow: hidden;
    padding: 0;
    margin-top: 5rem;
}

.footer-shapes {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 1;
}

.shape {
    position: absolute;
    background: linear-gradient(45deg, rgba(79, 70, 229, 0.1), transparent);
    border-radius: 50%;
    filter: blur(40px);
    animation: float 6s ease-in-out infinite;
}

.shape-1 {
    width: 200px;
    height: 200px;
    top: 20%;
    left: 10%;
    animation-delay: 0s;
}

.shape-2 {
    width: 150px;
    height: 150px;
    top: 60%;
    right: 15%;
    animation-delay: 2s;
    background: linear-gradient(45deg, rgba(6, 182, 212, 0.1), transparent);
}

.shape-3 {
    width: 100px;
    height: 100px;
    bottom: 20%;
    left: 20%;
    animation-delay: 4s;
    background: linear-gradient(45deg, rgba(245, 158, 11, 0.1), transparent);
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(180deg); }
}

.footer-container {
    position: relative;
    z-index: 2;
    max-width: 1400px;
    margin: 0 auto;
    padding: 4rem 2rem;
}

.footer-grid {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1.5fr;
    gap: 3rem;
    margin-bottom: 4rem;
}

.footer-column h3 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    color: #f8fafc;
    position: relative;
    display: inline-block;
}

.footer-column h3::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 0;
    width: 50px;
    height: 3px;
    background: linear-gradient(90deg, #4f46e5, #06b6d4);
    border-radius: 2px;
}

.footer-description {
    color: #cbd5e1;
    line-height: 1.7;
    margin-bottom: 1.5rem;
    font-size: 1.05rem;
}

.logo-container {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.logo-circle {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: 800;
    box-shadow: 0 10px 30px rgba(79, 70, 229, 0.3);
}

.logo-text {
    font-size: 2rem;
    font-weight: 800;
    background: linear-gradient(135deg, #4f46e5, #06b6d4);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li {
    margin-bottom: 0.75rem;
}

.footer-links a {
    color: #cbd5e1;
    text-decoration: none;
    font-size: 1rem;
    transition: all 0.3s ease;
    position: relative;
    padding-left: 1.5rem;
    display: block;
}

.footer-links a::before {
    content: '→';
    position: absolute;
    left: 0;
    opacity: 0;
    transition: all 0.3s ease;
}

.footer-links a:hover {
    color: #818cf8;
    transform: translateX(5px);
}

.footer-links a:hover::before {
    opacity: 1;
    transform: translateX(3px);
}

.contact-info {
    margin-bottom: 2rem;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
    color: #cbd5e1;
    font-size: 0.95rem;
}

.contact-item i {
    color: #818cf8;
    font-size: 1.2rem;
    width: 20px;
}

.whatsapp-button {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    background: linear-gradient(135deg, #25d366, #128c7e);
    color: white;
    padding: 1rem 1.5rem;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 10px 25px rgba(37, 211, 102, 0.3);
}

.whatsapp-button:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(37, 211, 102, 0.4);
}

.social-icons {
    display: flex;
    gap: 1rem;
    margin-top: 1.5rem;
}

.social-icon {
    width: 45px;
    height: 45px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 1.2rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.social-icon:hover {
    background: linear-gradient(135deg, #4f46e5, #06b6d4);
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
}

.footer-bottom {
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    padding-top: 2rem;
    margin-top: 2rem;
    text-align: center;
}

.copyright p {
    color: #94a3b8;
    font-size: 0.9rem;
    margin: 0;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .footer-grid {
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }
}

@media (max-width: 768px) {
    .footer-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .logo-text {
        font-size: 1.5rem;
    }
    
    .logo-circle {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
    }
}

@media (max-width: 480px) {
    .footer-container {
        padding: 2rem 1rem;
    }
    
    .social-icons {
        justify-content: center;
    }
}
</style>

<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">