@extends('layouts.app')

@section('title', 'Profil Saya - DefaCraftStore')

@push('styles')
    @vite(['resources/css/profile-edit.css'])
@endpush

@section('content')
<div class="pf-page">
<div class="pf-wrap">

    {{-- Title — sama kaya "Semua Produk" --}}
    <h1 style="font-family:'Plus Jakarta Sans',sans-serif;font-size:1.4rem;font-weight:800;color:#333;position:relative;display:inline-block;padding-bottom:0.5rem;margin-bottom:1.5rem;">
        My Profile
        <span style="position:absolute;bottom:0;left:0;width:60px;height:4px;background:linear-gradient(135deg,#FEF9C3,#EAB308,#FACC15);border-radius:4px;display:block;"></span>
    </h1>

    {{-- Alerts --}}
    @if(session('status') === 'profile-updated')
        <div class="pf-alert pf-alert-ok">
            ✅ Profil berhasil diperbarui!
            <button class="pf-alert-close" onclick="this.parentElement.remove()">✕</button>
        </div>
    @endif
    @if(session('status') === 'password-updated')
        <div class="pf-alert pf-alert-ok">
            🔐 Password berhasil diubah!
            <button class="pf-alert-close" onclick="this.parentElement.remove()">✕</button>
        </div>
    @endif

    {{-- Profile Hero Card --}}
    <div class="pf-hero">
        <div class="pf-hero-top">
            <svg class="pf-hero-wave" viewBox="0 0 1200 20" preserveAspectRatio="none">
                <path d="M0,12 C300,20 600,4 900,12 C1050,16 1150,8 1200,12 L1200,20 L0,20 Z" fill="#ffffff"/>
            </svg>
        </div>
        <div class="pf-hero-body">
            <div class="pf-avatar-wrap">
                <div class="pf-avatar">
                    @if($user->foto_profil ?? false)
                        <img src="{{ asset('images/profil/' . $user->foto_profil) }}" alt="Foto">
                    @else
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    @endif
                </div>
                <div class="pf-avatar-edit">📷</div>
            </div>
            <div class="pf-hero-info">
                <div class="pf-name">{{ $user->name }}</div>
                <div class="pf-email">{{ $user->email }}</div>
                <div class="pf-meta-row">
                    <span class="pf-role-badge {{ $user->role === 'admin' ? 'pf-role-admin' : 'pf-role-user' }}">
                        {{ $user->role === 'admin' ? '👑 Admin' : '🛍️ Member' }}
                    </span>
                    <span class="pf-since">📅 Bergabung {{ $user->created_at->format('M Y') }}</span>
                </div>
            </div>
        </div>
    </div>



    {{-- Quick Actions --}}
    <div class="pf-actions-row">
        <a href="{{ route('transaksi.riwayat') }}" class="pf-action">
            <span class="pf-action-icon">📦</span>
            <span class="pf-action-text">Pesanan</span>
           
        </a>
        <a href="{{ route('wishlist.index') }}" class="pf-action">
            <span class="pf-action-icon">❤️</span>
            <span class="pf-action-text">Wishlist</span>
            
        </a>
        <a href="{{ route('keranjang.index') }}" class="pf-action">
            <span class="pf-action-icon">🛒</span>
            <span class="pf-action-text">Keranjang</span>
        </a>
        <a href="{{ route('produk.index') }}" class="pf-action">
            <span class="pf-action-icon">🛍️</span>
            <span class="pf-action-text">Belanja</span>
        </a>
    </div>

    {{-- Stats Row --}}
    <div class="pf-stats-row">
        <div class="pf-stat-card">
           
            <div class="pf-stat-num">{{ $totalPesanan }}</div>
            <div class="pf-stat-label">Pesanan</div>
        </div>
        <div class="pf-stat-card">
           
            <div class="pf-stat-num">{{ $totalSelesai }}</div>
            <div class="pf-stat-label">Selesai</div>
        </div>
        <div class="pf-stat-card">
            
            <div class="pf-stat-num">{{ $totalWishlist }}</div>
            <div class="pf-stat-label">Wishlist</div>
        </div>
        <div class="pf-stat-card">
            
            <div class="pf-stat-num" style="font-size:{{ $totalBelanja >= 1000000 ? '0.95rem' : '1.15rem' }};">
                {{ $totalBelanja >= 1000000 ? 'Rp'.number_format($totalBelanja/1000000,1).'jt' : 'Rp'.number_format($totalBelanja/1000,0).'rb' }}
            </div>
            <div class="pf-stat-label">Total Belanja</div>
        </div>
    </div>

    {{-- Body: Sidebar + Form --}}
    <div class="pf-body">
        <div class="pf-sidebar">
            <div class="pf-sidebar-inner">
                <button class="pf-tab active" onclick="pfGo('info', this)">
                    <span class="pf-tab-icon">👤</span> Info
                </button>
                <button class="pf-tab" onclick="pfGo('password', this)">
                    <span class="pf-tab-icon">🔐</span> Password
                </button>
                <button class="pf-tab" onclick="pfGo('danger', this)">
                    <span class="pf-tab-icon">⚠️</span> Akun
                </button>
            </div>
        </div>

        <div class="pf-form-area">
            {{-- INFO --}}
            <div class="pf-form-card active" id="pf-info">
                <div class="pf-form-title">Edit Informasi Profil</div>
                <div class="pf-form-desc">Perbarui data pribadi akun kamu di sini.</div>
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf @method('PATCH')
                    <div class="pf-field">
                        <label class="pf-label">Nama Lengkap</label>
                        <input type="text" name="name" class="pf-input @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                        @error('name')<span class="pf-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="pf-field">
                        <label class="pf-label">Email</label>
                        <input type="email" name="email" class="pf-input @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                        @error('email')<span class="pf-error">{{ $message }}</span>@enderror
                        @if($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                            <div class="pf-verify-warn">⚠️ Email belum diverifikasi. <a href="{{ route('verification.send') }}">Kirim ulang</a></div>
                        @endif
                    </div>
                    <div class="pf-field">
                        <label class="pf-label">Nomor WhatsApp</label>
                        <input type="text" name="nomor_wa" class="pf-input @error('nomor_wa') is-invalid @enderror" value="{{ old('nomor_wa', $user->nomor_wa ?? '') }}" placeholder="08xxxxxxxxxx">
                        @error('nomor_wa')<span class="pf-error">{{ $message }}</span>@enderror
                        <div class="pf-input-hint">Digunakan untuk notifikasi pesanan via WhatsApp.</div>
                    </div>
                    <div class="pf-field">
                        <label class="pf-label">Bergabung Sejak</label>
                        <input type="text" class="pf-input" value="{{ $user->created_at->format('d F Y') }}" disabled>
                    </div>
                    <button type="submit" class="pf-btn pf-btn-primary pf-btn-full" style="margin-top:0.5rem;">💾 Simpan Perubahan</button>
                </form>
            </div>

            {{-- PASSWORD --}}
            <div class="pf-form-card" id="pf-password">
                <div class="pf-form-title">Ganti Password</div>
                <div class="pf-form-desc">Pastikan password baru kuat dan berbeda dari sebelumnya.</div>
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf @method('PUT')
                    <div class="pf-field">
                        <label class="pf-label">Password Saat Ini</label>
                        <input type="password" name="current_password" class="pf-input @error('current_password', 'updatePassword') is-invalid @enderror" autocomplete="current-password" placeholder="Masukkan password lama">
                        @error('current_password', 'updatePassword')<span class="pf-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="pf-field">
                        <label class="pf-label">Password Baru</label>
                        <input type="password" name="password" class="pf-input @error('password', 'updatePassword') is-invalid @enderror" autocomplete="new-password" placeholder="Minimal 8 karakter">
                        @error('password', 'updatePassword')<span class="pf-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="pf-field">
                        <label class="pf-label">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="pf-input" autocomplete="new-password" placeholder="Ulangi password baru">
                    </div>
                    <button type="submit" class="pf-btn pf-btn-primary pf-btn-full" style="margin-top:0.5rem;">🔐 Ubah Password</button>
                </form>
            </div>

            {{-- DANGER --}}
            <div class="pf-form-card" id="pf-danger">
                <div class="pf-form-title" style="color:#E53935;">⚠️ Zona Berbahaya</div>
                <div class="pf-form-desc">Tindakan di sini tidak bisa dibatalkan.</div>
                <div class="pf-danger-box">
                    <p>🗑️ Menghapus akun akan menghilangkan seluruh data secara permanen — termasuk riwayat pesanan, wishlist, dan informasi profil kamu.</p>
                    <button type="button" class="pf-btn pf-btn-red pf-btn-full" onclick="document.getElementById('pfDelModal').classList.add('show')">Hapus Akun Saya</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Orders Preview --}}
    <div class="pf-recent-section">
        <div class="pf-section-title">
            Pesanan Terakhir
            <a href="{{ route('transaksi.riwayat') }}">Lihat Semua →</a>
        </div>
        @if($recentOrders->isEmpty())
            <div class="pf-empty-state"><span>📦</span>Belum ada pesanan</div>
        @else
            <div class="pf-recent-list">
                @foreach($recentOrders as $order)
                @php
                    $firstDetail = $order->details->first();
                    $bgClass = '';
                    switch($order->status) {
                        case 'pending':
                        case 'paid': $bgClass = 'pf-recent-badge-pending'; break;
                        case 'processing':
                        case 'shipped': $bgClass = 'pf-recent-badge-shipped'; break;
                        case 'completed': $bgClass = 'pf-recent-badge-completed'; break;
                        case 'cancelled':
                        case 'expired': $bgClass = 'pf-recent-badge-cancelled'; break;
                    }
                @endphp
                <a href="{{ route('transaksi.show', $order->id) }}" class="pf-recent-item">
                    @if($firstDetail && $firstDetail->produk && $firstDetail->produk->gambar && file_exists(public_path('images/produk/' . $firstDetail->produk->gambar)))
                        <img src="{{ asset('images/produk/' . $firstDetail->produk->gambar) }}" class="pf-recent-img" alt="">
                    @else
                        <div class="pf-recent-img-ph">📦</div>
                    @endif
                    <div class="pf-recent-info">
                        <div class="pf-recent-name">{{ $firstDetail->nama_produk ?? 'Produk' }}{{ $order->details->count() > 1 ? ' +' . ($order->details->count() - 1) : '' }}</div>
                        <div class="pf-recent-meta">#{{ $order->id }} · {{ $order->created_at->format('d M Y') }}</div>
                    </div>
                    <span class="pf-recent-badge {{ $bgClass }}">{{ ucfirst($order->status) }}</span>
                    <span class="pf-recent-price">Rp{{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </a>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Tips Cards --}}
    <div class="pf-tips-grid">
        <div class="pf-tip-card">
            <span class="pf-tip-icon">🔒</span>
            <div class="pf-tip-title">Keamanan Akun</div>
            <div class="pf-tip-desc">Gunakan password yang kuat dan jangan bagikan ke siapapun.</div>
        </div>
        <div class="pf-tip-card">
            <span class="pf-tip-icon">📱</span>
            <div class="pf-tip-title">Notifikasi WA</div>
            <div class="pf-tip-desc">Tambahkan nomor WhatsApp untuk update pesanan real-time.</div>
        </div>
        <div class="pf-tip-card">
            <span class="pf-tip-icon">⭐</span>
            <div class="pf-tip-title">Review Produk</div>
            <div class="pf-tip-desc">Bantu pembeli lain dengan review produk yang sudah kamu beli.</div>
        </div>
    </div>

