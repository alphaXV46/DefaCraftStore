<?php

namespace App\Http\Controllers;

use App\Services\RajaOngkirService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;

class OngkirController extends Controller
{
    protected RajaOngkirService $rajaOngkir;

    public function __construct(RajaOngkirService $rajaOngkir)
    {
        $this->rajaOngkir = $rajaOngkir;
    }

    public function searchDestination(Request $request)
    {
        $request->validate(['search' => 'required|string|min:3|max:100']);

        $keyword = trim($request->search);

        // Rate limit: max 30 request search per menit per IP
        $key = 'ongkir_search_' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 30)) {
            return response()->json(['error' => 'Terlalu banyak request, coba lagi nanti.'], 429);
        }
        RateLimiter::hit($key, 60);

        $results = $this->rajaOngkir->searchDestination($keyword);
        return response()->json($results);
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'destination_id' => 'required|string',
            'weight'         => 'nullable|integer|min:100|max:30000',
        ]);

        // Pre-flight check — destination_id harus valid (angka)
        if (!is_numeric($request->destination_id)) {
            return response()->json(['error' => 'Destination tidak valid.'], 422);
        }

        // Rate limit: max 20 request calculate per menit per IP
        $key = 'ongkir_calculate_' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 20)) {
            return response()->json(['error' => 'Terlalu banyak request, coba lagi nanti.'], 429);
        }
        RateLimiter::hit($key, 60);

        $weight  = $request->weight ?? 1000;
        $results = $this->rajaOngkir->calculateAllCouriers($request->destination_id, $weight);

        if (empty($results)) {
            return response()->json(['error' => 'Tidak dapat menghitung ongkir untuk tujuan ini.'], 422);
        }

        return response()->json($results);
    }
}