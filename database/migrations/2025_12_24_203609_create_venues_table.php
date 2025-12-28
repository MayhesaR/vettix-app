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
    Schema::create('venues', function (Blueprint $table) {
        $table->id();
        $table->string('nama_venue');     // Contoh: Auditorium Gd. K
        $table->string('gedung');         // Contoh: Gedung Damar
        $table->integer('kapasitas');     // Contoh: 500
        $table->text('fasilitas')->nullable(); // Contoh: AC, Proyektor
        // Data Wilayah (Disimpan string/ID dari API Wilayah Indonesia)
        $table->string('provinsi_id');
        $table->string('kota_id');
        $table->string('kecamatan_id');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venues');
    }
};
