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
        'nomor_wa'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}