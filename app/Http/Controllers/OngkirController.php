<?php

namespace App\Http\Controllers;

use App\Services\RajaOngkirService;
use Illuminate\Http\Request;

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

        $results = $this->rajaOngkir->searchDestination($keyword);
        return response()->json($results);
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'destination_id' => 'required|string',
            'weight'         => 'nullable|integer|min:100|max:1000',
        ]);

        // Pre-flight check — destination_id harus valid (angka)
        if (!is_numeric($request->destination_id)) {
            return response()->json(['error' => 'Destination tidak valid.'], 422);
        }

        $weight  = min($request->weight ?? 1000, 1000);
        $results = $this->rajaOngkir->calculateAllCouriers($request->destination_id, $weight);

        // Deteksi API limit habis
        if (!empty($results['limit'])) {
            return response()->json([
                'status'  => 'limit',
                'message' => $results['message'] ?? 'Account limit reached',
            ], 200); // kirim 200 agar fetch tidak throw, frontend cek 'status'
        }

        // Respons baru: { grouped: {...}, all: [...] }
        if (empty($results) || empty($results['all'] ?? [])) {
            return response()->json(['error' => 'Tidak dapat menghitung ongkir untuk tujuan ini.'], 422);
        }

        return response()->json($results);
    }
}