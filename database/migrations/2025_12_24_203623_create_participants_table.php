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
    Schema::create('participants', function (Blueprint $table) {
        $table->id();
        $table->string('nama_peserta');
        $table->string('nim')->unique();
        $table->string('email');
        $table->string('asal_instansi'); // Hasil auto-complete API Kampus
        $table->enum('status_kehadiran', ['hadir', 'tidak_hadir'])->default('tidak_hadir');

        // Relasi (Peserta mendaftar ke event mana)
        $table->foreignId('event_id')->constrained('events')->onDelete('cascade');

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
