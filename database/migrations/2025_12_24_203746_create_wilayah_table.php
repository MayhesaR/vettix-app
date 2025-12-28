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
    Schema::create('wilayah', function (Blueprint $table) {
        // tidak pakai $table->id() auto increment karena ID-nya akan ikut dari API (biar konsisten)
        $table->char('id', 10)->primary(); // Contoh ID: 32 (Jabar), 3273 (Bandung)
        $table->string('nama');      // Nama Provinsi/Kota/Kecamatan
        $table->char('parent_id', 10)->nullable(); // ID Induk (Misal: Kota Bandung induknya Jawa Barat)
        $table->enum('level', ['provinsi', 'kota', 'kecamatan']); // Penanda level wilayah
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wilayah');
    }
};
