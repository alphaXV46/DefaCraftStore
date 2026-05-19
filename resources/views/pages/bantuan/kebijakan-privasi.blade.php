@extends('layouts.app')

@section('title', 'Kebijakan Privasi - DefaCraftStore')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card shadow-sm border-0" style="border-radius: 16px;">
                <div class="card-body p-4 p-md-5">
                    <h1 class="fw-bold mb-2" style="color: #4A3F5C;">Kebijakan Privasi</h1>
                    <p class="text-muted mb-4"><small>Terakhir diperbarui: 19 Mei 2025</small></p>

                    <p>Di <strong>DefaCraftStore</strong>, kami sangat menghargai privasi dan keamanan data pribadi Anda. Kebijakan Privasi ini menjelaskan informasi apa yang kami kumpulkan, bagaimana kami menggunakannya, dan langkah-langkah yang kami ambil untuk melindunginya saat Anda menggunakan layanan kami di <strong>defacraftstore.biz.id</strong>.</p>

                    <hr class="my-4">

                    <h5 class="fw-bold mt-4">1. Informasi yang Kami Kumpulkan</h5>
                    <p>Saat Anda mendaftar atau berbelanja di DefaCraftStore, kami mengumpulkan informasi berikut:</p>
                    <ul>
                        <li><strong>Data Identitas:</strong> Nama lengkap dan alamat email.</li>
                        <li><strong>Data Kontak:</strong> Nomor telepon/WhatsApp aktif.</li>
                        <li><strong>Data Pengiriman:</strong> Alamat lengkap (provinsi, kota, kecamatan, kode pos, dan detail rumah) untuk keperluan pengiriman pesanan.</li>
                        <li><strong>Data Transaksi:</strong> Riwayat pembelian, detail produk yang dipesan, dan status pembayaran. Kami <strong>tidak</strong> menyimpan informasi kartu kredit/debit Anda — seluruh data pembayaran diproses secara aman oleh pihak ketiga (Midtrans).</li>
                        <li><strong>Data Teknis:</strong> Alamat IP dan jenis peramban (browser) yang digunakan untuk keperluan keamanan dan analitik situs.</li>
                    </ul>

                    <h5 class="fw-bold mt-4">2. Cara Kami Menggunakan Informasi Anda</h5>
                    <p>Data yang kami kumpulkan digunakan <strong>semata-mata</strong> untuk keperluan berikut:</p>
                    <ul>
                        <li>Memproses dan mengirimkan pesanan Anda ke alamat yang benar.</li>
                        <li>Menghubungi Anda terkait konfirmasi pesanan, status pengiriman, atau kendala transaksi.</li>
                        <li>Meningkatkan kualitas layanan dan pengalaman berbelanja di platform kami.</li>
                        <li>Mencegah dan mendeteksi aktivitas penipuan atau penyalahgunaan layanan.</li>
                    </ul>

                    <div class="alert d-flex gap-3 mt-4" style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px;">
                        <span style="font-size: 1.5rem;"><i class="fas fa-lock"></i></span>
                        <div>
                            <strong style="color: #166534;">Komitmen Perlindungan Data Anda</strong>
                            <p class="mb-0 mt-1" style="color: #15803d;">Kami berkomitmen penuh bahwa nama, alamat, nomor HP, dan alamat email Anda <strong>tidak akan pernah dijual, dipinjamkan, atau dibagikan kepada pihak ketiga mana pun</strong> untuk tujuan komersial atau pemasaran tanpa izin eksplisit dari Anda.</p>
                        </div>
                    </div>

                    <h5 class="fw-bold mt-4">3. Berbagi Data dengan Pihak Ketiga</h5>
                    <p>Data Anda hanya dapat dibagikan kepada pihak-pihak berikut <strong>yang secara langsung mendukung layanan kami</strong>:</p>
                    <ul>
                        <li><strong>Jasa Pengiriman (JNE, TIKI, POS Indonesia):</strong> Nama dan alamat pengiriman Anda akan diberikan kepada kurir yang dipilih untuk memastikan paket sampai ke tangan Anda.</li>
                        <li><strong>Midtrans (Gateway Pembayaran):</strong> Data transaksi dasar (nama, email, total pembayaran) digunakan untuk memproses pembayaran Anda dengan aman.</li>
                        <li><strong>Pihak Hukum:</strong> Kami dapat mengungkapkan data jika diwajibkan oleh hukum, peraturan, atau perintah pengadilan yang berlaku di Republik Indonesia.</li>
                    </ul>

                    <h5 class="fw-bold mt-4">4. Keamanan Data</h5>
                    <p>Kami menerapkan langkah-langkah keamanan teknis yang wajar untuk melindungi data Anda dari akses tidak sah, pengungkapan, perubahan, atau penghancuran, termasuk enkripsi HTTPS pada seluruh koneksi ke situs kami.</p>

                    <h5 class="fw-bold mt-4">5. Hak Anda Atas Data Pribadi</h5>
                    <p>Anda memiliki hak untuk:</p>
                    <ul>
                        <li><strong>Mengakses</strong> informasi pribadi yang kami simpan tentang Anda melalui halaman profil akun.</li>
                        <li><strong>Memperbarui atau mengoreksi</strong> data pribadi Anda kapan saja.</li>
                        <li><strong>Meminta penghapusan</strong> akun dan data Anda dengan menghubungi tim kami melalui <a href="{{ route('bantuan.kontak') }}" class="text-primary fw-bold text-decoration-none">Kontak Kami</a>.</li>
                    </ul>

                    <h5 class="fw-bold mt-4">6. Cookie</h5>
                    <p>Situs kami menggunakan cookie untuk menjaga sesi login Anda tetap aktif dan meningkatkan fungsionalitas situs. Cookie ini bersifat <strong>esensial</strong> dan tidak digunakan untuk melacak aktivitas Anda di situs web pihak lain.</p>

                    <h5 class="fw-bold mt-4">7. Perubahan Kebijakan Privasi</h5>
                    <p>Kami dapat memperbarui Kebijakan Privasi ini dari waktu ke waktu. Setiap perubahan yang signifikan akan diberitahukan kepada Anda melalui pembaruan tanggal di halaman ini. Kami mendorong Anda untuk meninjau halaman ini secara berkala.</p>

                    <hr class="my-4">
                    <p class="text-muted mb-0">Jika Anda memiliki pertanyaan, kekhawatiran, atau permintaan terkait privasi data Anda, jangan ragu untuk menghubungi kami di <a href="{{ route('bantuan.kontak') }}" class="text-primary fw-bold text-decoration-none">halaman Kontak Kami</a>.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
