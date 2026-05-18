@extends('layouts.admin')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Admin</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Akun Admin</h6>
            
            <button type="button" class="btn text-white fw-bold btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahAdmin" style="background-color: #D1A12C; border-radius: 20px; padding: 5px 15px;">
                + Tambah Admin
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th width="150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <form action="{{ route('superadmin.delete', $user->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus admin ini? Tindakan ini tidak bisa dibatalkan.')">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm shadow-sm">
                                        <i class="fas fa-trash fa-sm"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center">Tidak ada data admin ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahAdmin" tabindex="-1" aria-labelledby="modalTambahAdminLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <div class="modal-header" style="background-color: #4A2E80; color: white; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                <h5 class="modal-title fw-bold" id="modalTambahAdminLabel">Tambah Admin Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1);"></button>
            </div>
            <form action="{{ route('superadmin.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">NAMA ADMIN</label>
                        <input type="text" name="name" class="form-control" placeholder="Masukkan nama admin" required style="border-radius: 8px; padding: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">EMAIL</label>
                        <input type="email" name="email" class="form-control" placeholder="Masukkan email admin" required style="border-radius: 8px; padding: 10px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary">PASSWORD</label>
                        <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required style="border-radius: 8px; padding: 10px;">
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #efefef;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">Batal</button>
                    <button type="submit" class="btn text-white fw-bold px-4" style="background-color: #D1A12C; border-radius: 8px;">Simpan Admin</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection