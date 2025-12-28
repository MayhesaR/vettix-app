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
        Schema::create('rankings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participant_id')->constrained('participants')->onDelete('cascade');
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->integer('rank')->default(0); // Peringkat
            $table->decimal('score', 8, 2)->default(0); // Skor/nilai
            $table->string('achievement')->nullable(); // Pencapaian (Juara 1, 2, 3, dll)
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->timestamps();
            
            // Index untuk query yang lebih cepat
            $table->index(['event_id', 'rank']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rankings');
    }
};
