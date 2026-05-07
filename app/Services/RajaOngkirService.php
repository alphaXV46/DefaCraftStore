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
     * Calculate ongkir semua kurir — cached per destination+weight
     */
   public function calculateAllCouriers(string $destinationId, int $weight = 1000): array
{
    $cacheKey = "ro_all_{$this->originId}_{$destinationId}_{$weight}";

    return Cache::remember($cacheKey, 10800, function () use ($destinationId, $weight) {
        try {
            // 1 request untuk JNE + JNT sekaligus
            $response = $this->http()
                ->asForm()
                ->post("{$this->baseUrl}/calculate/domestic-cost", [
                    'origin'      => $this->originId,
                    'destination' => $destinationId,
                    'weight'      => $weight,
                    'courier'     => 'jne:jnt', // 1 call, 2 kurir
                ]);

            if (!$response->successful()) return [];

            $services = $response->json('data', []);
            $results  = [];

            // Layanan yang diblacklist (terlalu cepat / tidak realistis)
            $blacklist = ['sameday', 'same day', 'YES', 'OKE'];

            foreach ($services as $service) {
                $cost    = (int) ($service['cost'] ?? 0);
                $service_name = strtoupper($service['service'] ?? '');

                // Skip sameday dan layanan yang tidak relevan
                $isSameday = false;
                foreach ($blacklist as $bl) {
                    if (stripos($service_name, $bl) !== false) {
                        $isSameday = true;
                        break;
                    }
                }
                if ($isSameday || $cost <= 0) continue;

                $results[] = [
                    'courier'     => strtoupper($service['code'] ?? ''),
                    'service'     => $service['service']     ?? '-',
                    'description' => $service['description'] ?? '',
                    'cost'        => $cost,
                    'etd'         => $service['etd']         ?? '-',
                ];
            }

            usort($results, fn($a, $b) => $a['cost'] - $b['cost']);
            return $results;

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