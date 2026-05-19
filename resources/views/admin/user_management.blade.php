@extends('layouts.admin')

@section('title', 'Manajemen Pelanggan - DefaCraftStore')

@section('content')
<div class="container py-5">
    <div class="admin-dash" style="padding:0;">

        {{-- Title --}}
        <h1 style="font-family:'Plus Jakarta Sans',sans-serif;font-size:1.4rem;font-weight:800;color:#333;position:relative;display:inline-block;padding-bottom:0.5rem;margin-bottom:0.25rem;">
            👥 Kelola Pelanggan
            <span style="position:absolute;bottom:0;left:0;width:60px;height:4px;background:linear-gradient(135deg,#FEF9C3,#EAB308,#FACC15);border-radius:4px;display:block;"></span>
        </h1>
        <p style="color:#999;font-size:0.85rem;margin-bottom:1.5rem;">Mengatur, memoderasi, dan membantu pemulihan akun pelanggan toko Anda.</p>

        <div class="d-flex justify-content-between align-items-center mb-4" style="margin-top:-0.5rem;">
            <div></div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary" style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.5rem 1rem;border-radius:10px;border:1.5px solid #E0E0E0;background:#fff;color:#555;font-weight:600;font-size:0.85rem;font-family:'Inter',sans-serif;text-decoration:none;cursor:pointer;transition:all 0.2s;box-shadow:none;">
                ← Kembali ke Dashboard
            </a>
        </div>

        {{-- Temp Password Alert (Reset Password Success Visualizer) --}}
        @if(session('temp_password'))
            <div class="alert alert-warning border-0 shadow-sm mb-4" style="border-radius: 18px; background: linear-gradient(135deg, #FFFDF5, #FEF3C7); padding: 1.5rem; border-left: 5px solid #D97706 !important;">
                <div class="d-flex align-items-start gap-3">
                    <span style="font-size: 1.8rem; line-height: 1;">🔑</span>
                    <div style="flex: 1;">
                        <h4 style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.1rem; font-weight: 800; color: #92400E; margin-bottom: 0.25rem;">Password Sementara Berhasil Dibuat!</h4>
                        <p style="font-size: 0.88rem; color: #B45309; margin-bottom: 0.75rem;">
                            Password untuk pelanggan <strong>{{ session('temp_user_name') }}</strong> telah direset menjadi acak. Berikan password di bawah ini kepada pelanggan agar mereka bisa login dan segera menggantinya di menu Profil:
                        </p>
                        <div class="d-flex align-items-center gap-2" style="max-width: 400px;">
                            <input type="text" id="tempPasswordInput" readonly value="{{ session('temp_password') }}" class="form-control text-center" style="font-family: 'Courier New', Courier, monospace; font-size: 1.15rem; font-weight: 800; letter-spacing: 2px; color: #B45309; background: #fff; border: 1.5px solid #FCD34D; border-radius: 10px; padding: 0.4rem 1rem;">
                            <button onclick="copyTempPassword()" class="btn btn-warning" style="background: #EAB308; border: none; border-radius: 10px; color: #fff; font-weight: 700; font-size: 0.88rem; padding: 0.5rem 1.25rem; display: inline-flex; align-items: center; gap: 0.3rem;">
                                📋 Salin
                            </button>
                        </div>
                        <span id="copyFeedback" style="font-size: 0.78rem; color: #059669; font-weight: 700; margin-top: 0.35rem; display: none;">✓ Berhasil disalin ke clipboard!</span>
                    </div>
                </div>
            </div>
            <script>
                function copyTempPassword() {
                    var copyText = document.getElementById("tempPasswordInput");
                    copyText.select();
                    copyText.setSelectionRange(0, 99999);
                    navigator.clipboard.writeText(copyText.value);
                    
                    var feedback = document.getElementById("copyFeedback");
                    feedback.style.display = "block";
                    setTimeout(function() {
                        feedback.style.display = "none";
                    }, 3000);
                }
            </script>
        @endif

        {{-- Statistik User --}}
        <div class="row mb-4" style="display:flex;flex-wrap:wrap;gap:1rem;margin:0 0 1.5rem 0;">
            <div style="flex:1 1 0;min-width:200px;">
                <div class="card text-white shadow" style="background:linear-gradient(135deg,#4FACFE,#00F2FE);border:none;border-radius:18px;box-shadow:0 6px 20px rgba(79,172,254,0.15);overflow:hidden;">
                    <div class="card-body" style="padding:1.25rem 1.5rem;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div style="font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;opacity:0.8;margin-bottom:0.2rem;">Total Pelanggan</div>
                                <div style="font-size:1.85rem;font-weight:800;line-height:1.1;">{{ $totalCustomers }}</div>
                                <div style="font-size:0.75rem;opacity:0.7;margin-top:0.2rem;">👥 Akun pembeli terdaftar</div>
                            </div>
                            <div style="font-size:2.5rem;opacity:0.5;line-height:1;">👥</div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="flex:1 1 0;min-width:200px;">
                <div class="card text-white shadow" style="background:linear-gradient(135deg,#10B981,#059669);border:none;border-radius:18px;box-shadow:0 6px 20px rgba(16,185,129,0.15);overflow:hidden;">
                    <div class="card-body" style="padding:1.25rem 1.5rem;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div style="font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;opacity:0.8;margin-bottom:0.2rem;">Pelanggan Aktif</div>
                                <div style="font-size:1.85rem;font-weight:800;line-height:1.1;">{{ $activeCustomers }}</div>
                                <div style="font-size:0.75rem;opacity:0.7;margin-top:0.2rem;">✓ Akses normal diperbolehkan</div>
                            </div>
                            <div style="font-size:2.5rem;opacity:0.5;line-height:1;">✓</div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="flex:1 1 0;min-width:200px;">
                <div class="card text-white shadow" style="background:linear-gradient(135deg,#EF4444,#DC2626);border:none;border-radius:18px;box-shadow:0 6px 20px rgba(239,68,68,0.15);overflow:hidden;">
                    <div class="card-body" style="padding:1.25rem 1.5rem;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div style="font-size:0.72rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;opacity:0.8;margin-bottom:0.2rem;">Ditangguhkan (Banned)</div>
                                <div style="font-size:1.85rem;font-weight:800;line-height:1.1;">{{ $bannedCustomers }}</div>
                                <div style="font-size:0.75rem;opacity:0.7;margin-top:0.2rem;">✗ Akses masuk diblokir</div>
                            </div>
                            <div style="font-size:2.5rem;opacity:0.5;line-height:1;">✗</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter & Search Form --}}
        <div class="card shadow mb-4" style="border:1.5px solid rgba(0,0,0,0.06);border-radius:18px;box-shadow:0 2px 8px rgba(0,0,0,0.03);">
            <div class="card-body" style="padding: 1.25rem 1.5rem;">
                <form action="{{ route('admin.users.index') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label for="search" class="form-label" style="font-weight: 700; font-size: 0.8rem; color: #555; text-transform: uppercase;">Pencarian Pelanggan</label>
                        <div class="input-group">
                            <span class="input-group-text" style="background: #FAFAFA; border: 1.5px solid #E0E0E0; border-right: none; border-radius: 10px 0 0 10px; color: #aaa;">🔍</span>
                            <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, nomor Whatsapp..." class="form-control" style="border: 1.5px solid #E0E0E0; border-radius: 0 10px 10px 0; font-size: 0.88rem; padding: 0.5rem 0.75rem; box-shadow: none;">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="status" class="form-label" style="font-weight: 700; font-size: 0.8rem; color: #555; text-transform: uppercase;">Filter Status Akun</label>
                        <select id="status" name="status" class="form-select" style="border: 1.5px solid #E0E0E0; border-radius: 10px; font-size: 0.88rem; padding: 0.5rem 0.75rem; box-shadow: none;">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>✓ Aktif</option>
                            <option value="banned" {{ request('status') === 'banned' ? 'selected' : '' }}>✗ Ditangguhkan (Banned)</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-warning flex-fill" style="background: #EAB308; border: none; border-radius: 10px; color: #fff; font-weight: 700; font-size: 0.88rem; padding: 0.6rem; transition: all 0.2s;">
                            Filter
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary" style="border: 1.5px solid #E0E0E0; border-radius: 10px; background: #fff; color: #555; font-weight: 600; font-size: 0.88rem; padding: 0.6rem; text-decoration: none; text-align: center;">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="card shadow" style="border:1.5px solid rgba(0,0,0,0.06);border-radius:18px;box-shadow:0 2px 8px rgba(0,0,0,0.03);overflow:hidden;">
            <div class="card-body" style="padding:1.5rem;">
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;">
                    <h5 style="font-family:'Plus Jakarta Sans',sans-serif;font-size:1.05rem;font-weight:700;color:#333;margin:0;">📋 Daftar Pembeli Terdaftar</h5>
                </div>

                @if($users->isEmpty())
                    <div style="text-align:center;padding:4rem 1rem;color:#bbb;">
                        <div style="font-size:3rem;margin-bottom:0.5rem;">👥</div>
                        <p style="margin:0;font-size:0.95rem;font-weight: 500;">Tidak ada pelanggan yang cocok dengan kriteria pencarian.</p>
                    </div>
                @else
                    <div style="overflow-x:auto;">
                        <table style="width:100%;border-collapse:collapse;font-size:0.88rem;">
                            <thead>
                                <tr>
                                    <th style="text-align:left;padding:0.85rem;background:#FAFAFA;color:#777;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.04em;border-bottom:2px solid rgba(0,0,0,0.06);width: 50px;">ID</th>
                                    <th style="text-align:left;padding:0.85rem;background:#FAFAFA;color:#777;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.04em;border-bottom:2px solid rgba(0,0,0,0.06);">Profil Pembeli</th>
                                    <th style="text-align:left;padding:0.85rem;background:#FAFAFA;color:#777;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.04em;border-bottom:2px solid rgba(0,0,0,0.06);">No. Whatsapp</th>
                                    <th style="text-align:left;padding:0.85rem;background:#FAFAFA;color:#777;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.04em;border-bottom:2px solid rgba(0,0,0,0.06);width: 140px;">Status</th>
                                    <th style="text-align:left;padding:0.85rem;background:#FAFAFA;color:#777;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.04em;border-bottom:2px solid rgba(0,0,0,0.06);width: 130px;">Tgl Bergabung</th>
                                    <th style="text-align:center;padding:0.85rem;background:#FAFAFA;color:#777;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.04em;border-bottom:2px solid rgba(0,0,0,0.06);width: 250px;">Aksi Manajemen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr style="transition:background 0.15s;" onmouseover="this.style.background='#FAFAFA'" onmouseout="this.style.background='transparent'">
                                    <td style="padding:1rem 0.85rem;border-bottom:1px solid #F5F5F5;font-weight:700;color:#555;">#{{ $user->id }}</td>
                                    <td style="padding:1rem 0.85rem;border-bottom:1px solid #F5F5F5;color:#444;">
                                        <div style="font-weight:700;color:#333;font-size:0.92rem;">{{ $user->name }}</div>
                                        <div style="font-size:0.78rem;color:#888;">{{ $user->email }}</div>
                                    </td>
                                    <td style="padding:1rem 0.85rem;border-bottom:1px solid #F5F5F5;font-family:'Courier New', Courier, monospace;font-weight:600;color:#555;">
                                        {{ $user->nomor_wa ?? '-' }}
                                    </td>
                                    <td style="padding:1rem 0.85rem;border-bottom:1px solid #F5F5F5;">
                                        @if($user->is_active)
                                            <span style="display:inline-flex;align-items:center;gap:0.25rem;padding:0.25rem 0.65rem;border-radius:50px;font-size:0.72rem;font-weight:700;background:#ECFDF5;color:#047857;">
                                                ✓ Aktif
                                            </span>
                                        @else
                                            <span style="display:inline-flex;align-items:center;gap:0.25rem;padding:0.25rem 0.65rem;border-radius:50px;font-size:0.72rem;font-weight:700;background:#FEF2F2;color:#B91C1C;">
                                                ✗ Diblokir
                                            </span>
                                        @endif
                                    </td>
                                    <td style="padding:1rem 0.85rem;border-bottom:1px solid #F5F5F5;color:#888;font-size:0.8rem;">
                                        {{ $user->created_at->format('d M Y') }}
                                    </td>
                                    <td style="padding:1rem 0.85rem;border-bottom:1px solid #F5F5F5;text-align:center;">
                                        <div class="d-inline-flex gap-1">
                                            {{-- Edit Button (Triggers Javascript Modal Populate) --}}
                                            <button type="button" onclick="openEditModal({{ json_encode($user) }})" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;font-weight:600;font-size:0.75rem;padding:0.25rem 0.6rem;background:#fff;border:1.5px solid #E0E0E0;color:#555;" title="Edit Data Profil">
                                                ✏️ Edit
                                            </button>

                                            {{-- Reset Password Trigger --}}
                                            <form action="{{ route('admin.users.reset-password', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mereset password pelanggan {{ $user->name }} menjadi password acak sementara?')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-warning" style="border-radius:8px;font-weight:600;font-size:0.75rem;padding:0.25rem 0.6rem;background:#fff;border:1.5px solid #FCD34D;color:#D97706;" title="Reset Password Ke Acak">
                                                    🔑 Reset Pass
                                                </button>
                                            </form>

                                            {{-- Ban/Unban Trigger --}}
                                            <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                @if($user->is_active)
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius:8px;font-weight:600;font-size:0.75rem;padding:0.25rem 0.6rem;background:#fff;border:1.5px solid #FCA5A5;color:#DC2626;" onclick="return confirm('Yakin ingin menangguhkan/memblokir akun pelanggan {{ $user->name }}? Pengguna tidak akan bisa login!')" title="Blokir Akses">
                                                        🚫 Ban
                                                    </button>
                                                @else
                                                    <button type="submit" class="btn btn-sm btn-outline-success" style="border-radius:8px;font-weight:600;font-size:0.75rem;padding:0.25rem 0.6rem;background:#fff;border:1.5px solid #86EFAC;color:#16A34A;" title="Aktifkan Kembali">
                                                        🔓 Unban
                                                    </button>
                                                @endif
                                            </form>

                                            {{-- Delete Trigger --}}
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Tindakan ini permanen! Apakah Anda 100% yakin ingin menghapus akun pelanggan {{ $user->name }} beserta semua data belanjanya?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-dark" style="border-radius:8px;font-weight:600;font-size:0.75rem;padding:0.25rem 0.6rem;background:#fff;border:1.5px solid #333;color:#333;" title="Hapus Permanen">
                                                    🗑️ Hapus
                                                </button>
                                            </form>
                                        </div>
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
</div>

