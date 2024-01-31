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
        Schema::create('daftar_pemeliharaan', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->uuid("id_pemeliharaan");
            $table->foreign('id_pemeliharaan')->references('id')->on('pemeliharaan')->onDelete('cascade');
            $table->uuid("id_kegiatan_pemeliharaan");
            $table->foreign('id_kegiatan_pemeliharaan')->references('id')->on('kegiatan_pemeliharaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_pemeliharaan');
    }
};
