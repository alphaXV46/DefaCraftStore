@extends('layouts.app')

@section('title', 'Syarat & Ketentuan - DefaCraftStore')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card shadow-sm border-0" style="border-radius: 16px;">
                <div class="card-body p-4 p-md-5">
                    <h1 class="fw-bold mb-2" style="color: #4A3F5C;">Syarat & Ketentuan</h1>
                    <p class="text-muted mb-4"><small>Terakhir diperbarui: 19 Mei 2025</small></p>

                    <p>Selamat datang di <strong>DefaCraftStore</strong>. Dengan mengakses dan menggunakan layanan situs web kami di <strong>defacraftstore.biz.id</strong>, Anda dianggap telah membaca, memahami, dan menyetujui seluruh Syarat & Ketentuan yang berlaku di bawah ini. Jika Anda tidak menyetujui ketentuan ini, harap hentikan penggunaan layanan kami.</p>

                    <hr class="my-4">

                    <h5 class="fw-bold mt-4">1. Batasan Umur Pengguna</h5>
                    <p>Layanan DefaCraftStore hanya diperuntukkan bagi pengguna yang berusia <strong>minimal 13 tahun</strong>. Bagi pengguna di bawah umur 18 tahun, penggunaan layanan ini harus dilakukan atas sepengetahuan dan persetujuan orang tua atau wali yang sah. Kami berhak menangguhkan akun yang terbukti dibuat oleh anak di bawah umur tanpa pengawasan orang tua.</p>

                    <h5 class="fw-bold mt-4">2. Pembuatan & Keamanan Akun</h5>
                    <ul>
                        <li>Anda wajib memberikan informasi yang <strong>akurat, terkini, dan lengkap</strong> saat mendaftar akun.</li>
                        <li>Anda bertanggung jawab sepenuhnya atas kerahasiaan kata sandi dan semua aktivitas yang terjadi di bawah akun Anda.</li>
                        <li>Dilarang keras membuat lebih dari satu akun untuk satu orang yang sama.</li>
                        <li>Kami berhak menangguhkan atau menghapus akun yang terbukti melakukan penipuan, penyalahgunaan, atau pelanggaran ketentuan ini.</li>
                    </ul>

                    <h5 class="fw-bold mt-4">3. Produk & Hak Kekayaan Intelektual</h5>
                    <ul>
                        <li>Seluruh produk yang dijual di DefaCraftStore, termasuk seri Blind Box, Boneka, dan Action Figure, adalah produk yang dipasarkan secara sah.</li>
                        <li>Nama merek, logo, desain, dan seluruh konten pada situs web ini adalah milik DefaCraftStore dan dilindungi oleh hukum hak cipta yang berlaku. Dilarang menyalin, mendistribusikan, atau menggunakan konten tanpa izin tertulis dari kami.</li>
                        <li>Foto produk yang kami tampilkan adalah representasi aktual dari produk yang dijual. Meski demikian, tampilan warna aktual dapat sedikit berbeda tergantung pada pengaturan layar perangkat Anda.</li>
                    </ul>

                    <h5 class="fw-bold mt-4">4. Harga & Pembayaran</h5>
                    <ul>
                        <li>Semua harga yang tertera di situs sudah dalam satuan <strong>Rupiah (IDR)</strong> dan belum termasuk ongkos kirim.</li>
                        <li>Kami berhak mengubah harga produk sewaktu-waktu tanpa pemberitahuan sebelumnya. Namun, perubahan harga tidak berlaku untuk pesanan yang sudah dikonfirmasi.</li>
                        <li>Pembayaran diproses melalui platform Midtrans yang aman dan terenkripsi.</li>
                    </ul>

                    <h5 class="fw-bold mt-4">5. Pemesanan & Pembatalan</h5>
                    <ul>
                        <li>Pesanan dianggap sah setelah pembayaran berhasil dikonfirmasi oleh sistem.</li>
                        <li>Invoice pembayaran memiliki batas waktu kedaluwarsa <strong>24 jam</strong>. Pesanan yang tidak dibayar dalam batas waktu tersebut akan otomatis dibatalkan.</li>
                        <li>Pembatalan oleh pembeli setelah pembayaran dikonfirmasi tidak dapat dilakukan, kecuali terdapat kesalahan pada pihak toko (barang tidak tersedia/stok habis).</li>
                    </ul>

                    <h5 class="fw-bold mt-4">6. Penyelesaian Sengketa Transaksi</h5>
                    <p>Jika terjadi perselisihan atau sengketa terkait transaksi, kami mengutamakan penyelesaian secara <strong>musyawarah mufakat</strong>. Pengguna dapat menghubungi tim dukungan kami melalui halaman <a href="{{ route('bantuan.kontak') }}" class="text-primary fw-bold text-decoration-none">Kontak Kami</a>. Apabila penyelesaian secara damai tidak tercapai dalam jangka waktu 30 hari kalender, maka penyelesaian akan dilakukan sesuai dengan hukum yang berlaku di Republik Indonesia.</p>

                    <h5 class="fw-bold mt-4">7. Perubahan Ketentuan</h5>
                    <p>DefaCraftStore berhak mengubah Syarat & Ketentuan ini kapan saja. Perubahan akan diberitahukan melalui pembaruan tanggal di halaman ini. Dengan terus menggunakan layanan kami setelah perubahan diterbitkan, Anda dianggap menyetujui ketentuan yang baru.</p>

                    <hr class="my-4">
                    <p class="text-muted mb-0">Jika Anda memiliki pertanyaan mengenai Syarat & Ketentuan ini, silakan hubungi kami di <a href="{{ route('bantuan.kontak') }}" class="text-primary fw-bold text-decoration-none">halaman Kontak Kami</a>.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
