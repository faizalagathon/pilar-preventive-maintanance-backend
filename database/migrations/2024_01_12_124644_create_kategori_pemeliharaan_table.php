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
        Schema::create('kategori_pemeliharaan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_bidang');
            $table->string('nama', 255);

            $table->foreign('id_bidang')->references('id')->on('bidang')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_pemeliharaan');
    }
};
