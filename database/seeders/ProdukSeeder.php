<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produk;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        $produk = [
            [
                'nama' => 'Boneka Beruang Lucu',
                'deskripsi' => 'Boneka beruang super lembut dan menggemaskan',
                'harga' => 150000,
                'kategori' => 'Boneka',
                'gambar' => 'boneka1.jpg',
                'stok' => 25  // TAMBAH INI
            ],
            [
                'nama' => 'Gantungan Kunci Kucing',
                'deskripsi' => 'Gantungan kunci bentuk kucing imut',
                'harga' => 35000,
                'kategori' => 'Aksesoris',
                'gambar' => 'aksesoris1.jpg',
                'stok' => 50  // TAMBAH INI
            ],
            [
                'nama' => 'Lampion Hias Warna-Warni',
                'deskripsi' => 'Lampion cantik untuk dekorasi kamar',
                'harga' => 75000,
                'kategori' => 'Dekorasi',
                'gambar' => 'dekorasi1.jpg',
                'stok' => 15  // TAMBAH INI
            ],
            [
                'nama' => 'Bantal Karakter Panda',
                'deskripsi' => 'Bantal empuk dengan desain panda lucu',
                'harga' => 125000,
                'kategori' => 'Boneka',
                'gambar' => 'boneka2.jpg',
                'stok' => 30  // TAMBAH INI
            ],
            [
                'nama' => 'Tas Rajut Mini',
                'deskripsi' => 'Tas rajut kecil untuk penyimpanan aksesoris',
                'harga' => 65000,
                'kategori' => 'Aksesoris',
                'gambar' => 'aksesoris2.jpg',
                'stok' => 20  // TAMBAH INI
            ],
        ];

        foreach ($produk as $p) {
            Produk::create($p);
        }
    }
}