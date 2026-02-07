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
        Schema::create('siswa_pindahan', function (Blueprint $table) {
            $table->id();

            // ambil dari tabel siswa
            $table->unsignedBigInteger('siswa_id')->nullable(); // id asal siswa (jejak)

            // identitas siswa
            $table->string('nis')->nullable();
            $table->string('nisn')->nullable();
            $table->string('nama');
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();

            // data sekolah
            $table->unsignedBigInteger('kelas_id')->nullable();
            $table->string('jurusan')->nullable();
            $table->string('tahun_masuk')->nullable();

            // data keluar
            $table->date('tanggal_keluar')->nullable();
            $table->string('alasan_keluar')->nullable(); // pindah, mengundurkan diri, DO, dll
            $table->string('sekolah_tujuan')->nullable();

            // arsip berkas
            $table->string('file_surat_pindah')->nullable();

            // status arsip
            $table->enum('status', ['Keluar', 'Kembali'])->default('Keluar');

            $table->timestamps();

            // relasi
            $table->foreign('kelas_id')
                  ->references('id')
                  ->on('kelas')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa_pindahan');
    }
};