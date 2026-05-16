<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->enum('status', ['pending', 'paid', 'processing', 'shipped', 'completed', 'cancelled'])
                  ->default('pending')
                  ->after('nomor_wa');
            $table->string('bukti_bayar', 255)->nullable()->after('status');
            $table->string('resi', 100)->nullable()->after('bukti_bayar');
            $table->text('notes')->nullable()->after('resi');
        });
    }

    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn(['status', 'bukti_bayar', 'resi', 'notes']);
        });
    }
};