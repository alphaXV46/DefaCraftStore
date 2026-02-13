<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wishlist', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
            $table->timestamps();
            
            // Pastikan 1 user tidak bisa wishlist produk yang sama 2x
            $table->unique(['user_id', 'produk_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wishlist');
    }
};