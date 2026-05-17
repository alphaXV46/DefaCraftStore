<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('transaksi', function (Blueprint $table) {
        // Cek dulu sebelum tambah, supaya tidak error kalau sudah ada
        if (!Schema::hasColumn('transaksi', 'order_id')) {
            $table->string('order_id')->nullable()->after('id');
        }
        if (!Schema::hasColumn('transaksi', 'ongkir')) {
            $table->integer('ongkir')->default(0)->after('total_harga');
        }
        if (!Schema::hasColumn('transaksi', 'snap_token')) {
            $table->string('snap_token')->nullable()->after('status');
        }
        if (!Schema::hasColumn('transaksi', 'payment_type')) {
            $table->string('payment_type')->nullable()->after('snap_token');
        }
        if (!Schema::hasColumn('transaksi', 'paid_at')) {
            $table->timestamp('paid_at')->nullable()->after('payment_type');
        }
        if (!Schema::hasColumn('transaksi', 'stock_reduced')) {
            $table->boolean('stock_reduced')->default(false)->after('paid_at');
        }
        if (!Schema::hasColumn('transaksi', 'catatan')) {
            $table->text('catatan')->nullable()->after('alamat');
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('transaksi', function (Blueprint $table) {
        $table->dropColumn([
            'order_id', 'ongkir', 'snap_token',
            'payment_type', 'paid_at', 'stock_reduced', 'catatan'
        ]);
    });
}
};
