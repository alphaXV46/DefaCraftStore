@extends('layouts.app')

@section('title', 'Profil Saya - DefaCraftStore')

@push('styles')
<style>
/* ===== BASE ===== */
.pf-page {
    font-family: 'Inter', -apple-system, sans-serif;
    color: #333;
    line-height: 1.6;
    background: #FFFFFF;
    min-height: 100vh;
    padding: 0;
    -webkit-font-smoothing: antialiased;
}
.pf-page *, .pf-page *::before, .pf-page *::after { box-sizing: border-box; }

.pf-wrap {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem 3rem;
}

/* ===== ALERTS ===== */
.pf-alert {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    padding: 0.85rem 1rem;
    border-radius: 12px;
    font-size: 0.88rem;
    font-weight: 600;
    margin-bottom: 1.25rem;
}
.pf-alert-ok { background: #ECFDF5; color: #065F46; border-left: 4px solid #34D399; }
.pf-alert-close {
    margin-left: auto;
    background: none;
    border: none;
    font-size: 1rem;
    cursor: pointer;
    opacity: 0.5;
    color: inherit;
    padding: 0;
}
.pf-alert-close:hover { opacity: 1; }

/* ===== PROFILE HERO ===== */
.pf-hero {
    background: #FAFAFA;
    border-radius: 24px;
    overflow: hidden;
    margin-bottom: 1.5rem;
    border: 1px solid rgba(0,0,0,0.06);
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
}
.pf-hero-top {
    height: 120px;
    background: linear-gradient(135deg, #FFFBEB 0%, #FEF3C7 50%, #FDF2F8 100%);
    position: relative;
    overflow: hidden;
}
.pf-hero-top::before {
    content: '';
    position: absolute;
    width: 400px;
    height: 400px;
    background: rgba(234,179,8,0.06);
    border-radius: 50%;
    top: -250px;
    right: -100px;
}
.pf-hero-top::after {
    content: '';
    position: absolute;
    width: 250px;
    height: 250px;
    background: rgba(234,179,8,0.04);
    border-radius: 50%;
    bottom: -150px;
    left: -60px;
}
.pf-hero-wave {
    position: absolute;
    bottom: -1px;
    left: 0;
    width: 100%;
    height: 20px;
}

.pf-hero-body {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 0 1.5rem 1.5rem;
    margin-top: -48px;
    position: relative;
    z-index: 2;
}

/* Avatar */
.pf-avatar-wrap { position: relative; flex-shrink: 0; }
.pf-avatar {
    width: 96px;
    height: 96px;
    border-radius: 50%;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    font-size: 1.8rem;
    font-weight: 800;
    color: #EAB308;
    font-family: 'Plus Jakarta Sans', sans-serif;
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    border: 4px solid #fff;
}
.pf-avatar img { width: 100%; height: 100%; object-fit: cover; }
.pf-avatar-edit {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: linear-gradient(135deg, #EAB308, #CA8A04);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.65rem;
    border: 3px solid #fff;
    box-shadow: 0 2px 6px rgba(0,0,0,0.12);
    cursor: pointer;
    transition: transform 0.2s;
}
.pf-avatar-edit:hover { transform: scale(1.12); }

.pf-hero-info {
    text-align: center;
    margin-top: 0.75rem;
}
.pf-name {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 1.3rem;
    font-weight: 800;
    color: #1a1a1a;
    line-height: 1.2;
}
.pf-email { font-size: 0.85rem; color: #999; margin-top: 0.15rem; }
.pf-meta-row {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    margin-top: 0.5rem;
    flex-wrap: wrap;
}
.pf-role-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.2rem 0.75rem;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 700;
}
.pf-role-admin { background: #EDE7F6; color: #5E35B1; }
.pf-role-user { background: #FFFBEB; color: #A16207; border: 1px solid rgba(234,179,8,0.15); }
.pf-since { font-size: 0.75rem; color: #bbb; }

/* ===== QUICK ACTIONS ===== */
.pf-actions-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}
.pf-action {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.4rem;
    padding: 1rem 0.5rem;
    background: #fff;
    border-radius: 16px;
    text-decoration: none;
    border: 1.5px solid rgba(0,0,0,0.06);
    transition: all 0.25s;
    box-shadow: 0 1px 4px rgba(0,0,0,0.03);
}
.pf-action:hover {
    border-color: rgba(234,179,8,0.25);
    box-shadow: 0 6px 20px rgba(234,179,8,0.08);
    transform: translateY(-3px);
}
.pf-action-icon { font-size: 1.5rem; }
.pf-action-text { font-size: 0.8rem; font-weight: 700; color: #555; }
.pf-action-count {
    font-size: 0.65rem;
    font-weight: 800;
    background: #FFFBEB;
    color: #A16207;
    padding: 0.1rem 0.5rem;
    border-radius: 50px;
    border: 1px solid rgba(234,179,8,0.12);
}

/* ===== STATS ROW ===== */
.pf-stats-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}
.pf-stat-card {
    background: #fff;
    border-radius: 16px;
    padding: 1.15rem;
    text-align: center;
    border: 1.5px solid rgba(0,0,0,0.06);
    box-shadow: 0 1px 4px rgba(0,0,0,0.03);
    transition: all 0.25s;
    position: relative;
    overflow: hidden;
}
.pf-stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    border-radius: 3px 3px 0 0;
}
.pf-stat-card:nth-child(1)::before { background: linear-gradient(135deg, #EAB308, #FACC15); }
.pf-stat-card:nth-child(2)::before { background: linear-gradient(135deg, #34D399, #6EE7B7); }
.pf-stat-card:nth-child(3)::before { background: linear-gradient(135deg, #FACC15, #EAB308); }
.pf-stat-card:nth-child(4)::before { background: linear-gradient(135deg, #60A5FA, #93C5FD); }
.pf-stat-card:hover { transform: translateY(-2px); box-shadow: 0 4px 14px rgba(0,0,0,0.06); }
.pf-stat-icon { font-size: 1.25rem; margin-bottom: 0.3rem; display: block; }
.pf-stat-num {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 1.3rem;
    font-weight: 800;
    color: #333;
    line-height: 1.1;
}
.pf-stat-card:nth-child(1) .pf-stat-num { color: #A16207; }
.pf-stat-card:nth-child(2) .pf-stat-num { color: #065F46; }
.pf-stat-card:nth-child(3) .pf-stat-num { color: #A16207; }
.pf-stat-card:nth-child(4) .pf-stat-num { color: #1E40AF; }
.pf-stat-label {
    font-size: 0.7rem;
    color: #aaa;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin-top: 0.15rem;
}

/* ===== DESKTOP GRID: SIDEBAR + MAIN ===== */
.pf-body {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}
.pf-sidebar { width: 100%; flex-shrink: 0; }
.pf-form-area { flex: 1; min-width: 0; }

/* Sidebar tabs — horizontal on mobile, vertical on desktop */
.pf-sidebar-inner {
    background: #fff;
    border-radius: 16px;
    padding: 0.5rem;
    box-shadow: 0 1px 6px rgba(0,0,0,0.04);
    border: 1px solid rgba(0,0,0,0.06);
    display: flex;
    flex-direction: row;
    overflow-x: auto;
    gap: 0.25rem;
    scrollbar-width: none;
}
.pf-sidebar-inner::-webkit-scrollbar { display: none; }
.pf-tab {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.7rem 1rem;
    border-radius: 10px;
    font-size: 0.88rem;
    font-weight: 600;
    color: #999;
    cursor: pointer;
    transition: all 0.15s;
    white-space: nowrap;
    border: none;
    background: none;
    font-family: 'Inter', sans-serif;
    width: 100%;
    text-align: left;
}
.pf-tab:hover { color: #EAB308; background: #FFFBEB; }
.pf-tab.active {
    color: #fff;
    background: linear-gradient(135deg, #EAB308, #CA8A04);
    box-shadow: 0 3px 10px rgba(234,179,8,0.2);
}
.pf-tab-icon { font-size: 1rem; flex-shrink: 0; }

/* Form cards */
.pf-form-card {
    background: #fff;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 1px 6px rgba(0,0,0,0.04);
    border: 1px solid rgba(0,0,0,0.06);
    display: none;
}
.pf-form-card.active { display: block; }
.pf-form-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 1.1rem;
    font-weight: 700;
    color: #222;
    margin-bottom: 0.3rem;
}
.pf-form-desc { font-size: 0.82rem; color: #aaa; margin-bottom: 1.5rem; }

/* Fields */
.pf-field { margin-bottom: 1.25rem; }
.pf-label {
    display: block;
    font-size: 0.78rem;
    font-weight: 700;
    color: #888;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    margin-bottom: 0.4rem;
}
.pf-input {
    display: block;
    width: 100%;
    padding: 0.8rem 1rem;
    border: 1.5px solid #EAEAEA;
    border-radius: 12px;
    font-size: 0.92rem;
    color: #333;
    background: #FAFAFA;
    transition: all 0.2s;
    font-family: 'Inter', sans-serif;
    line-height: 1.5;
}
.pf-input:focus {
    outline: none;
    border-color: #EAB308;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(234,179,8,0.08);
}
.pf-input:disabled { opacity: 0.35; cursor: not-allowed; background: #F5F5F5; }
.pf-input.is-invalid { border-color: #FF6B8A; }
.pf-error { display: block; font-size: 0.8rem; color: #FF6B8A; font-weight: 500; margin-top: 0.25rem; }
.pf-input::placeholder { color: #ccc; }
.pf-input-hint { font-size: 0.75rem; color: #bbb; margin-top: 0.25rem; }

/* Buttons */
.pf-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.4rem;
    padding: 0.8rem 1.75rem;
    border-radius: 12px;
    font-size: 0.92rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
    text-decoration: none;
    font-family: 'Inter', sans-serif;
}
.pf-btn-primary {
    background: linear-gradient(135deg, #EAB308, #CA8A04);
    color: #fff;
    box-shadow: 0 4px 14px rgba(234,179,8,0.2);
}
.pf-btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(234,179,8,0.3); }
.pf-btn-red {
    background: #fff;
    color: #E53935;
    border: 1.5px solid #E53935;
}
.pf-btn-red:hover { background: #E53935; color: #fff; }
.pf-btn-ghost { background: #F5F5F5; color: #777; }
.pf-btn-ghost:hover { background: #EEEEEE; color: #555; }
.pf-btn-sm { padding: 0.6rem 1.15rem; font-size: 0.85rem; }
.pf-btn-full { width: 100%; }

/* Danger zone */
.pf-danger-box {
    background: #FFF5F5;
    border: 1.5px solid rgba(229,57,53,0.12);
    border-radius: 14px;
    padding: 1.25rem;
    margin-top: 0.5rem;
}
.pf-danger-box p { font-size: 0.85rem; color: #888; margin-bottom: 1rem; line-height: 1.6; }

/* Modal */
.pf-modal-bg {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.35);
    backdrop-filter: blur(4px);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}
.pf-modal-bg.show { display: flex; }
.pf-modal {
    background: #fff;
    border-radius: 20px;
    width: 100%;
    max-width: 400px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.12);
    overflow: hidden;
    animation: pfModalIn 0.25s ease;
}
@keyframes pfModalIn {
    from { opacity: 0; transform: scale(0.95) translateY(10px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
}
.pf-modal-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #F0F0F0;
}
.pf-modal-head h5 { font-weight: 700; color: #E53935; margin: 0; font-size: 1rem; }
.pf-modal-x { background: none; border: none; font-size: 1.1rem; cursor: pointer; color: #bbb; padding: 0; }
.pf-modal-x:hover { color: #333; }
.pf-modal-body { padding: 1.25rem; }
.pf-modal-body p { color: #888; font-size: 0.88rem; margin-bottom: 1rem; }
.pf-modal-foot {
    display: flex;
    gap: 0.5rem;
    justify-content: flex-end;
    padding: 0.85rem 1.25rem;
    border-top: 1px solid #F0F0F0;
}

/* Email verify */
.pf-verify-warn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: #FFFBEB;
    border: 1px solid rgba(234,179,8,0.2);
    border-radius: 10px;
    padding: 0.6rem 0.8rem;
    margin-top: 0.4rem;
    font-size: 0.8rem;
    color: #7A6200;
}
.pf-verify-warn a { color: #A16207; font-weight: 700; text-decoration: none; }
.pf-verify-warn a:hover { text-decoration: underline; }

/* ===== RECENT ORDERS PREVIEW ===== */
.pf-recent-section {
    margin-top: 1.5rem;
}
.pf-section-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 1.05rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.pf-section-title a {
    font-size: 0.82rem;
    font-weight: 600;
    color: #EAB308;
    text-decoration: none;
    transition: color 0.2s;
}
.pf-section-title a:hover { color: #CA8A04; }
.pf-recent-list {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}
.pf-recent-item {
    display: flex;
    align-items: center;
    gap: 0.85rem;
    padding: 0.85rem 1rem;
    background: #fff;
    border-radius: 14px;
    border: 1.5px solid rgba(0,0,0,0.06);
    box-shadow: 0 1px 4px rgba(0,0,0,0.03);
    text-decoration: none;
    color: #333;
    transition: all 0.2s;
}
.pf-recent-item:hover {
    border-color: rgba(234,179,8,0.2);
    box-shadow: 0 4px 14px rgba(234,179,8,0.06);
    transform: translateX(4px);
}
.pf-recent-img {
    width: 52px;
    height: 52px;
    border-radius: 10px;
    object-fit: cover;
    border: 1px solid #f0f0f0;
    flex-shrink: 0;
}
.pf-recent-img-ph {
    width: 52px;
    height: 52px;
    border-radius: 10px;
    background: #FFFBEB;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
    border: 1px solid #f0f0f0;
}
.pf-recent-info { flex: 1; min-width: 0; }
.pf-recent-name {
    font-size: 0.88rem;
    font-weight: 600;
    color: #333;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.pf-recent-meta { font-size: 0.75rem; color: #aaa; margin-top: 0.1rem; }
.pf-recent-price {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 0.9rem;
    font-weight: 800;
    color: #333;
    flex-shrink: 0;
}
.pf-recent-badge {
    font-size: 0.65rem;
    font-weight: 700;
    padding: 0.15rem 0.5rem;
    border-radius: 50px;
    flex-shrink: 0;
}
.pf-recent-badge-pending { background: #FEF3C7; color: #92400E; }
.pf-recent-badge-completed { background: #ECFDF5; color: #065F46; }
.pf-recent-badge-shipped { background: #EFF6FF; color: #1E40AF; }
.pf-recent-badge-cancelled { background: #FEF2F2; color: #991B1B; }

.pf-empty-state {
    text-align: center;
    padding: 2rem;
    color: #bbb;
    font-size: 0.9rem;
}
.pf-empty-state span { font-size: 2rem; display: block; margin-bottom: 0.5rem; }

/* ===== ACTIVITY TIPS ===== */
.pf-tips-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0.75rem;
    margin-top: 1.5rem;
}
.pf-tip-card {
    background: #fff;
    border-radius: 14px;
    padding: 1.25rem;
    border: 1.5px solid rgba(0,0,0,0.06);
    box-shadow: 0 1px 4px rgba(0,0,0,0.03);
    text-align: center;
    transition: all 0.25s;
}
.pf-tip-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 14px rgba(0,0,0,0.06);
}
.pf-tip-icon { font-size: 1.5rem; margin-bottom: 0.4rem; display: block; }
.pf-tip-title {
    font-size: 0.82rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 0.2rem;
}
.pf-tip-desc { font-size: 0.72rem; color: #aaa; line-height: 1.4; }

/* ===== RESPONSIVE ===== */
@media (min-width: 768px) {
    .pf-hero-top { height: 160px; }
    .pf-hero-body {
        flex-direction: row;
        gap: 1.75rem;
        align-items: flex-end;
        padding: 0 2.5rem 2rem;
        margin-top: -60px;
    }
    .pf-hero-info { text-align: left; margin-top: 0; padding-bottom: 0.4rem; }
    .pf-meta-row { justify-content: flex-start; }
    .pf-avatar { width: 120px; height: 120px; font-size: 2.2rem; border-width: 5px; }
    .pf-body { flex-direction: row; align-items: flex-start; }
    .pf-sidebar { width: 200px; position: sticky; top: 80px; }
    .pf-sidebar-inner { flex-direction: column; overflow-x: visible; }
    .pf-form-card { padding: 2rem; }
    .pf-actions-row { gap: 1rem; }
    .pf-stats-row { gap: 1rem; }
    .pf-tips-grid { gap: 1rem; }
}

@media (max-width: 767px) {
    .pf-tab { justify-content: center; flex: 1; padding: 0.7rem 0.5rem; }
    .pf-stats-row { grid-template-columns: repeat(2, 1fr); }
    .pf-tips-grid { grid-template-columns: 1fr; }
    .pf-wrap { padding: 0 1rem 2rem; }
}
@media (max-width: 400px) {
    .pf-actions-row { grid-template-columns: repeat(2, 1fr); }
}
</style>
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

    @php
        $totalPesanan  = \App\Models\Transaksi::where('user_id', $user->id)->count();
        $totalSelesai  = \App\Models\Transaksi::where('user_id', $user->id)->where('status', 'completed')->count();
        $totalWishlist = \App\Models\Wishlist::where('user_id', $user->id)->count();
        $totalBelanja  = \App\Models\Transaksi::where('user_id', $user->id)->whereIn('status', ['paid','processing','shipped','completed'])->sum('total_harga');
        $recentOrders  = \App\Models\Transaksi::where('user_id', $user->id)->orderBy('created_at', 'desc')->take(3)->get();
    @endphp

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
                    $statusColors = [
                        'pending' => 'pf-recent-badge-pending',
                        'paid' => 'pf-recent-badge-pending',
                        'processing' => 'pf-recent-badge-shipped',
                        'shipped' => 'pf-recent-badge-shipped',
                        'completed' => 'pf-recent-badge-completed',
                        'cancelled' => 'pf-recent-badge-cancelled',
                        'expired' => 'pf-recent-badge-cancelled',
                    ];
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
                    <span class="pf-recent-badge {{ $statusColors[$order->status] ?? '' }}">{{ ucfirst($order->status) }}</span>
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