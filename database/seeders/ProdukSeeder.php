<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
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

        // Kosongkan tabel produk dan kategori secara aman dengan menonaktifkan foreign key checks sementara
        Schema::disableForeignKeyConstraints();
        DB::table('produk')->truncate();
        DB::table('kategori')->truncate();
        Schema::enableForeignKeyConstraints();

        // 1. Seed Tabel Kategori
        $kategoriIds = [];
        
        $kategoris = [
            'blind-box' => [
                'nama' => 'Blind Box',
                'slug' => 'blind-box',
                'created_at' => $now,
                'updated_at' => $now
            ],
            'action-figure' => [
                'nama' => 'Action Figure',
                'slug' => 'action-figure',
                'created_at' => $now,
                'updated_at' => $now
            ],
            'boneka' => [
                'nama' => 'Boneka',
                'slug' => 'boneka',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];

        foreach ($kategoris as $key => $kat) {
            $id = DB::table('kategori')->insertGetId($kat);
            $kategoriIds[$key] = $id;
        }

        // 2. Seed Tabel Produk terasosiasi dengan Kategori
        DB::table('produk')->insert([
            // --- BLIND BOX ---
            [
                'nama' => 'Nanci Sweet Forest Series',
                'kategori_id' => $kategoriIds['blind-box'],
                'kategori' => 'Blind Box',
                'deskripsi' => 'Blind Box Nanci Sweet Forest series dengan detail yang sangat menggemaskan dan rapi, cocok untuk koleksi pribadi Anda.',
                'harga' => 150000.00,
                'harga_diskon' => 0,
                'gambar' => 'nanci_forest.webp',
                'stok' => 12,
                'status' => 'published',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'Laura Trend Toy Series',
                'kategori_id' => $kategoriIds['blind-box'],
                'kategori' => 'Blind Box',
                'deskripsi' => 'Blind Box Laura series bertema tren fashion modern yang trendi, koleksi wajib bagi para pencinta art toys.',
                'harga' => 165000.00,
                'harga_diskon' => 149000.00, // Diskon premium
                'gambar' => 'laura_trend.webp',
                'stok' => 15,
                'status' => 'published',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // --- ACTION FIGURE ---
            [
                'nama' => 'One Piece Luffy Gear 5 Figure',
                'kategori_id' => $kategoriIds['action-figure'],
                'kategori' => 'Action Figure',
                'deskripsi' => 'Action Figure Monkey D. Luffy Gear 5 Sun God Nika dengan detail tekstur tinggi, pose bertarung yang dinamis, dan efek awan transparan.',
                'harga' => 299000.00,
                'harga_diskon' => 0,
                'gambar' => 'luffy_gear5.webp',
                'stok' => 5,
                'status' => 'published',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'Naruto Shippuden Uzumaki Naruto Sage Mode',
                'kategori_id' => $kategoriIds['action-figure'],
                'kategori' => 'Action Figure',
                'deskripsi' => 'Action figure Uzumaki Naruto dalam mode Sage. Menggunakan bahan PVC berkualitas tinggi dengan pewarnaan gradasi premium.',
                'harga' => 250000.00,
                'harga_diskon' => 220000.00,
                'gambar' => 'naruto_sage.webp',
                'stok' => 8,
                'status' => 'published',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // --- BONEKA ---
            [
                'nama' => 'Nanci Premium 1',
                'kategori_id' => $kategoriIds['boneka'],
                'kategori' => 'Boneka',
                'deskripsi' => 'Boneka Nanci handmade rajutan dengan kualitas premium, bahan wol halus dan detail yang sangat rapi.',
                'harga' => 150000.00,
                'harga_diskon' => 0,
                'gambar' => '1776375834_nanci 1.webp',
                'stok' => 15,
                'status' => 'published',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'Nanci Edition 2',
                'kategori_id' => $kategoriIds['boneka'],
                'kategori' => 'Boneka',
                'deskripsi' => 'Varian kedua dari koleksi rajut boneka Nanci, sangat cocok untuk kado ulang tahun atau pajangan dekoratif spesial.',
                'harga' => 125000.00,
                'harga_diskon' => 0,
                'gambar' => '1776375938_nanci 2.webp',
                'stok' => 10,
                'status' => 'published',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'Nanci Classic 3',
                'kategori_id' => $kategoriIds['boneka'],
                'kategori' => 'Boneka',
                'deskripsi' => 'Edisi klasik Nanci handmade dengan balutan gaun warna lembut rajutan tangan.',
                'harga' => 135000.00,
                'harga_diskon' => 0,
                'gambar' => '1776376094_nanci 3.webp',
                'stok' => 8,
                'status' => 'published',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama' => 'Nanci Blue Edition',
                'kategori_id' => $kategoriIds['boneka'],
                'kategori' => 'Boneka',
                'deskripsi' => 'Edisi terbatas boneka rajut Nanci dengan tema kostum biru laut yang menawan.',
                'harga' => 145000.00,
                'harga_diskon' => 130000.00,
                'gambar' => '1776376253_nanci 4.webp',
                'stok' => 12,
                'status' => 'published',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}