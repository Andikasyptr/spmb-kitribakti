<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus tabel lama kalau ada
        Schema::dropIfExists('siswa_pindahan');

        // Clone struktur tabel siswas
        DB::statement('CREATE TABLE siswa_pindahan LIKE siswas');

        // Tambah kolom khusus siswa keluar
        Schema::table('siswa_pindahan', function (Blueprint $table) {
            $table->unsignedBigInteger('siswa_id')->nullable()->after('id');
            $table->date('tanggal_keluar')->nullable();
            $table->text('alasan_keluar')->nullable();
            $table->string('sekolah_tujuan')->nullable();
            $table->string('file_surat_pindah')->nullable();
            $table->string('status_keluar')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa_pindahan');
    }
};