</div>
</div>

{{-- Delete Modal --}}
<div class="pf-modal-bg" id="pfDelModal">
    <div class="pf-modal">
        <div class="pf-modal-head">
            <h5>⚠️ Konfirmasi Hapus</h5>
            <button class="pf-modal-x" onclick="document.getElementById('pfDelModal').classList.remove('show')">✕</button>
        </div>
        <div class="pf-modal-body">
            <p>Ketik password untuk melanjutkan penghapusan akun.</p>
            <form method="POST" action="{{ route('profile.destroy') }}" id="pfDelForm">
                @csrf @method('DELETE')
                <div class="pf-field" style="margin-bottom:0;">
                    <input type="password" name="password" class="pf-input @error('password', 'userDeletion') is-invalid @enderror" placeholder="Password kamu" required>
                    @error('password', 'userDeletion')<span class="pf-error">{{ $message }}</span>@enderror
                </div>
            </form>
        </div>
        <div class="pf-modal-foot">
            <button class="pf-btn pf-btn-ghost pf-btn-sm" onclick="document.getElementById('pfDelModal').classList.remove('show')">Batal</button>
            <button type="submit" form="pfDelForm" class="pf-btn pf-btn-sm" style="background:#E53935;color:#fff;">Hapus Akun</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function pfGo(tab, btn) {
    document.querySelectorAll('.pf-form-card').forEach(c => c.classList.remove('active'));
    document.querySelectorAll('.pf-tab').forEach(b => b.classList.remove('active'));
    document.getElementById('pf-' + tab).classList.add('active');
    btn.classList.add('active');
}
document.getElementById('pfDelModal').addEventListener('click', function(e) {
    if (e.target === this) this.classList.remove('show');
});
@if($errors->updatePassword->any())
document.addEventListener('DOMContentLoaded', function() { pfGo('password', document.querySelectorAll('.pf-tab')[1]); });
@endif
@if($errors->userDeletion->any())
document.addEventListener('DOMContentLoaded', function() {
    pfGo('danger', document.querySelectorAll('.pf-tab')[2]);
    document.getElementById('pfDelModal').classList.add('show');
});
@endif
</script>
@endpush