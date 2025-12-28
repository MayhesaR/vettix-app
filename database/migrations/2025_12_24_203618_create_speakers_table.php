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
    Schema::create('speakers', function (Blueprint $table) {
        $table->id();
        $table->string('username_platform')->nullable(); // Username GitHub/LinkedIn
        $table->string('nama_lengkap');
        $table->string('role_job')->nullable();     // Contoh: Software Engineer
        $table->string('instansi')->nullable();     // Contoh: Gojek / Google
        $table->text('bio_singkat')->nullable();    // Hasil auto-fill API
        $table->string('avatar_url')->nullable();   // URL foto dari API

        // Relasi ke Event (Narasumber mengisi event apa)
        $table->foreignId('event_id')->constrained('events')->onDelete('cascade');

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('speakers');
    }
};
