<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    // ✅ Status constants (baru)
    const STATUS_PENDING       = 'pending';
    const STATUS_PAID          = 'paid';
    const STATUS_PROCESSING    = 'processing';
    const STATUS_SHIPPED       = 'shipped';
    const STATUS_COMPLETED     = 'completed';
    const STATUS_CANCELLED     = 'cancelled';
    const STATUS_EXPIRED       = 'expired';
    const STATUS_COD_PENDING   = 'cod_pending';
    const STATUS_REFUNDED      = 'refunded';

        protected $fillable = [
        // Field lama
        'user_id',
        'total_harga',
        'metode_pembayaran',
        'nama_pembeli',
        'alamat',
        'nomor_wa',
        'status',
        'bukti_bayar',
        'resi',
        'notes',
        // Field Midtrans & Checkout baru
        'order_id',
        'ongkir',
        'snap_token',
        'payment_type',
        'paid_at',
        'stock_reduced',
        'catatan',
        // Field Lokasi & Kurir (TAMBAHKAN INI!)
        'province_id',
        'city_id',
        'city_name',
        'kurir',
        'layanan_kurir',
        'estimasi',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'paid_at'       => 'datetime',
        'stock_reduced' => 'boolean',
    ];

    // ✅ Relasi lama (tidak diubah)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(TransaksiDetail::class);
    }

    // ✅ Method lama (tidak diubah)
    public function getStatusBadge()
    {
        $badges = [
            'pending'     => '<span class="badge bg-warning">Menunggu Pembayaran</span>',
            'paid'        => '<span class="badge bg-info">Dibayar</span>',
            'processing'  => '<span class="badge bg-primary">Diproses</span>',
            'shipped'     => '<span class="badge bg-success">Dikirim</span>',
            'completed'   => '<span class="badge bg-success">Selesai</span>',
            'cancelled'   => '<span class="badge bg-danger">Dibatalkan</span>',
            // ✅ Tambahan status baru
            'expired'     => '<span class="badge bg-secondary">Kedaluwarsa</span>',
            'cod_pending' => '<span class="badge bg-warning">COD - Menunggu</span>',
            'refunded'    => '<span class="badge bg-dark">Refund</span>',
        ];

        return $badges[$this->status] ?? '<span class="badge bg-secondary">Unknown</span>';
    }

    // ✅ Helper baru
    public function isPaid(): bool
    {
        return in_array($this->status, [
            self::STATUS_PAID,
            self::STATUS_PROCESSING,
            self::STATUS_SHIPPED,
            self::STATUS_COMPLETED,
        ]);
    }

    public function isExpired(): bool
    {
        return $this->status === self::STATUS_EXPIRED;
    }

    public function isCOD(): bool
    {
        return $this->metode_pembayaran === 'COD';
    }
}