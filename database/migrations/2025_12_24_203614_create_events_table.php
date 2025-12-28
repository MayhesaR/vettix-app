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
    Schema::create('events', function (Blueprint $table) {
        $table->id();
        $table->string('nama_event');
        $table->date('tanggal_event'); // Validasi API Libur dilakukan sebelum save ke sini
        $table->text('deskripsi');
        $table->string('banner_img')->nullable(); // Foto poster event

        // Relasi Foreign Key
        $table->foreignId('venue_id')->constrained('venues')->onDelete('cascade');
        $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
        $table->foreignId('user_id')->constrained('users'); // Siapa admin pembuat event

        $table->timestamps();
        });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
