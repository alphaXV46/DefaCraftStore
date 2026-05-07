<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Services\MidtransService;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransWebhookController extends Controller
{
    protected MidtransService $midtrans;
    protected StockService $stock;

    public function __construct(MidtransService $midtrans, StockService $stock)
    {
        $this->midtrans = $midtrans;
        $this->stock    = $stock;
    }

    public function handle(Request $request)
    {
        try {
            // Verifikasi notifikasi dari Midtrans
            $notification = $this->midtrans->verifyWebhook();

            $orderId           = $notification->order_id;
            $statusCode        = $notification->status_code;
            $grossAmount       = $notification->gross_amount;
            $signatureKey      = $notification->signature_key;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus       = $notification->fraud_status ?? null;
            $paymentType       = $notification->payment_type ?? null;

            // ✅ VALIDASI SIGNATURE SHA512 (CRITICAL)
            $serverKey = env('MIDTRANS_SERVER_KEY');
            $calculatedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

            if ($calculatedSignature !== $signatureKey) {
                \Illuminate\Support\Facades\Log::warning('Midtrans Webhook: Invalid Signature', [
                    'order_id' => $orderId,
                    'expected' => $calculatedSignature,
                    'received' => $signatureKey,
                ]);
                // Tolak request jika signature tidak cocok (bisa 403 atau 400)
                return response()->json(['message' => 'Invalid Signature'], 403);
            }

            Log::info('Midtrans Webhook', [
                'order_id' => $orderId,
                'status'   => $transactionStatus,
                'fraud'    => $fraudStatus,
            ]);

            $transaksi = Transaksi::where('order_id', $orderId)->first();

            if (!$transaksi) {
                Log::warning('Webhook: order_id tidak ditemukan', ['order_id' => $orderId]);
                return response()->json(['message' => 'Order not found'], 404);
            }

            // Tentukan status berdasarkan respons Midtrans
            if ($transactionStatus === 'capture') {
                $newStatus = ($fraudStatus === 'accept')
                    ? Transaksi::STATUS_PAID
                    : Transaksi::STATUS_CANCELLED;

            } elseif ($transactionStatus === 'settlement') {
                $newStatus = Transaksi::STATUS_PAID;

            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'failure'])) {
                $newStatus = Transaksi::STATUS_CANCELLED;

            } elseif ($transactionStatus === 'expire') {
                $newStatus = Transaksi::STATUS_EXPIRED;

            } elseif ($transactionStatus === 'pending') {
                $newStatus = Transaksi::STATUS_PENDING;

            } else {
                $newStatus = $transaksi->status; // tidak diubah kalau tidak dikenal
            }

            // Kalau pembayaran berhasil dan stok belum dikurangi
            if ($newStatus === Transaksi::STATUS_PAID && !$transaksi->stock_reduced) {
                $this->stock->decreaseStock($transaksi);
                $transaksi->update([
                    'status'        => $newStatus,
                    'payment_type'  => $paymentType,
                    'paid_at'       => now(),
                    'stock_reduced' => true,
                ]);

            // Kalau expired/cancel dan stok sudah terlanjur dikurangi — kembalikan
            } elseif (in_array($newStatus, [Transaksi::STATUS_EXPIRED, Transaksi::STATUS_CANCELLED])) {
                $this->stock->restoreStock($transaksi);
                $transaksi->update(['status' => $newStatus]);

            } else {
                $transaksi->update(['status' => $newStatus]);
            }

            return response()->json(['message' => 'OK'], 200);

        } catch (\Exception $e) {
            Log::error('Midtrans Webhook Error: ' . $e->getMessage());
            return response()->json(['message' => 'Server Error'], 500);
        }
    }
}