<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminManagementController extends Controller
{
    // Lihat daftar Admin
    public function index() {
        $users = User::where('role', 'admin')->get();
        return view('admin.user_index', compact('users'));
    }

    // Hapus Admin
    public function destroy($id) {
        $user = User::findOrFail($id);
        $nama = $user->name;
        $user->delete();

        // Catat ke Log!
        \DB::table('logs')->insert([
            'user_id' => auth()->id(),
            'activity' => 'Hapus Admin',
            'description' => auth()->user()->name . ' menghapus akses admin: ' . $nama,
            'created_at' => now(), 'updated_at' => now(),
        ]);

        return back()->with('success', 'Admin berhasil dihapus!');
    }

    // Tambah Admin Baru (BAGIAN BARU)
    public function store(Request $request) {
        // 1. Validasi inputan form biar data gak ngasal/email gak kembar
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // 2. Simpan data admin baru ke tabel users
        $adminBaru = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Password wajib di-hash biar aman
            'role' => 'admin', // Otomatis set jabatannya jadi admin
        ]);

        // 3. Catat aktivitas tambah admin ke Log!
        \DB::table('logs')->insert([
            'user_id' => auth()->id(),
            'activity' => 'Tambah Admin',
            'description' => auth()->user()->name . ' menambahkan admin baru: ' . $adminBaru->name,
            'created_at' => now(), 'updated_at' => now(),
        ]);

        // 4. Balikkan ke halaman manajemen admin dengan notifikasi sukses
        return back()->with('success', 'Admin baru berhasil ditambahkan!');
    }
}