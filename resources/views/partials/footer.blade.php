<footer class="footer py-4 mt-5">
    <div class="container">
        <div class="row">
            <!-- Info Toko -->
            <div class="col-md-4">
                <h5 class="fw-bold mb-3">DefaCraftStore</h5>
                <p>Toko kerajinan tangan lucu dan unik terpercaya.</p>
                <p class="mb-1">📍 Bogor, West Java, Indonesia</p>
                <p>📧 info@defacraft.com</p>
            </div>
            
            <!-- Quick Links -->
            <div class="col-md-4">
                <h5 class="fw-bold mb-3">Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}" class="text-white text-decoration-none">Home</a></li>
                    <li><a href="{{ route('produk.index') }}" class="text-white text-decoration-none">Produk</a></li>
                    <li><a href="{{ route('produk.index', ['kategori' => 'Boneka']) }}" class="text-white text-decoration-none">Boneka</a></li>
                    <li><a href="{{ route('produk.index', ['kategori' => 'Aksesoris']) }}" class="text-white text-decoration-none">Aksesoris</a></li>
                </ul>
            </div>
            
            <!-- Kontak WhatsApp -->
            <div class="col-md-4">
                <h5 class="fw-bold mb-3">Hubungi Kami</h5>
                <a href="https://wa.me/6281234567890" target="_blank" 
                   class="btn btn-light btn-lg w-100">
                    📱 Chat WhatsApp
                </a>
                <p class="mt-3 mb-0">Senin - Sabtu: 09.00 - 18.00 WIB</p>
            </div>
        </div>
        
        <hr class="my-4 bg-white">
        
        <div class="text-center">
            <p class="mb-0">&copy; 2025 DefaCraftStore. All Rights Reserved.</p>
        </div>
    </div>
</footer>