{{-- MODAL EDIT MODERASI USER --}}
<div id="editOverlay" style="position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.45);backdrop-filter:blur(3px);z-index:99998;opacity:0;visibility:hidden;transition:all 0.3s;pointer-events:none;" onclick="closeEditModal()"></div>
<div id="editModal" style="position:fixed;top:50%;left:50%;transform:translate(-50%,-45%);width:90%;max-width:500px;background:#fff;z-index:99999;border-radius:24px;box-shadow:0 15px 35px rgba(0,0,0,0.15);overflow:hidden;transition:all 0.3s ease-out;opacity:0;visibility:hidden;">
    <div style="background:linear-gradient(135deg,#4A3F5C,#5C4F6E);padding:1.25rem 2rem;display:flex;align-items:center;justify-content:space-between;flex-shrink:0;">
        <h3 style="font-size:1.15rem;font-weight:800;color:#fff;margin:0;display:flex;align-items:center;gap:0.5rem;font-family:'Plus Jakarta Sans',sans-serif;">
            ✏️ Edit Profil Pelanggan
        </h3>
        <button onclick="closeEditModal()" style="width:36px;height:36px;background:rgba(255,255,255,0.1);border:none;border-radius:10px;color:#fff;font-size:1.1rem;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">✕</button>
    </div>
    
    <form id="editForm" method="POST" style="margin:0;">
        @csrf
        @method('PUT')
        
        <div style="padding:2rem;">
            <div class="mb-3">
                <label for="edit_name" class="form-label" style="font-weight:700;font-size:0.8rem;color:#555;text-transform:uppercase;">Nama Lengkap</label>
                <input type="text" id="edit_name" name="name" required class="form-control" style="border:1.5px solid #E0E0E0;border-radius:10px;font-size:0.88rem;padding:0.6rem;box-shadow:none;">
            </div>
            
            <div class="mb-3">
                <label for="edit_email" class="form-label" style="font-weight:700;font-size:0.8rem;color:#555;text-transform:uppercase;">Alamat Email</label>
                <input type="email" id="edit_email" name="email" required class="form-control" style="border:1.5px solid #E0E0E0;border-radius:10px;font-size:0.88rem;padding:0.6rem;box-shadow:none;">
            </div>
            
            <div class="mb-3">
                <label for="edit_wa" class="form-label" style="font-weight:700;font-size:0.8rem;color:#555;text-transform:uppercase;">Nomor Whatsapp</label>
                <input type="text" id="edit_wa" name="nomor_wa" class="form-control" placeholder="Contoh: 081234567890" style="border:1.5px solid #E0E0E0;border-radius:10px;font-size:0.88rem;padding:0.6rem;box-shadow:none;">
            </div>
        </div>
        
        <div style="padding:1.25rem 2rem;background:#F8F9FB;border-top:1px solid #F0F0F0;display:flex;align-items:center;justify-content:end;gap:0.75rem;">
            <button type="button" onclick="closeEditModal()" class="btn btn-outline-secondary" style="border-radius:10px;border:1.5px solid #E0E0E0;background:#fff;color:#555;font-weight:600;font-size:0.88rem;padding:0.5rem 1.25rem;">Batal</button>
            <button type="submit" class="btn btn-warning" style="background:#EAB308;border:none;border-radius:10px;color:#fff;font-weight:700;font-size:0.88rem;padding:0.5rem 1.5rem;">Simpan Perubahan</button>
        </div>
    </form>
