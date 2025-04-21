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
        Schema::create('permohonan_virtual_meeting', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_tiket')->nullable();
            $table->string('user_id')->nullable();
            $table->string('nama_lengkap')->nullable();
            $table->string('instansi')->nullable();
            $table->string('topik_meeting')->nullable();
            $table->string('waktu_pelaksanaan')->nullable();
            $table->string('jumlah_partisipan')->nullable();
            $table->string('durasi_meeting')->nullable();
            $table->string('lokasi_meeting')->nullable();
            $table->string('link_operator')->nullable();
            $table->string('surat_permohonan')->nullable();
            $table->boolean('status')->default(0);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonan_virtual_meeting');
    }
};
