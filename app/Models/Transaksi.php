<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    
    protected $fillable = [
        'user_id',
        'total_harga',
        'metode_pembayaran',
        'nama_pembeli',
        'alamat',
        'nomor_wa',
        'status',
        'bukti_bayar',
        'resi',
        'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function details()
    {
        return $this->hasMany(TransaksiDetail::class);
    }
    
    // Helper method untuk status badge
    public function getStatusBadge()
    {
        $badges = [
            'pending' => '<span class="badge bg-warning">Menunggu Pembayaran</span>',
            'paid' => '<span class="badge bg-info">Dibayar</span>',
            'processing' => '<span class="badge bg-primary">Diproses</span>',
            'shipped' => '<span class="badge bg-success">Dikirim</span>',
            'completed' => '<span class="badge bg-success">Selesai</span>',
            'cancelled' => '<span class="badge bg-danger">Dibatalkan</span>',
        ];
        
        return $badges[$this->status] ?? '<span class="badge bg-secondary">Unknown</span>';
    }
}