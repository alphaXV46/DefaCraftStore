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
    Schema::table('produks', function (Blueprint $table) {
        // Tambahkan kolom kategori_id setelah kolom nama
        $table->unsignedBigInteger('kategori_id')->nullable()->after('nama');

        // Tambahkan kolom status untuk fitur Draf/Toggle [Tugas Poin 2]
        $table->enum('status', ['draft', 'published'])->default('draft')->after('stok');

        // Opsional: Buat relasi ke tabel kategoris
        $table->foreign('kategori_id')->references('id')->on('kategoris')->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            //
        });
    }
};
