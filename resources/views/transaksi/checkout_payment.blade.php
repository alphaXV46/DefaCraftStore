@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5 text-center">
    <div class="card shadow-sm p-5" style="border-radius: 20px; border: none; background: #f8faff;">
        <h2 class="fw-bold text-primary">Selesaikan Pembayaran ✨</h2>
        <p class="text-muted">Pesanan <strong>#{{ $transaksi->id }}</strong> berhasil dibuat.</p>
        
        <div class="my-4">
            <h4 class="mb-1">Total Bayar:</h4>
            <h2 class="text-dark fw-bold">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</h2>
        </div>

        <button id="pay-button" class="btn btn-primary btn-lg px-5 shadow" style="border-radius: 50px;">
            Bayar Sekarang (QRIS)
        </button>
        
        <p class="mt-4 text-muted small">Jika popup tidak muncul, klik tombol di atas.</p>
    </div>
</div>

<script src="{{ config('services.midtrans.snap_url') }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>

<script type="text/javascript">
    const payButton = document.getElementById('pay-button');
    
    function triggerSnap() {
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){ window.location.href = "{{ route('transaksi.success') }}"; },
            onPending: function(result){ window.location.href = "{{ route('transaksi.riwayat') }}"; },
            onError: function(result){ alert("Pembayaran gagal!"); },
            onClose: function(){ alert('Silakan selesaikan pembayaran di menu Riwayat.'); }
        });
    }

    // Jalankan otomatis saat halaman terbuka
    window.onload = triggerSnap;
    payButton.onclick = triggerSnap;
</script>
@endsection