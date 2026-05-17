<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = ['nama', 'slug'];

    // Relasi ke Produk: Satu kategori punya banyak produk
    public function produk()
    {
        return $this->hasMany(Produk::class, 'kategori_id');
    }
}
