<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class RajaOngkirService
{
    protected string $apiKey;
    protected string $baseUrl;
    protected string $originId;

    public function __construct()
    {
        $this->apiKey   = config('services.rajaongkir.api_key');
        $this->baseUrl  = rtrim(config('services.rajaongkir.base_url', 'https://rajaongkir.komerce.id/api/v1'), '/');
        $this->originId = config('services.rajaongkir.origin', '114');
    }

    protected function http()
    {
        return Http::withOptions(['verify' => false])
                   ->withHeaders(['key' => $this->apiKey])
                   ->timeout(30);
    }

    /**
     * Search destination by keyword — cached 24 jam
     */
    public function searchDestination(string $keyword): array
    {
        $cacheKey = 'rajaongkir_search_' . md5(strtolower(trim($keyword)));

        return Cache::remember($cacheKey, 86400, function () use ($keyword) {
            try {
                $response = $this->http()->get("{$this->baseUrl}/destination/domestic-destination", [
                    'search' => $keyword,
                    'limit'  => 100, // Tambahkan limit agar semua opsi kode pos muncul
                ]);

                if (!$response->successful()) {
                    Log::warning('searchDestination failed', [
                        'status' => $response->status(),
                        'body'   => $response->body(),
                    ]);
                    return [];
                }

                $body = $response->json();
                return $body['data'] ?? [];

            } catch (\Exception $e) {
                Log::error('searchDestination error: ' . $e->getMessage());
                return [];
            }
        });
    }

    /**
     * Calculate ongkir untuk satu kurir
     */
    public function calculateCost(string $destinationId, int $weight, string $courier): array
    {
        $cacheKey = "rajaongkir_cost_{$destinationId}_{$weight}_{$courier}";

        return Cache::remember($cacheKey, 3600, function () use ($destinationId, $weight, $courier) {
            try {
                $response = $this->http()
                    ->asForm()
                    ->post("{$this->baseUrl}/calculate/domestic-cost", [
                        'origin'      => $this->originId,
                        'destination' => $destinationId,
                        'weight'      => $weight,
                        'courier'     => $courier,
                    ]);

                if (!$response->successful()) {
                    Log::warning("calculateCost [{$courier}] failed", [
                        'status' => $response->status(),
                        'body'   => $response->body(),
                    ]);
                    return [];
                }

                $body = $response->json();
                return $body['data'] ?? [];

            } catch (\Exception $e) {
                Log::error("calculateCost [{$courier}] error: " . $e->getMessage());
                return [];
            }
        });
    }

    /**
     * Calculate ongkir semua kurir (JNE, J&T, TIKI) — grouped by courier
     * Mengembalikan struktur: [ 'grouped' => [...], 'all' => [...] ]
     */
    public function calculateAllCouriers(string $destinationId, int $weight = 1000): array
    {
        // Clamp berat: semua produk di bawah 1kg
        $weight = min($weight, 1000);

        $cacheKey = "ro_all_{$this->originId}_{$destinationId}_{$weight}";

        return Cache::remember($cacheKey, 10800, function () use ($destinationId, $weight) {
            try {
                $response = $this->http()
                    ->asForm()
                    ->post("{$this->baseUrl}/calculate/domestic-cost", [
                        'origin'      => $this->originId,
                        'destination' => $destinationId,
                        'weight'      => $weight,
                        'courier'     => 'jne:jnt:tiki',
                    ]);

                $statusCode = $response->status();
                $bodyString = strtolower($response->body());
                if ($statusCode == 400 || str_contains($bodyString, 'limit reached') || str_contains($bodyString, 'limit exceeded')) {
                    return ['limit' => true, 'message' => 'Account limit reached'];
                }

                if (!$response->successful()) return [];

                $services = $response->json('data', []);
                $results  = [];

                // Blacklist: hanya layanan sameday dan cargo/berat
                $blacklist = ['sameday', 'same day', 'cargo', 'trucking', 'pelikan'];

                foreach ($services as $service) {
                    $cost         = (int) ($service['cost'] ?? 0);
                    $serviceName  = $service['service'] ?? '';

                    // Skip blacklisted services
                    $isBlacklisted = false;
                    foreach ($blacklist as $bl) {
                        if (stripos($serviceName, $bl) !== false) {
                            $isBlacklisted = true;
                            break;
                        }
                    }
                    if ($isBlacklisted || $cost <= 0) continue;

                    $results[] = [
                        'courier'     => strtoupper($service['code'] ?? ''),
                        'service'     => $serviceName,
                        'description' => $service['description'] ?? '',
                        'cost'        => $cost,
                        'etd'         => $service['etd'] ?? '-',
                    ];
                }

                // Group by courier, sort each group by cost, take max 3 per courier
                $grouped = [];
                foreach ($results as $item) {
                    $key = $item['courier'];
                    if (!isset($grouped[$key])) {
                        $grouped[$key] = [];
                    }
                    $grouped[$key][] = $item;
                }

                foreach ($grouped as $key => &$items) {
                    usort($items, fn($a, $b) => $a['cost'] - $b['cost']);
                    $items = array_slice($items, 0, 3);
                }
                unset($items);

                // Build flat list (all items sorted by cost)
                $all = [];
                foreach ($grouped as $items) {
                    foreach ($items as $item) {
                        $all[] = $item;
                    }
                }
                usort($all, fn($a, $b) => $a['cost'] - $b['cost']);

                return [
                    'grouped' => $grouped,
                    'all'     => $all,
                ];

            } catch (\Exception $e) {
                Log::error('calculateAllCouriers: ' . $e->getMessage());
                return [];
            }
        });
    }
    /**
     * Clear cache untuk destination tertentu
     * Dipanggil kalau perlu refresh data
     */
    public function clearCache(string $destinationId, int $weight = 1000): void
    {
        $couriers = ['jne', 'sicepat', 'jnt', 'anteraja', 'tiki'];
        Cache::forget("rajaongkir_all_couriers_{$destinationId}_{$weight}");
        foreach ($couriers as $courier) {
            Cache::forget("rajaongkir_cost_{$destinationId}_{$weight}_{$courier}");
        }
    }
}