</div>

<script>
    function openEditModal(user) {
        // Set form action dynamically
        const form = document.getElementById('editForm');
        form.action = `/admin/users/${user.id}`;
        
        // Populate inputs
        document.getElementById('edit_name').value = user.name;
        document.getElementById('edit_email').value = user.email;
        document.getElementById('edit_wa').value = user.nomor_wa || '';
        
        // Show Modal
        document.getElementById('editOverlay').style.opacity = '1';
        document.getElementById('editOverlay').style.visibility = 'visible';
        document.getElementById('editOverlay').style.pointerEvents = 'auto';
        
        const modal = document.getElementById('editModal');
        modal.style.opacity = '1';
        modal.style.visibility = 'visible';
        modal.style.transform = 'translate(-50%, -50%)';
        document.body.style.overflow = 'hidden';
    }

    function closeEditModal() {
        document.getElementById('editOverlay').style.opacity = '0';
        document.getElementById('editOverlay').style.visibility = 'hidden';
        document.getElementById('editOverlay').style.pointerEvents = 'none';
        
        const modal = document.getElementById('editModal');
        modal.style.opacity = '0';
        modal.style.visibility = 'hidden';
        modal.style.transform = 'translate(-50%, -45%)';
        document.body.style.overflow = '';
    }
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeEditModal();
        }
    });
</script>
@endsection
