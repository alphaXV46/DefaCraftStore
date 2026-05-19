<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserManagementController extends Controller
{
    /**
     * Display a listing of customer users.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'user');

        // Search name or email
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nomor_wa', 'like', "%{$search}%");
            });
        }

        // Filter status (active/banned)
        if ($request->filled('status')) {
            $status = $request->input('status');
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'banned') {
                $query->where('is_active', false);
            }
        }

        $users = $query->orderBy('created_at', 'desc')->get();

        // Calculate statistics for customers
        $totalCustomers = User::where('role', 'user')->count();
        $activeCustomers = User::where('role', 'user')->where('is_active', true)->count();
        $bannedCustomers = User::where('role', 'user')->where('is_active', false)->count();

        return view('admin.user_management', compact('users', 'totalCustomers', 'activeCustomers', 'bannedCustomers'));
    }

    /**
     * Update the customer user's information.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'nomor_wa' => 'nullable|string|max:20',
        ]);

        $oldName = $user->name;
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'nomor_wa' => $request->input('nomor_wa'),
        ]);

        // Catat ke Log Aktivitas
        DB::table('logs')->insert([
            'user_id' => auth()->id(),
            'activity' => 'Edit Pelanggan',
            'description' => auth()->user()->name . ' memperbarui profil pelanggan: ' . $oldName . ' (ID: ' . $user->id . ')',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Data profil pelanggan berhasil diperbarui!');
    }

    /**
     * Toggle active/banned status of the customer.
     */
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();

        $action = $user->is_active ? 'Mengaktifkan' : 'Memblokir';
        $logActivity = $user->is_active ? 'Unban Pelanggan' : 'Ban Pelanggan';

        // Catat ke Log Aktivitas
        DB::table('logs')->insert([
            'user_id' => auth()->id(),
            'activity' => $logActivity,
            'description' => auth()->user()->name . ' ' . strtolower($action) . ' akun pelanggan: ' . $user->name . ' (ID: ' . $user->id . ')',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', "Akun pelanggan {$user->name} berhasil " . ($user->is_active ? 'diaktifkan kembali!' : 'ditangguhkan (Banned)!'));
    }

    /**
     * Reset customer password to a secure temporary password.
     */
    public function resetPassword($id)
    {
        $user = User::findOrFail($id);
        
        // Generate secure random password
        $tempPassword = Str::random(8);
        $user->password = Hash::make($tempPassword);
        $user->save();

        // Catat ke Log Aktivitas
        DB::table('logs')->insert([
            'user_id' => auth()->id(),
            'activity' => 'Reset Password Pelanggan',
            'description' => auth()->user()->name . ' mereset password pelanggan: ' . $user->name . ' (ID: ' . $user->id . ')',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', "Password pelanggan {$user->name} berhasil di-reset!")
                     ->with('temp_password', $tempPassword)
                     ->with('temp_user_name', $user->name);
    }

    /**
     * Remove the customer user's account.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $name = $user->name;
        $user->delete();

        // Catat ke Log Aktivitas
        DB::table('logs')->insert([
            'user_id' => auth()->id(),
            'activity' => 'Hapus Pelanggan',
            'description' => auth()->user()->name . ' menghapus permanen akun pelanggan: ' . $name . ' (ID: ' . $id . ')',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', "Akun pelanggan {$name} berhasil dihapus secara permanen!");
    }
}
