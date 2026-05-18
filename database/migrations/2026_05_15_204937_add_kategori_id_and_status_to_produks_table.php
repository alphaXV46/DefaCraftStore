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
        if (!Schema::hasColumn('produk', 'kategori_id')) {
            $table->unsignedBigInteger('kategori_id')->nullable()->after('nama');
            $table->foreign('kategori_id')->references('id')->on('kategori')->onDelete('set null');
        }
        if (!Schema::hasColumn('produk', 'status')) {
            $table->enum('status', ['draft', 'published'])->default('draft')->after('stok');
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
