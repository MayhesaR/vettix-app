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
    Schema::create('certificates', function (Blueprint $table) {
        $table->id();
        $table->string('no_sertifikat')->unique(); // Generate otomatis: SR-001/2025
        $table->string('file_path')->nullable();   // Link file PDF
        $table->string('qr_code_url');             // URL dari API QR Code

        // Relasi One-to-One (Satu peserta satu sertifikat per event)s
        $table->foreignId('participant_id')->constrained('participants')->onDelete('cascade');
        $table->foreignId('event_id')->constrained('events')->onDelete('cascade');

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
