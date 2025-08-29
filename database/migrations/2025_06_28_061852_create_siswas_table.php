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
        if (!Schema::hasTable('siswas')) {
            Schema::create('siswas', function (Blueprint $table) {
                $table->id();
                $table->string('nama');
                $table->string('email')->unique();
                $table->string('nisn')->unique();
                $table->string('nik')->unique();
                $table->string('no_kk')->nullable();
                $table->string('ttl')->nullable(); // tempat, tanggal lahir
                $table->year('tahun_masuk')->nullable();
                $table->string('kelas')->nullable();
                $table->string('jurusan')->nullable();
                $table->string('asal_sekolah')->nullable(); // ✅ kolom baru
                $table->text('alamat')->nullable();
                $table->string('no_hp')->nullable();
                $table->string('nama_ayah')->nullable();
                $table->string('nama_ibu')->nullable();
                $table->text('alamat_orang_tua')->nullable();

                // Upload file
                $table->string('file_skl')->nullable();
                $table->string('file_ijazah')->nullable();
                $table->string('file_ktp_orang_tua')->nullable();
                $table->string('file_kk')->nullable();
                $table->string('file_foto')->nullable();

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
