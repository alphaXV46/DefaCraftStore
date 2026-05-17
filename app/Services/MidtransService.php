<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey    = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized  = true;
        Config::$is3ds        = true;
    }

    public function createSnapToken(array $params): string
    {
        return Snap::getSnapToken($params);
    }

    public function buildParams($transaksi, $user): array
    {
        $items = $transaksi->details->map(fn($d) => [
            'id'       => $d->produk_id,
            'price'    => (int) $d->harga,
            'quantity' => $d->jumlah,
            'name'     => substr($d->nama_produk, 0, 50),
        ])->toArray();

        // Tambah ongkir sebagai item kalau ada
        if ($transaksi->ongkir > 0) {
            $items[] = [
                'id'       => 'ONGKIR',
                'price'    => (int) $transaksi->ongkir,
                'quantity' => 1,
                'name'     => 'Ongkos Kirim',
            ];
        }

        $enabledPayments = [];
        if ($transaksi->metode_pembayaran === 'QRIS') {
            $enabledPayments = ['other_qris'];
        } elseif ($transaksi->metode_pembayaran === 'VA') {
            $enabledPayments = ['bca_va', 'bni_va', 'bri_va', 'permata_va'];
        } elseif ($transaksi->metode_pembayaran === 'CC') {
            $enabledPayments = ['credit_card'];
        } else {
            $enabledPayments = ['other_qris', 'bca_va', 'bni_va', 'bri_va', 'credit_card'];
        }

        return [
            'transaction_details' => [
                'order_id'     => $transaksi->order_id,
                'gross_amount' => (int) $transaksi->total_harga,
            ],
            'customer_details' => [
                'first_name' => $transaksi->nama_pembeli,
                'phone'      => $transaksi->nomor_wa,
                'email'      => $user->email ?? 'noemail@example.com',
            ],
            'item_details'  => $items,
            'enabled_payments' => $enabledPayments,
            'expiry' => [
                'unit'     => 'minutes',
                'duration' => 30,
            ],
        ];
    }

    public function verifyWebhook(): Notification
    {
        return new Notification();
    }
}