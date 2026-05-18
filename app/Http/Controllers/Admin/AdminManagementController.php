<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // <--- TAMBAHKAN BARIS INI!
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
}