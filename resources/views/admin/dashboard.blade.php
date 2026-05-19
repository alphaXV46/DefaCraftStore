@extends('layouts.admin')

@section('title', 'Admin Dashboard - DefaCraftStore')

@section('content')
<div class="container py-5">
<div class="admin-dash" style="padding:0;">

    {{-- Title --}}
    <h1 style="font-family:'Plus Jakarta Sans',sans-serif;font-size:1.4rem;font-weight:800;color:#333;position:relative;display:inline-block;padding-bottom:0.5rem;margin-bottom:0.25rem;">
        <i class="fas fa-tools"></i> Admin Dashboard
        <span style="position:absolute;bottom:0;left:0;width:60px;height:4px;background:linear-gradient(135deg,#FEF9C3,#EAB308,#FACC15);border-radius:4px;display:block;"></span>
    </h1>
    <p style="color:#999;font-size:0.85rem;margin-bottom:1.5rem;">Selamat datang kembali, <strong style="color:#333;">{{ auth()->user()->name }}</strong> — {{ now()->format('l, d F Y') }}</p>

    <div class="d-flex justify-content-between align-items-center mb-4" style="margin-top:-0.5rem;">
        <div></div>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary" style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.5rem 1rem;border-radius:10px;border:1.5px solid #E0E0E0;background:#fff;color:#555;font-weight:600;font-size:0.85rem;font-family:'Inter',sans-serif;text-decoration:none;cursor:pointer;transition:all 0.2s;box-shadow:none;">
            ← Kembali ke Home
        </a>
    </div>

    <!-- Statistik Cards -->
    <div class="row mb-4" style="display:flex;flex-wrap:wrap;gap:1rem;margin:0 0 1.25rem 0;">
        <div style="flex:1 1 0;min-width:200px;">
            <div class="card text-white shadow" style="background:linear-gradient(135deg,#667EEA,#764BA2);border:none;border-radius:18px;box-shadow:0 6px 20px rgba(102,126,234,0.2);overflow:hidden;">
                <div class="card-body" style="padding:1.5rem;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div style="font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;opacity:0.8;margin-bottom:0.3rem;">Total Produk</div>
                            <div style="font-size:2rem;font-weight:800;line-height:1.1;">{{ $totalProduk }}</div>
                            <div style="font-size:0.75rem;opacity:0.7;margin-top:0.3rem;"><i class="fas fa-box"></i> Item terdaftar</div>
                        </div>
                        <div style="font-size:3rem;opacity:0.5;line-height:1;"><i class="fas fa-box"></i></div>
                    </div>
                    <div style="margin-top:0.75rem;height:4px;background:rgba(255,255,255,0.2);border-radius:4px;overflow:hidden;">
                        <div style="height:100%;width:{{ min($totalProduk * 10, 100) }}%;background:rgba(255,255,255,0.5);border-radius:4px;transition:width 1s ease;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div style="flex:1 1 0;min-width:200px;">
            <div class="card text-white shadow" style="background:linear-gradient(135deg,#11998E,#38EF7D);border:none;border-radius:18px;box-shadow:0 6px 20px rgba(17,153,142,0.2);overflow:hidden;">
                <div class="card-body" style="padding:1.5rem;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div style="font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;opacity:0.8;margin-bottom:0.3rem;">Total Transaksi</div>
                            <div style="font-size:2rem;font-weight:800;line-height:1.1;">{{ $totalTransaksi }}</div>
                            <div style="font-size:0.75rem;opacity:0.7;margin-top:0.3rem;"><i class="fas fa-shopping-cart"></i> Pesanan masuk</div>
                        </div>
                        <div style="font-size:3rem;opacity:0.5;line-height:1;"><i class="fas fa-shopping-cart"></i></div>
                    </div>
                    <div style="margin-top:0.75rem;height:4px;background:rgba(255,255,255,0.2);border-radius:4px;overflow:hidden;">
                        <div style="height:100%;width:{{ min($totalTransaksi * 5, 100) }}%;background:rgba(255,255,255,0.5);border-radius:4px;transition:width 1s ease;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div style="flex:1 1 0;min-width:200px;">
            <div class="card text-white shadow" style="background:linear-gradient(135deg,#4FACFE,#00F2FE);border:none;border-radius:18px;box-shadow:0 6px 20px rgba(79,172,254,0.2);overflow:hidden;">
                <div class="card-body" style="padding:1.5rem;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div style="font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;opacity:0.8;margin-bottom:0.3rem;">Total User</div>
                            <div style="font-size:2rem;font-weight:800;line-height:1.1;">{{ $totalUser }}</div>
                            <div style="font-size:0.75rem;opacity:0.7;margin-top:0.3rem;">👥 Member aktif</div>
                        </div>
                        <div style="font-size:3rem;opacity:0.5;line-height:1;">👥</div>
                    </div>
                    <div style="margin-top:0.75rem;height:4px;background:rgba(255,255,255,0.2);border-radius:4px;overflow:hidden;">
                        <div style="height:100%;width:{{ min($totalUser * 15, 100) }}%;background:rgba(255,255,255,0.5);border-radius:4px;transition:width 1s ease;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div style="flex:1 1 0;min-width:200px;">
            <div class="card text-white shadow" style="background:linear-gradient(135deg,#F7971E,#FFD200);border:none;border-radius:18px;box-shadow:0 6px 20px rgba(247,151,30,0.2);overflow:hidden;">
                <div class="card-body" style="padding:1.5rem;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div style="font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;opacity:0.8;margin-bottom:0.3rem;">Pendapatan</div>
                            <div style="font-size:1.5rem;font-weight:800;line-height:1.1;">
                                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                            </div>
                            <div style="font-size:0.75rem;opacity:0.7;margin-top:0.3rem;"><i class="fas fa-wallet"></i> Total revenue</div>
                        </div>
                        <div style="font-size:3rem;opacity:0.5;line-height:1;"><i class="fas fa-wallet"></i></div>
                    </div>
                    <div style="margin-top:0.75rem;height:4px;background:rgba(255,255,255,0.2);border-radius:4px;overflow:hidden;">
                        <div style="height:100%;width:{{ min($totalPendapatan / 50000, 100) }}%;background:rgba(255,255,255,0.5);border-radius:4px;transition:width 1s ease;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


   
    <!-- Menu Admin -->
    <div style="display:flex;flex-wrap:wrap;gap:1rem;margin-bottom:1.5rem;">
        <a href="{{ route('admin.produk.index') }}" style="flex:0 0 calc(25% - 0.75rem);min-width:200px;text-decoration:none;">
            <div class="card shadow" style="border:1.5px solid rgba(0,0,0,0.06);border-radius:18px;box-shadow:0 2px 8px rgba(0,0,0,0.03);overflow:hidden;transition:all 0.3s;height:100%;">
                <div style="height:4px;background:linear-gradient(135deg,#667EEA,#764BA2);"></div>
                <div class="card-body" style="padding:2rem 1.5rem;text-align:center;">
                    <div style="width:60px;height:60px;border-radius:16px;background:linear-gradient(135deg,#EDE7F6,#D1C4E9);display:inline-flex;align-items:center;justify-content:center;font-size:1.5rem;margin-bottom:1rem;"><i class="fas fa-box"></i></div>
                    <h4 style="font-family:'Plus Jakarta Sans',sans-serif;font-size:1.1rem;font-weight:700;color:#333;margin-bottom:0.35rem;">Kelola Produk</h4>
                    <p style="color:#999;font-size:0.82rem;margin:0;line-height:1.4;">Tambah, edit & hapus produk toko</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.transaksi.index') }}" style="flex:0 0 calc(25% - 0.75rem);min-width:200px;text-decoration:none;">
            <div class="card shadow" style="border:1.5px solid rgba(0,0,0,0.06);border-radius:18px;box-shadow:0 2px 8px rgba(0,0,0,0.03);overflow:hidden;transition:all 0.3s;height:100%;">
                <div style="height:4px;background:linear-gradient(135deg,#11998E,#38EF7D);"></div>
                <div class="card-body" style="padding:2rem 1.5rem;text-align:center;">
                    <div style="width:60px;height:60px;border-radius:16px;background:linear-gradient(135deg,#D1FAE5,#A7F3D0);display:inline-flex;align-items:center;justify-content:center;font-size:1.5rem;margin-bottom:1rem;"><i class="fas fa-chart-bar"></i></div>
                    <h4 style="font-family:'Plus Jakarta Sans',sans-serif;font-size:1.1rem;font-weight:700;color:#333;margin-bottom:0.35rem;">Kelola Transaksi</h4>
                    <p style="color:#999;font-size:0.82rem;margin:0;line-height:1.4;">Approve pembayaran & update status</p>
                    @if($pendingCount > 0)
                    <span style="display:inline-block;margin-top:0.75rem;background:#FEF3C7;color:#92400E;font-size:0.7rem;font-weight:700;padding:0.2rem 0.6rem;border-radius:50px;">{{ $pendingCount }} menunggu</span>
                    @endif
                </div>
            </div>
        </a>

        <a href="{{ route('admin.users.index') }}" style="flex:0 0 calc(25% - 0.75rem);min-width:200px;text-decoration:none;">
            <div class="card shadow" style="border:1.5px solid rgba(0,0,0,0.06);border-radius:18px;box-shadow:0 2px 8px rgba(0,0,0,0.03);overflow:hidden;transition:all 0.3s;height:100%;">
                <div style="height:4px;background:linear-gradient(135deg,#4FACFE,#00F2FE);"></div>
                <div class="card-body" style="padding:2rem 1.5rem;text-align:center;">
                    <div style="width:60px;height:60px;border-radius:16px;background:linear-gradient(135deg,#E0F2FE,#BAE6FD);display:inline-flex;align-items:center;justify-content:center;font-size:1.5rem;margin-bottom:1rem;">👥</div>
                    <h4 style="font-family:'Plus Jakarta Sans',sans-serif;font-size:1.1rem;font-weight:700;color:#333;margin-bottom:0.35rem;">Kelola Pelanggan</h4>
                    <p style="color:#999;font-size:0.82rem;margin:0;line-height:1.4;">Moderasi, edit & reset password pembeli</p>
                    <span style="display:inline-block;margin-top:0.75rem;background:#E0F2FE;color:#0369A1;font-size:0.7rem;font-weight:700;padding:0.2rem 0.6rem;border-radius:50px;">{{ $totalUser }} terdaftar</span>
                </div>
            </div>
        </a>

        {{-- LAPORAN CARD --}}
        <div onclick="openLaporan()" role="button" tabindex="0" onkeydown="if(event.key==='Enter')openLaporan()" style="flex:0 0 calc(25% - 0.75rem);min-width:200px;cursor:pointer;">
            <div class="card shadow" style="border:1.5px solid rgba(0,0,0,0.06);border-radius:18px;box-shadow:0 2px 8px rgba(0,0,0,0.03);overflow:hidden;transition:all 0.3s;height:100%;">
                <div style="height:4px;background:linear-gradient(135deg,#F7971E,#FFD200);"></div>
                <div class="card-body" style="padding:2rem 1.5rem;text-align:center;">
                    <div style="width:60px;height:60px;border-radius:16px;background:linear-gradient(135deg,#FEF3C7,#FDE68A);display:inline-flex;align-items:center;justify-content:center;font-size:1.5rem;margin-bottom:1rem;"><i class="fas fa-chart-line"></i></div>
                    <h4 style="font-family:'Plus Jakarta Sans',sans-serif;font-size:1.1rem;font-weight:700;color:#333;margin-bottom:0.35rem;">Laporan</h4>
                    <p style="color:#999;font-size:0.82rem;margin:0;line-height:1.4;">Ringkasan penjualan & transaksi</p>
                    <span style="display:inline-block;margin-top:0.75rem;background:#FEF3C7;color:#92400E;font-size:0.7rem;font-weight:700;padding:0.2rem 0.6rem;border-radius:50px;">{{ $totalTransaksi }} data</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Dua kolom bawah -->
    <div style="display:flex;gap:1.5rem;flex-wrap:wrap;">

        {{-- Kiri: Transaksi Terbaru --}}
        <div style="flex:2;min-width:0;">
            <div class="card shadow" style="border:1.5px solid rgba(0,0,0,0.06);border-radius:18px;box-shadow:0 2px 8px rgba(0,0,0,0.03);overflow:hidden;">
                <div class="card-body" style="padding:1.5rem;">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
                        <h5 style="font-family:'Plus Jakarta Sans',sans-serif;font-size:1.1rem;font-weight:700;color:#333;margin:0;"><i class="fas fa-list-alt"></i> Transaksi Terbaru</h5>
                        <a href="{{ route('admin.transaksi.index') }}" style="font-size:0.82rem;font-weight:600;color:#EAB308;text-decoration:none;">Lihat Semua →</a>
                    </div>

                    @if($transaksi->isEmpty())
                        <div style="text-align:center;padding:3rem 1rem;color:#bbb;">
                            <div style="font-size:2.5rem;margin-bottom:0.5rem;">📭</div>
                            <p style="margin:0;font-size:0.9rem;">Belum ada transaksi.</p>
                        </div>
                    @else
                        <div style="overflow-x:auto;">
                            <table style="width:100%;border-collapse:collapse;font-size:0.88rem;">
                                <thead>
                                    <tr>
                                        <th style="text-align:left;padding:0.75rem 0.85rem;background:#FAFAFA;color:#777;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.04em;border-bottom:2px solid rgba(0,0,0,0.06);">ID</th>
                                        <th style="text-align:left;padding:0.75rem 0.85rem;background:#FAFAFA;color:#777;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.04em;border-bottom:2px solid rgba(0,0,0,0.06);">Pembeli</th>
                                        <th style="text-align:left;padding:0.75rem 0.85rem;background:#FAFAFA;color:#777;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.04em;border-bottom:2px solid rgba(0,0,0,0.06);">Total</th>
                                        <th style="text-align:left;padding:0.75rem 0.85rem;background:#FAFAFA;color:#777;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.04em;border-bottom:2px solid rgba(0,0,0,0.06);">Metode</th>
                                        <th style="text-align:left;padding:0.75rem 0.85rem;background:#FAFAFA;color:#777;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.04em;border-bottom:2px solid rgba(0,0,0,0.06);">Status</th>
                                        <th style="text-align:left;padding:0.75rem 0.85rem;background:#FAFAFA;color:#777;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.04em;border-bottom:2px solid rgba(0,0,0,0.06);">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transaksi as $item)
                                        @php
                                            $sc = ['bg' => '#F5F5F5', 'color' => '#666', 'icon' => '<i class="fas fa-question-circle"></i>'];
                                            switch($item->status) {
                                                case 'pending': $sc = ['bg' => '#FEF3C7', 'color' => '#92400E', 'icon' => '⏳']; break;
                                                case 'paid': $sc = ['bg' => '#DBEAFE', 'color' => '#1E40AF', 'icon' => '<i class="fas fa-credit-card"></i>']; break;
                                                case 'processing': $sc = ['bg' => '#F3E8FF', 'color' => '#6B21A8', 'icon' => '<i class="fas fa-box"></i>']; break;
                                                case 'shipped': $sc = ['bg' => '#ECFDF5', 'color' => '#065F46', 'icon' => '<i class="fas fa-truck"></i>']; break;
                                                case 'completed': $sc = ['bg' => '#ECFDF5', 'color' => '#065F46', 'icon' => '<i class="fas fa-check-circle"></i>']; break;
                                                case 'cancelled': $sc = ['bg' => '#FEF2F2', 'color' => '#991B1B', 'icon' => '<i class="fas fa-times-circle"></i>']; break;
                                                case 'expired': $sc = ['bg' => '#FEF2F2', 'color' => '#991B1B', 'icon' => '⏰']; break;
                                            }
                                        @endphp
                                    <tr style="transition:background 0.15s;" onmouseover="this.style.background='#FAFAFA'" onmouseout="this.style.background='transparent'">
                                        <td style="padding:0.8rem 0.85rem;border-bottom:1px solid #F5F5F5;font-weight:700;color:#333;">#{{ $item->id }}</td>
                                        <td style="padding:0.8rem 0.85rem;border-bottom:1px solid #F5F5F5;color:#444;">
                                            <div style="font-weight:600;">{{ $item->nama_pembeli }}</div>
                                        </td>
                                        <td style="padding:0.8rem 0.85rem;border-bottom:1px solid #F5F5F5;font-weight:700;color:#333;">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                        <td style="padding:0.8rem 0.85rem;border-bottom:1px solid #F5F5F5;">
                                            <span style="display:inline-block;padding:0.15rem 0.5rem;border-radius:50px;font-size:0.72rem;font-weight:600;background:#F5F5F5;color:#666;">
                                                {{ $item->metode_pembayaran }}
                                            </span>
                                        </td>
                                        <td style="padding:0.8rem 0.85rem;border-bottom:1px solid #F5F5F5;">
                                            <span style="display:inline-flex;align-items:center;gap:0.2rem;padding:0.15rem 0.55rem;border-radius:50px;font-size:0.7rem;font-weight:700;background:{{ $sc['bg'] }};color:{{ $sc['color'] }};">
                                                {{ $sc['icon'] }} {{ ucfirst($item->status) }}
                                            </span>
                                        </td>
                                        <td style="padding:0.8rem 0.85rem;border-bottom:1px solid #F5F5F5;color:#999;font-size:0.82rem;white-space:nowrap;">
                                            {{ $item->created_at->format('d M Y') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Kanan: Sidebar --}}
        <div style="flex:0 0 280px;min-width:250px;display:flex;flex-direction:column;gap:1rem;">

            <div class="card shadow" style="border:1.5px solid rgba(0,0,0,0.06);border-radius:18px;box-shadow:0 2px 8px rgba(0,0,0,0.03);overflow:hidden;">
                <div class="card-body" style="padding:1.25rem;">
                    <h5 style="font-family:'Plus Jakarta Sans',sans-serif;font-size:0.95rem;font-weight:700;color:#333;margin:0 0 1rem 0;"><i class="fas fa-chart-bar"></i> Distribusi Status</h5>

                    @foreach($statusData as $sd)
                    <div style="margin-bottom:0.65rem;">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.2rem;">
                            <span style="font-size:0.75rem;font-weight:600;color:#666;">{{ $sd['label'] }}</span>
                            <span style="font-size:0.75rem;font-weight:800;color:#333;">{{ $sd['count'] }}</span>
                        </div>
                        <div style="height:8px;background:#F5F5F5;border-radius:4px;overflow:hidden;">
                            <div style="height:100%;width:{{ ($sd['count'] / $totalAll) * 100 }}%;background:{{ $sd['color'] }};border-radius:4px;transition:width 1s ease;min-width:{{ $sd['count'] > 0 ? '4px' : '0' }};"></div>
                        </div>
                    </div>
                    @endforeach
                    <div style="margin-top:0.75rem;padding-top:0.75rem;border-top:1px solid #F0F0F0;text-align:center;">
                        <span style="font-size:0.72rem;color:#aaa;">{{ round(($completedCount / $totalAll) * 100) }}% completion rate</span>
                    </div>
                </div>
            </div>

            <div class="card shadow" style="border:1.5px solid rgba(0,0,0,0.06);border-radius:18px;box-shadow:0 2px 8px rgba(0,0,0,0.03);overflow:hidden;">
                <div class="card-body" style="padding:1.25rem;">
                    <h5 style="font-family:'Plus Jakarta Sans',sans-serif;font-size:0.95rem;font-weight:700;color:#333;margin:0 0 1rem 0;"><i class="fas fa-lightbulb"></i> Info Cepat</h5>
                    <div style="display:flex;flex-direction:column;gap:0.6rem;">
                        @if($pendingCount > 0)
                        <div style="display:flex;align-items:center;gap:0.6rem;padding:0.6rem;background:#FFF8E1;border-radius:10px;border:1px solid rgba(234,179,8,0.12);">
                            <span style="font-size:1rem;"><i class="fas fa-bell"></i></span>
                            <div>
                                <div style="font-size:0.78rem;font-weight:700;color:#92400E;">{{ $pendingCount }} pesanan menunggu</div>
                                <div style="font-size:0.68rem;color:#B45309;">Perlu diproses segera</div>
                            </div>
                        </div>
                        @endif
                        @if($shippedCount > 0)
                        <div style="display:flex;align-items:center;gap:0.6rem;padding:0.6rem;background:#EFF6FF;border-radius:10px;border:1px solid rgba(59,130,246,0.12);">
                            <span style="font-size:1rem;"><i class="fas fa-truck"></i></span>
                            <div>
                                <div style="font-size:0.78rem;font-weight:700;color:#1E40AF;">{{ $shippedCount }} sedang dikirim</div>
                                <div style="font-size:0.68rem;color:#2563EB;">Dalam perjalanan ke pembeli</div>
                            </div>
                        </div>
                        @endif
                        <div style="display:flex;align-items:center;gap:0.6rem;padding:0.6rem;background:#ECFDF5;border-radius:10px;border:1px solid rgba(16,185,129,0.12);">
                            <span style="font-size:1rem;">💎</span>
                            <div>
                                <div style="font-size:0.78rem;font-weight:700;color:#065F46;">Rata-rata pesanan</div>
                                <div style="font-size:0.68rem;color:#059669;">Rp {{ number_format($totalTransaksi > 0 ? $totalPendapatan / $totalTransaksi : 0, 0, ',', '.') }}</div>
                            </div>
                        </div>
                        <div style="display:flex;align-items:center;gap:0.6rem;padding:0.6rem;background:#F5F3FF;border-radius:10px;border:1px solid rgba(139,92,246,0.12);">
                            <span style="font-size:1rem;">👥</span>
                            <div>
                                <div style="font-size:0.78rem;font-weight:700;color:#5B21B6;">Konversi user</div>
                                <div style="font-size:0.68rem;color:#7C3AED;">{{ $totalUser > 0 ? round(($totalTransaksi / $totalUser) * 100, 1) : 0 }}% transaksi/user</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow" style="border:1.5px solid rgba(0,0,0,0.06);border-radius:18px;box-shadow:0 2px 8px rgba(0,0,0,0.03);overflow:hidden;">
                <div class="card-body" style="padding:1.25rem;">
                    <h5 style="font-family:'Plus Jakarta Sans',sans-serif;font-size:0.95rem;font-weight:700;color:#333;margin:0 0 0.75rem 0;">⚙️ Sistem</h5>
                    <div style="display:flex;flex-direction:column;gap:0.4rem;">
                        <div style="display:flex;justify-content:space-between;font-size:0.78rem;">
                            <span style="color:#999;">Laravel</span>
                            <span style="font-weight:700;color:#333;">{{ app()->version() }}</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;font-size:0.78rem;">
                            <span style="color:#999;">PHP</span>
                            <span style="font-weight:700;color:#333;">{{ PHP_VERSION }}</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;font-size:0.78rem;">
                            <span style="color:#999;">Environment</span>
                            <span style="font-weight:700;padding:0.1rem 0.4rem;border-radius:4px;font-size:0.68rem;{{ app()->environment('production') ? 'background:#ECFDF5;color:#065F46;' : 'background:#FEF3C7;color:#92400E;' }}">{{ app()->environment() }}</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;font-size:0.78rem;">
                            <span style="color:#999;">Waktu</span>
                            <span style="font-weight:700;color:#333;">{{ now()->format('H:i:s') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</div>

<!-- ==================== LAPORAN PANEL ==================== -->
<div id="lpOverlay" style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.45);backdrop-filter:blur(3px);z-index:99998;opacity:0;visibility:hidden;transition:all 0.3s;pointer-events:none;" onclick="closeLaporan()"></div>
<div id="lpModal" style="position:fixed;top:0;right:0;width:88%;max-width:880px;height:100%;background:#F8F9FB;z-index:99999;transition:transform 0.4s cubic-bezier(0.4,0,0.2,1);overflow:hidden;display:flex;flex-direction:column;box-shadow:-8px 0 40px rgba(0,0,0,0.12);transform:translateX(100%);">
    <div style="background:linear-gradient(135deg,#4A3F5C,#5C4F6E);padding:1.75rem 2.5rem;display:flex;align-items:center;justify-content:space-between;flex-shrink:0;">
        <h3 style="font-size:1.4rem;font-weight:800;color:#fff;margin:0;display:flex;align-items:center;gap:0.75rem;font-family:'Plus Jakarta Sans',sans-serif;">
            <span style="width:44px;height:44px;background:rgba(234,179,8,0.2);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;"><i class="fas fa-chart-line"></i></span>
            Laporan Penjualan
        </h3>
        <button onclick="closeLaporan()" style="width:42px;height:42px;background:rgba(255,255,255,0.1);border:none;border-radius:12px;color:#fff;font-size:1.2rem;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.25s;" onmouseover="this.style.background='rgba(234,179,8,0.5)';this.style.transform='rotate(90deg)'" onmouseout="this.style.background='rgba(255,255,255,0.1)';this.style.transform='rotate(0deg)'">✕</button>
    </div>
    <div id="lpBody" style="flex:1;overflow-y:auto;padding:2.5rem;">

        {{-- RINGKASAN --}}
        <div style="font-size:0.92rem;font-weight:800;text-transform:uppercase;letter-spacing:1.5px;color:#888;margin-bottom:1.15rem;display:flex;align-items:center;gap:0.6rem;">
            Ringkasan
            <span style="flex:1;height:1px;background:#E0E0E0;display:block;"></span>
        </div>
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.25rem;margin-bottom:2.75rem;">
            <div style="background:#fff;border-radius:18px;padding:1.75rem 1.5rem;border:1px solid #F0F0F0;">
                <div style="font-size:0.82rem;color:#aaa;text-transform:uppercase;letter-spacing:0.6px;margin-bottom:0.5rem;font-weight:600;">Total Pendapatan</div>
                <div style="font-size:1.85rem;font-weight:900;color:#059669;font-family:'Plus Jakarta Sans',sans-serif;line-height:1.2;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
            </div>
            <div style="background:#fff;border-radius:18px;padding:1.75rem 1.5rem;border:1px solid #F0F0F0;">
                <div style="font-size:0.82rem;color:#aaa;text-transform:uppercase;letter-spacing:0.6px;margin-bottom:0.5rem;font-weight:600;">Total Transaksi</div>
                <div style="font-size:1.85rem;font-weight:900;color:#2563EB;font-family:'Plus Jakarta Sans',sans-serif;line-height:1.2;">{{ $totalTransaksi }}</div>
            </div>
            <div style="background:#fff;border-radius:18px;padding:1.75rem 1.5rem;border:1px solid #F0F0F0;">
                <div style="font-size:0.82rem;color:#aaa;text-transform:uppercase;letter-spacing:0.6px;margin-bottom:0.5rem;font-weight:600;">Rata-rata / Transaksi</div>
                <div style="font-size:1.85rem;font-weight:900;color:#D97706;font-family:'Plus Jakarta Sans',sans-serif;line-height:1.2;">Rp {{ number_format($totalTransaksi > 0 ? $totalPendapatan / $totalTransaksi : 0, 0, ',', '.') }}</div>
            </div>
        </div>

        {{-- STATUS --}}

        <div style="font-size:0.92rem;font-weight:800;text-transform:uppercase;letter-spacing:1.5px;color:#888;margin-bottom:1.15rem;display:flex;align-items:center;gap:0.6rem;">
            Status Pesanan
            <span style="flex:1;height:1px;background:#E0E0E0;display:block;"></span>
        </div>
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1.15rem;margin-bottom:2.75rem;">
            <div style="background:#fff;border-radius:18px;padding:1.5rem 1.25rem;border:1px solid #F0F0F0;text-align:center;">
                <div style="width:52px;height:52px;border-radius:50%;margin:0 auto 0.75rem;display:flex;align-items:center;justify-content:center;font-size:1.1rem;font-weight:900;color:#fff;background:linear-gradient(135deg,#F59E0B,#D97706);">{{ $pendingCount }}</div>
                <div style="font-size:1.85rem;font-weight:900;color:#333;font-family:'Plus Jakarta Sans',sans-serif;line-height:1.2;">{{ $pendingCount }}</div>
                <div style="font-size:0.88rem;color:#999;margin-top:0.15rem;font-weight:600;">Menunggu</div>
                <div style="font-size:0.78rem;color:#ccc;margin-top:0.2rem;">{{ round(($pendingCount / $totalAll) * 100) }}%</div>
            </div>
            <div style="background:#fff;border-radius:18px;padding:1.5rem 1.25rem;border:1px solid #F0F0F0;text-align:center;">
                <div style="width:52px;height:52px;border-radius:50%;margin:0 auto 0.75rem;display:flex;align-items:center;justify-content:center;font-size:1.1rem;font-weight:900;color:#fff;background:linear-gradient(135deg,#3B82F6,#2563EB);">{{ $shippedCount }}</div>
                <div style="font-size:1.85rem;font-weight:900;color:#333;font-family:'Plus Jakarta Sans',sans-serif;line-height:1.2;">{{ $shippedCount }}</div>
                <div style="font-size:0.88rem;color:#999;margin-top:0.15rem;font-weight:600;">Dikirim</div>
                <div style="font-size:0.78rem;color:#ccc;margin-top:0.2rem;">{{ round(($shippedCount / $totalAll) * 100) }}%</div>
            </div>
            <div style="background:#fff;border-radius:18px;padding:1.5rem 1.25rem;border:1px solid #F0F0F0;text-align:center;">
                <div style="width:52px;height:52px;border-radius:50%;margin:0 auto 0.75rem;display:flex;align-items:center;justify-content:center;font-size:1.1rem;font-weight:900;color:#fff;background:linear-gradient(135deg,#10B981,#059669);">{{ $completedCount }}</div>
                <div style="font-size:1.85rem;font-weight:900;color:#333;font-family:'Plus Jakarta Sans',sans-serif;line-height:1.2;">{{ $completedCount }}</div>
                <div style="font-size:0.88rem;color:#999;margin-top:0.15rem;font-weight:600;">Selesai</div>
                <div style="font-size:0.78rem;color:#ccc;margin-top:0.2rem;">{{ round(($completedCount / $totalAll) * 100) }}%</div>
            </div>
            <div style="background:#fff;border-radius:18px;padding:1.5rem 1.25rem;border:1px solid #F0F0F0;text-align:center;">
                <div style="width:52px;height:52px;border-radius:50%;margin:0 auto 0.75rem;display:flex;align-items:center;justify-content:center;font-size:1.1rem;font-weight:900;color:#fff;background:linear-gradient(135deg,#EF4444,#DC2626);">{{ $cancelledCount }}</div>
                <div style="font-size:1.85rem;font-weight:900;color:#333;font-family:'Plus Jakarta Sans',sans-serif;line-height:1.2;">{{ $cancelledCount }}</div>
                <div style="font-size:0.88rem;color:#999;margin-top:0.15rem;font-weight:600;">Dibatalkan</div>
                <div style="font-size:0.78rem;color:#ccc;margin-top:0.2rem;">{{ round(($cancelledCount / $totalAll) * 100) }}%</div>
            </div>
        </div>

        {{-- METODE PEMBAYARAN --}}

        @if(count($metodeMap) > 0)
        <div style="font-size:0.92rem;font-weight:800;text-transform:uppercase;letter-spacing:1.5px;color:#888;margin-bottom:1.15rem;display:flex;align-items:center;gap:0.6rem;">
            Metode Pembayaran
            <span style="flex:1;height:1px;background:#E0E0E0;display:block;"></span>
        </div>
        <div style="background:#fff;border-radius:18px;border:1px solid #F0F0F0;padding:2rem;margin-bottom:2.75rem;">
            <div style="font-size:1.15rem;font-weight:800;color:#333;margin-bottom:1.5rem;font-family:'Plus Jakarta Sans',sans-serif;">Distribusi Metode</div>
            @foreach($metodeMap as $metodeName => $metodeCount)
                @php
                    $barWidth = max(8, ($metodeCount / $maxMetode) * 100);
                    $bc = $barColors[$metodeIdx % count($barColors)];
                    $tc = $barTextColors[$metodeIdx % count($barTextColors)];
                    $metodeIdx++;
                @endphp
                <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1rem;">
                    <span style="width:140px;font-size:0.92rem;color:#555;text-align:right;flex-shrink:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:700;" title="{{ $metodeName }}">{{ $metodeName }}</span>
                    <div style="flex:1;height:40px;background:#F0F0F0;border-radius:8px;overflow:hidden;">
                        <div style="height:100%;width:{{ $barWidth }}%;background:{{ $bc }};border-radius:8px;display:flex;align-items:center;padding-left:0.85rem;font-size:0.88rem;font-weight:800;color:{{ $tc }};min-width:fit-content;">{{ $metodeCount }}x</div>
                    </div>
                    <span style="width:100px;font-size:0.92rem;font-weight:800;color:#333;text-align:right;flex-shrink:0;font-family:'Plus Jakarta Sans',sans-serif;">Rp {{ number_format($metodeRevenue[$metodeName], 0, ',', '.') }}</span>
                </div>
            @endforeach
        </div>
        @endif

        {{-- DAFTAR TRANSAKSI --}}
        <div style="font-size:0.92rem;font-weight:800;text-transform:uppercase;letter-spacing:1.5px;color:#888;margin-bottom:1.15rem;display:flex;align-items:center;gap:0.6rem;">
            Daftar Transaksi
            <span style="flex:1;height:1px;background:#E0E0E0;display:block;"></span>
        </div>
        <div style="background:#fff;border-radius:18px;border:1px solid #F0F0F0;overflow:hidden;margin-bottom:2rem;">
            <div style="display:flex;align-items:center;justify-content:space-between;padding:1.25rem 1.75rem;border-bottom:1px solid #F0F0F0;">
                <span style="font-size:1.15rem;font-weight:800;color:#333;font-family:'Plus Jakarta Sans',sans-serif;">{{ $transaksi->count() }} Transaksi</span>
            </div>
            @if($transaksi->isEmpty())
                <div style="text-align:center;padding:4rem 1rem;color:#ccc;">
                    <div style="font-size:3.2rem;margin-bottom:0.75rem;">📭</div>
                    <p style="font-size:1rem;margin:0;">Belum ada transaksi.</p>
                </div>
            @else
                <div style="overflow-x:auto;">
                    <table style="width:100%;border-collapse:collapse;">
                        <thead>
                            <tr>
                                <th style="padding:1rem 1.35rem;text-align:left;font-size:0.8rem;font-weight:800;text-transform:uppercase;letter-spacing:0.8px;color:#999;background:#FAFAFA;border-bottom:2px solid #F0F0F0;">ID</th>
                                <th style="padding:1rem 1.35rem;text-align:left;font-size:0.8rem;font-weight:800;text-transform:uppercase;letter-spacing:0.8px;color:#999;background:#FAFAFA;border-bottom:2px solid #F0F0F0;">Tanggal</th>
                                <th style="padding:1rem 1.35rem;text-align:left;font-size:0.8rem;font-weight:800;text-transform:uppercase;letter-spacing:0.8px;color:#999;background:#FAFAFA;border-bottom:2px solid #F0F0F0;">Pembeli</th>
                                <th style="padding:1rem 1.35rem;text-align:left;font-size:0.8rem;font-weight:800;text-transform:uppercase;letter-spacing:0.8px;color:#999;background:#FAFAFA;border-bottom:2px solid #F0F0F0;">Metode</th>
                                <th style="padding:1rem 1.35rem;text-align:right;font-size:0.8rem;font-weight:800;text-transform:uppercase;letter-spacing:0.8px;color:#999;background:#FAFAFA;border-bottom:2px solid #F0F0F0;">Total</th>
                                <th style="padding:1rem 1.35rem;text-align:right;font-size:0.8rem;font-weight:800;text-transform:uppercase;letter-spacing:0.8px;color:#999;background:#FAFAFA;border-bottom:2px solid #F0F0F0;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksi as $item)
                                @php
                                    $sl = ['Unknown','#F5F5F5','#666','<i class="fas fa-question-circle"></i>'];
                                    switch($item->status) {
                                        case 'pending': $sl = ['Menunggu', '#FEF3C7', '#92400E', '⏳']; break;
                                        case 'paid': $sl = ['Dibayar', '#DBEAFE', '#1E40AF', '<i class="fas fa-credit-card"></i>']; break;
                                        case 'processing': $sl = ['Diproses', '#F3E8FF', '#6B21A8', '<i class="fas fa-box"></i>']; break;
                                        case 'shipped': $sl = ['Dikirim', '#ECFDF5', '#065F46', '<i class="fas fa-truck"></i>']; break;
                                        case 'completed': $sl = ['Selesai', '#ECFDF5', '#065F46', '<i class="fas fa-check-circle"></i>']; break;
                                        case 'cancelled': $sl = ['Dibatalkan', '#FEF2F2', '#991B1B', '<i class="fas fa-times-circle"></i>']; break;
                                        case 'expired': $sl = ['Kadaluarsa', '#FEF2F2', '#991B1B', '⏰']; break;
                                    }
                                @endphp
                                <tr style="cursor:default;" onmouseover="this.style.background='#FAFAFA'" onmouseout="this.style.background='transparent'">
                                    <td style="padding:1.1rem 1.35rem;font-size:0.95rem;color:#444;border-bottom:1px solid #F5F5F5;"><strong>#{{ $item->id }}</strong></td>
                                    <td style="padding:1.1rem 1.35rem;font-size:0.95rem;color:#444;border-bottom:1px solid #F5F5F5;">{{ $item->created_at->format('d M Y') }}</td>
                                    <td style="padding:1.1rem 1.35rem;font-size:0.95rem;color:#444;border-bottom:1px solid #F5F5F5;">{{ $item->nama_pembeli }}</td>
                                    <td style="padding:1.1rem 1.35rem;font-size:0.95rem;color:#444;border-bottom:1px solid #F5F5F5;"><span style="font-size:0.85rem;color:#888;">{{ $item->metode_pembayaran }}</span></td>
                                    <td style="padding:1.1rem 1.35rem;font-size:0.95rem;color:#444;border-bottom:1px solid #F5F5F5;text-align:right;"><strong>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</strong></td>
                                    <td style="padding:1.1rem 1.35rem;font-size:0.95rem;color:#444;border-bottom:1px solid #F5F5F5;text-align:right;">
                                        <span style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.35rem 0.85rem;border-radius:50px;font-size:0.82rem;font-weight:700;white-space:nowrap;background:{{ $sl[1] }};color:{{ $sl[2] }};">
                                            {{ $sl[3] }} {{ $sl[0] }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>
    <div style="padding:1.25rem 2.5rem;background:#fff;border-top:1px solid #F0F0F0;display:flex;align-items:center;justify-content:space-between;flex-shrink:0;">
        <span style="font-size:0.82rem;color:#ccc;">Data per {{ now()->format('d F Y') }}</span>
        <button onclick="printLaporan()" style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.8rem 1.75rem;background:linear-gradient(135deg,#4A3F5C,#5C4F6E);color:#fff;border:none;border-radius:12px;font-size:0.95rem;font-weight:700;cursor:pointer;transition:all 0.2s;font-family:'Inter',sans-serif;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 20px rgba(74,63,92,0.3)'" onmouseout="this.style.transform='';this.style.boxShadow=''">🖨️ Cetak Laporan</button>
    </div>
</div>

<script>
function openLaporan() {
    document.getElementById('lpOverlay').style.opacity = '1';
    document.getElementById('lpOverlay').style.visibility = 'visible';
    document.getElementById('lpOverlay').style.pointerEvents = 'auto';
    document.getElementById('lpModal').style.transform = 'translateX(0)';
    document.body.style.overflow = 'hidden';
}
function closeLaporan() {
    document.getElementById('lpOverlay').style.opacity = '0';
    document.getElementById('lpOverlay').style.visibility = 'hidden';
    document.getElementById('lpOverlay').style.pointerEvents = 'none';
    document.getElementById('lpModal').style.transform = 'translateX(100%)';
    document.body.style.overflow = '';
}
function printLaporan() {
    var c = document.getElementById('lpBody').innerHTML;
    var w = window.open('','_blank','width=900,height=700');
    if(!w){alert('Izinkan pop-up untuk mencetak.');return;}
    var t = new Date().toLocaleDateString('id-ID',{weekday:'long',year:'numeric',month:'long',day:'numeric'});
    w.document.write('<!DOCTYPE html><html><head><title>Laporan - DefaCraft</title><link rel="stylesheet" href="{{ Vite::asset('resources/css/admin-dashboard.css') }}"></head><body>');
    w.document.write('<h2>Laporan Penjualan</h2><p class="sub">DefaCraft — '+t+'</p>');
    w.document.write(c);
    w.document.write('</body></html>');
    w.document.close();
    w.focus();
    setTimeout(function(){w.print();},400);
}
document.addEventListener('keydown',function(e){if(e.key==='Escape')closeLaporan();});
</script>
@endsection