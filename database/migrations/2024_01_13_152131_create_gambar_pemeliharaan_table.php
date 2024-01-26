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
        Schema::create('gambar_pemeliharaan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_pemeliharaan');
            $table->string('gambar');

            $table->foreign('id_pemeliharaan')->references('id')->on('pemeliharaan')
            ->onDelete('cascade')
            ;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gambar_pemeliharaan');
    }
};
