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

        // Rate limit sekarang ditangani oleh middleware `throttle:ongkir` di routes/web.php

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

        // Rate limit sekarang ditangani oleh middleware `throttle:ongkir` di routes/web.php

        $weight  = $request->weight ?? 1000;
        $results = $this->rajaOngkir->calculateAllCouriers($request->destination_id, $weight);

        if (empty($results)) {
            return response()->json(['error' => 'Tidak dapat menghitung ongkir untuk tujuan ini.'], 422);
        }

        return response()->json($results);
    }
}