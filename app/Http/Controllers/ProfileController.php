<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        
        $totalPesanan  = \App\Models\Transaksi::where('user_id', $user->id)->count();
        $totalSelesai  = \App\Models\Transaksi::where('user_id', $user->id)->where('status', 'completed')->count();
        $totalWishlist = \App\Models\Wishlist::where('user_id', $user->id)->count();
        $totalBelanja  = \App\Models\Transaksi::where('user_id', $user->id)->whereIn('status', ['paid','processing','shipped','completed'])->sum('total_harga');
        $recentOrders  = \App\Models\Transaksi::with('details.produk')->where('user_id', $user->id)->orderBy('created_at', 'desc')->take(3)->get();

        return view('profile.edit', compact(
            'user', 'totalPesanan', 'totalSelesai', 'totalWishlist', 'totalBelanja', 'recentOrders'
        ));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
