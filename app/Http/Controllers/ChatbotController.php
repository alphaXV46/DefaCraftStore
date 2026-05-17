<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class ChatbotController extends Controller
{
    /**
     * Send user message to Gemini API and return the response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function tanyaChatbot(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'pesan' => 'required|string|max:1000',
        ]);

        // 2. FITUR RATE LIMITER: Batasi 5 request per menit per IP User
        $ipUser = $request->ip();
        if (RateLimiter::tooManyAttempts('chatbot-gate:' . $ipUser, $perMinute = 5)) {
            $seconds = RateLimiter::availableIn('chatbot-gate:' . $ipUser);
            return response()->json([
                'jawaban' => "⚠️ Anda terlalu cepat mengirim pesan. Silakan coba lagi dalam {$seconds} detik."
            ], 429);
        }
        
        // Catat attempt jika belum melewati batas
        RateLimiter::hit('chatbot-gate:' . $ipUser, 60);

        $pesanUser = $request->input('pesan');
        $apiKey = config('services.gemini.key') ?? env('GEMINI_API_KEY');

        if (!$apiKey) {
            return response()->json([
                'jawaban' => 'Maaf, konfigurasi API Key Gemini tidak ditemukan di server. Silakan hubungi administrator.'
            ], 500);
        }

        // 3. FITUR CACHE: Buat kunci unik berdasarkan teks pertanyaan (huruf kecil semua)
        $stringBersih = Str::lower(trim($pesanUser));
        $cacheKey = 'bot_reply_' . md5($stringBersih);

        if (Cache::has($cacheKey)) {
            return response()->json([
                'jawaban' => Cache::get($cacheKey)
            ]);
        }

        try {
            // 4. Memanggil API Gemini 3.1 Flash Lite menggunakan Laravel HTTP Client
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-3.1-flash-lite:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $pesanUser]
                        ]
                    ]
                ],
                // Menambahkan instruksi agar bertindak sebagai Customer Service yang ramah dari DefaCraftStore
                'systemInstruction' => [
                    'parts' => [
                        ['text' => 'Kamu adalah Customer Service (CS) AI yang ramah, sopan, dan profesional dari DefaCraftStore. ' .
                                 'DefaCraftStore menjual berbagai produk seperti (gantungan kunci, dekorasi kamar, aksesoris, dll). ' .
                                 'Jawab pertanyaan pelanggan dengan singkat, jelas, sopan, dan menggunakan bahasa Indonesia yang santun. ' .
                                 'Jika pelanggan bertanya tentang cara pemesanan, pengembalian barang, atau pengiriman, arahkan mereka dengan sopan untuk melihat halaman bantuan yang relevan atau menu navigasi di web kami.']
                    ]
                ],
                // Mengatur konfigurasi generasi teks agar jawabannya ramah dan terkontrol
                'generationConfig' => [
                    'temperature' => 0.7,
                    'maxOutputTokens' => 800,
                ]
            ]);

            // 5. Menangani respon
            if ($response->successful()) {
                $hasil = $response->json();
                
                // Pastikan struktur respon valid
                if (isset($hasil['candidates'][0]['content']['parts'][0]['text'])) {
                    $jawabanAI = $hasil['candidates'][0]['content']['parts'][0]['text'];
                    
                    // Simpan ke cache selama 3 jam (180 menit) hanya jika respon sukses
                    Cache::put($cacheKey, $jawabanAI, now()->addMinutes(180));
                    
                    return response()->json(['jawaban' => $jawabanAI]);
                }
                
                Log::error('Struktur respon Gemini API tidak sesuai:', (array)$hasil);
                return response()->json([
                    'jawaban' => 'Maaf, saya tidak dapat memahami jawaban dari sistem AI saat ini. Silakan coba sesaat lagi.'
                ], 500);
            }

            Log::error('Gagal memanggil Gemini API. Status: ' . $response->status() . ' | Respon: ' . $response->body());
            return response()->json([
                'jawaban' => 'Maaf, sepertinya server AI sedang sibuk. Silakan coba kirim pesan Anda kembali.'
            ], 500);

        } catch (\Exception $e) {
            Log::error('Terjadi error pada ChatbotController: ' . $e->getMessage());
            return response()->json([
                'jawaban' => 'Terjadi kesalahan sistem saat menghubungi Customer Service AI. Silakan coba lagi nanti.'
            ], 500);
        }
    }
}
