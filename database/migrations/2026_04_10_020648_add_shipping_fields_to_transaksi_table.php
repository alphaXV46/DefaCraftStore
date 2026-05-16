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
        if (!Schema::hasColumn('transaksi', 'province_id')) {
            $table->string('province_id')->nullable()->after('alamat');
        }
        if (!Schema::hasColumn('transaksi', 'city_id')) {
            $table->string('city_id')->nullable()->after('province_id');
        }
        if (!Schema::hasColumn('transaksi', 'city_name')) {
            $table->string('city_name')->nullable()->after('city_id');
        }
        if (!Schema::hasColumn('transaksi', 'kurir')) {
            $table->string('kurir')->nullable()->after('city_name');
        }
        if (!Schema::hasColumn('transaksi', 'layanan_kurir')) {
            $table->string('layanan_kurir')->nullable()->after('kurir');
        }
        if (!Schema::hasColumn('transaksi', 'estimasi')) {
            $table->string('estimasi')->nullable()->after('layanan_kurir');
        }
        if (!Schema::hasColumn('transaksi', 'berat_total')) {
            $table->integer('berat_total')->default(500)->after('estimasi');
        }
        if (!Schema::hasColumn('transaksi', 'latitude')) {
            $table->decimal('latitude', 10, 8)->nullable()->after('berat_total');
        }
        if (!Schema::hasColumn('transaksi', 'longitude')) {
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            //
        });
    }
};
