<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{ protected $table = 'produk'; // Tambahkan baris ini di dalam class
   
    
 protected $fillable = [
    'nama', 
    'kategori_id', // WAJIB ADA DISINI
    'harga', 
    'harga_diskon', 
    'stok', 
    'deskripsi', 
    'gambar', 
    'status'
];
// Helper untuk mengecek apakah sedang diskon
public function getHargaFinalAttribute()
{
    return ($this->harga_diskon > 0) ? $this->harga_diskon : $this->harga;
}
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
    public function kategori()
{
    // Produk ini 'milik' Kategori (belongsTo)
    return $this->belongsTo(Kategori::class, 'kategori_id');
}
}