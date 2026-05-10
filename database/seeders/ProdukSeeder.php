<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        DB::table('produk')->insert([
            [
                'nama' => 'Nanci Premium 1',
                'deskripsi' => 'Boneka Nanci handmade dengan kualitas premium dan detail yang rapi.',
                'harga' => 150000.00,
                'kategori' => 'Boneka',
                'gambar' => '1776375834_nanci 1.webp',
                'stok' => 15,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'Nanci Edition 2',
                'deskripsi' => 'Varian kedua dari koleksi Nanci, cocok untuk kado spesial.',
                'harga' => 125000.00,
                'kategori' => 'Boneka',
                'gambar' => '1776375938_nanci 2.webp',
                'stok' => 10,
                'created_at' => $now,
                'updated_at' => $now,
            ],           
            [
                'nama' => 'Nanci Classic 3',
                'deskripsi' => 'Edisi klasik Nanci dengan balutan warna yang lembut.',
                'harga' => 135000.00,
                'kategori' => 'Boneka',
                'gambar' => '1776376094_nanci 3.webp',
                'stok' => 8,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'Nanci Blue Edition',
                'deskripsi' => 'Edisi terbatas Nanci dengan tema warna biru.',
                'harga' => 145000.00,
                'kategori' => 'Boneka',
                'gambar' => '1776376253_nanci 4.webp',
                'stok' => 12,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}