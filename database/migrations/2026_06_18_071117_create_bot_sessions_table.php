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
        Schema::create('bot_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->unique(); // 1 HP = 1 Sesi Aktif
            $table->string('service_id');      // Menyimpan layanan apa (misal '1' = Aduan, '2' = VM)
            $table->integer('step')->default(1);
            $table->json('data')->nullable();  // Menyimpan jawaban langkah demi langkah
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bot_sessions');
    }
};
