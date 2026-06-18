<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('layanans', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique(); // Misal "1", "2", "A", dll
            $table->string('nama'); // Nama Layanan
            $table->json('pertanyaan')->nullable(); // JSON dinamis pertanyaan
            $table->string('icon')->default('folder'); // Untuk Lucide icons di sidebar
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanans');
    }
};
