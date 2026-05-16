<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::table('produk', function (Blueprint $table) {
        // Cek dan tambah kategori_id
        if (!Schema::hasColumn('produk', 'kategori_id')) {
            $table->unsignedBigInteger('kategori_id')->nullable()->after('nama');
        }
        // Cek dan tambah status
        if (!Schema::hasColumn('produk', 'status')) {
            $table->enum('status', ['draft', 'published'])->default('draft')->after('stok');
        }
        // Cek dan tambah harga_diskon
        if (!Schema::hasColumn('produk', 'harga_diskon')) {
            $table->integer('harga_diskon')->nullable()->after('harga');
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            //
        });
    }
};
