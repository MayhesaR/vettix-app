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
    Schema::create('reviews', function (Blueprint $table) {
        $table->id();
        $table->string('participant_name'); // Nama peserta yang memberikan review
        $table->integer('rating'); // Bintang 1-5
        $table->text('komentar');
        $table->string('avatar_visual_url')->nullable(); // URL dari API UI Avatars
        $table->boolean('is_published')->default(true); // Status publish/hide

        // Relasi
        $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
        // Jika user login, bisa pakai user_id. Jika anonim, bisa null.
        $table->foreignId('user_id')->nullable()->constrained('users');

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
