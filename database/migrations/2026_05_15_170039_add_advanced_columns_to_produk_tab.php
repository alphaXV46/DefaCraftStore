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
        // Menambah stok jika belum ada di DB (karena di migration awal tidak ada)
        if (!Schema::hasColumn('produk', 'stok')) {
            $table->integer('stok')->default(0)->after('harga');
        }
        $table->decimal('harga_diskon', 10, 2)->nullable()->after('harga');
        $table->enum('status', ['draft', 'published'])->default('published')->after('gambar');
        
        // Opsional: Jika ingin kategori pakai tabel sendiri (CRUD Kategori)
        // $table->unsignedBigInteger('category_id')->nullable()->after('id');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('produk', function (Blueprint $table) {
        $table->dropColumn(['harga_diskon', 'status']);
        // kolom stok tidak perlu di drop jika itu fitur utama
    });
}
};
