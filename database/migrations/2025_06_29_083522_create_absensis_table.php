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
       Schema::create('absensis', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->date('tanggal');
    $table->time('jam_masuk')->nullable();
    $table->time('jam_pulang')->nullable();
    $table->enum('status_masuk', ['tepat_waktu', 'terlambat'])->nullable();
    $table->enum('status_pulang', ['tepat_waktu', 'pulang_cepat'])->nullable();
    $table->enum('status_hari', ['lengkap', 'hanya_masuk', 'hanya_pulang', 'tidak_hadir'])->default('tidak_hadir');
    $table->text('keterangan')->nullable(); // Jika izin/sakit, bisa tetap pakai ini
    $table->foreignId('dibuat_oleh')->nullable()->constrained('users')->onDelete('set null');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
