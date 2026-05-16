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
        // Menambah kolom kategori_id
        $table->unsignedBigInteger('kategori_id')->nullable()->after('nama');
        // Menambah kolom status untuk fitur Draf/Tayang
        $table->enum('status', ['draft', 'published'])->default('draft')->after('stok');

        // Relasi ke tabel kategoris
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
