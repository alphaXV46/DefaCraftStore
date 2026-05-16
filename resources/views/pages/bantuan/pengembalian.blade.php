@extends('layouts.app')

@section('title', 'Kebijakan Pengembalian - DefaCraftStore')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0" style="border-radius: 16px;">
                <div class="card-body p-4 p-md-5">
                    <h2 class="fw-bold mb-4" style="color: #4A3F5C;">Kebijakan Pengembalian (Return Policy)</h2>
                    
                    <p>Di DefaCraftStore, kepuasan Anda adalah prioritas kami. Jika Anda menerima barang yang cacat atau tidak sesuai dengan pesanan, Anda dapat mengajukan pengembalian dengan syarat dan ketentuan berikut:</p>
                    
                    <h5 class="fw-bold mt-4">1. Syarat Pengembalian</h5>
                    <ul>
                        <li>Pengajuan pengembalian maksimal <strong>3x24 jam</strong> setelah barang berstatus "Diterima".</li>
                        <li>Barang harus dalam kondisi awal, belum dipakai, belum dicuci, dan tag/label masih utuh.</li>
                        <li>Harus menyertakan <strong>video unboxing</strong> tanpa jeda/potongan sebagai bukti kerusakan atau ketidaksesuaian.</li>
                    </ul>

                    <h5 class="fw-bold mt-4">2. Barang yang Tidak Dapat Dikembalikan</h5>
                    <ul>
                        <li>Barang rusak akibat kesalahan pemakaian oleh pembeli.</li>
                        <li>Produk custom/pesanan khusus yang sudah disetujui desainnya sebelum dikirim.</li>
                        <li>Pengajuan tanpa video unboxing.</li>
                    </ul>

                    <h5 class="fw-bold mt-4">3. Proses Refund / Penukaran</h5>
                    <p>Setelah pengajuan disetujui, Anda dapat memilih untuk:</p>
                    <ul>
                        <li><strong>Penukaran Barang:</strong> Kami akan mengirim ulang produk yang sesuai tanpa biaya tambahan.</li>
                        <li><strong>Refund Dana:</strong> Dana akan dikembalikan penuh ke rekening Anda dalam waktu 1-3 hari kerja.</li>
                    </ul>
                    
                    <hr class="my-4">
                    <p class="text-muted mb-0">Untuk mengajukan klaim pengembalian, silakan hubungi tim Support kami melalui menu <a href="{{ route('bantuan.kontak') }}" class="text-primary text-decoration-none fw-bold">Kontak Kami</a>.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
