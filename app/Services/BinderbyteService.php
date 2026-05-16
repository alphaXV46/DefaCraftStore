<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class BinderbyteService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://api.binderbyte.com/v1';
    protected string $originCity;

    public function __construct()
    {
        $this->apiKey     = config('services.binderbyte.api_key');
        $this->originCity = config('services.binderbyte.origin_city', 'Bogor');
    }

    /**
     * HTTP client dengan SSL verify off untuk local development
     */
    protected function http()
    {
        return Http::withOptions(['verify' => false])
                   ->timeout(15);
    }

    /**
     * Ambil semua provinsi — di-cache 24 jam
     */
    public function getProvinces(): array
    {
        return Cache::remember('binderbyte_provinces', 86400, function () {
            $response = $this->http()->get("{$this->baseUrl}/province", [
                'api_key' => $this->apiKey,
            ]);

            if (!$response->successful()) return [];

            $data = $response->json();

            // Binderbyte bisa return {value: [...]} atau langsung [...]
            if (isset($data['value'])) return $data['value'];
            if (isset($data['data']))  return $data['data'];
            if (is_array($data))       return $data;

            return [];
        });
    }

    /**
     * Ambil kota berdasarkan province_id — di-cache 24 jam
     */
    public function getCities(string $provinceId): array
    {
        return Cache::remember("binderbyte_cities_{$provinceId}", 86400, function () use ($provinceId) {
            $response = $this->http()->get("{$this->baseUrl}/city", [
                'api_key'     => $this->apiKey,
                'id_province' => $provinceId,
            ]);

            if (!$response->successful()) return [];

            $data = $response->json();

            if (isset($data['value'])) return $data['value'];
            if (isset($data['data']))  return $data['data'];
            if (is_array($data))       return $data;

            return [];
        });
    }

    /**
     * Hitung ongkir
     */
    public function calculateShipping(string $destinationCityId, int $weight, array $couriers = ['jne', 'jnt', 'sicepat']): array
    {
        $originCityId = $this->getOriginCityId();

        if (!$originCityId) return [];

        $results = [];

        foreach ($couriers as $courier) {
            try {
                $response = $this->http()->get("{$this->baseUrl}/cost", [
                    'api_key'     => $this->apiKey,
                    'courier'     => $courier,
                    'origin'      => $originCityId,
                    'destination' => $destinationCityId,
                    'weight'      => $weight,
                ]);

                if (!$response->successful()) continue;

                $data = $response->json();

                // Ambil costs dari berbagai kemungkinan struktur
                $costs = $data['data']['costs']
                      ?? $data['value']['costs']
                      ?? $data['costs']
                      ?? [];

                foreach ($costs as $cost) {
                    $price = $cost['cost'][0]['value'] ?? $cost['price'] ?? 0;
                    $etd   = $cost['cost'][0]['etd']   ?? $cost['etd']   ?? '-';

                    $results[] = [
                        'courier'     => strtoupper($courier),
                        'service'     => $cost['service']     ?? $cost['service_name'] ?? '-',
                        'description' => $cost['description'] ?? '',
                        'cost'        => (int) $price,
                        'etd'         => $etd . (str_contains($etd, 'hari') ? '' : ' hari'),
                        'label'       => strtoupper($courier) . ' ' . ($cost['service'] ?? '') .
                                         ' - Rp ' . number_format($price, 0, ',', '.') .
                                         ' (' . $etd . ' hari)',
                    ];
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        return $results;
    }

    /**
     * Cari city ID berdasarkan nama kota
     */
    public function findCityId(string $cityName): ?string
    {
        // Bersihkan nama kota dari prefix "Kota"/"Kabupaten"
        $cleanName = str_ireplace(['kota ', 'kabupaten ', 'kab. ', 'kab '], '', $cityName);

        $provinces = $this->getProvinces();

        foreach ($provinces as $province) {
            $provinceId = $province['id'] ?? $province['province_id'] ?? null;
            if (!$provinceId) continue;

            $cities = $this->getCities((string) $provinceId);

            foreach ($cities as $city) {
                $name = $city['city_name'] ?? $city['name'] ?? '';
                $id   = $city['id']        ?? $city['city_id'] ?? null;

                if (!$id) continue;

                // Match dengan berbagai variasi nama
                if (
                    stripos($name, $cleanName)   !== false ||
                    stripos($cleanName, $name)   !== false ||
                    stripos($name, $cityName)    !== false ||
                    stripos($cityName, $name)    !== false
                ) {
                    return (string) $id;
                }
            }
        }

        return null;
    }

    /**
     * Ambil origin city ID — di-cache
     */
    protected function getOriginCityId(): ?string
    {
        return Cache::remember('binderbyte_origin_city_id', 86400, function () {
            return $this->findCityId($this->originCity);
        });
    }

    /**
     * Ambil struktur data provinsi yang benar untuk dropdown
     */
    public function getProvincesForDropdown(): array
    {
        $provinces = $this->getProvinces();

        return array_map(function($p) {
            return [
                'id'   => $p['id']            ?? $p['province_id'] ?? '',
                'name' => $p['province_name'] ?? $p['name']        ?? '',
            ];
        }, $provinces);
    }

    /**
     * Ambil struktur data kota yang benar untuk dropdown
     */
    public function getCitiesForDropdown(string $provinceId): array
    {
        $cities = $this->getCities($provinceId);

        return array_map(function($c) {
            return [
                'id'   => $c['id']        ?? $c['city_id']   ?? '',
                'name' => ($c['type'] ?? '') . ' ' . ($c['city_name'] ?? $c['name'] ?? ''),
            ];
        }, $cities);
    }
}