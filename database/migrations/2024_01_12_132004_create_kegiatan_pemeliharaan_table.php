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
        Schema::create('kegiatan_pemeliharaan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_kategori_pemeliharaan');
            $table->foreign('id_kategori_pemeliharaan')->references('id')->on('kategori_pemeliharaan')->onDelete('cascade');;
            $table->string('nama_kegiatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatan_pemeliharaan');
    }
};
