<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    
    protected $fillable = [
        'nama',
        'deskripsi',
        'harga',
        'kategori',
        'gambar',
        'stok' // Tambah ini
    ];

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class);
    }
    
    public function transaksiDetail()
    {
        return $this->hasMany(TransaksiDetail::class);
    }
    
    // Method helper untuk cek stok
    public function hasStock($jumlah)
    {
        return $this->stok >= $jumlah;
    }
    
    // Method untuk kurangi stok
    public function decreaseStock($jumlah)
    {
        if ($this->hasStock($jumlah)) {
            $this->decrement('stok', $jumlah);
            return true;
        }
        return false;
    }
    
    // Method untuk tambah stok (kalau cancel order)
    public function increaseStock($jumlah)
    {
        $this->increment('stok', $jumlah);
    }
}