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
        'gambar'
    ];

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class);
    }
}