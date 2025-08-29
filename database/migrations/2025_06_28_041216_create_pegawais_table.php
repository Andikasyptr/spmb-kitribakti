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
        // Tabel utama pegawai
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('nip')->nullable(); // Nomor Induk Pegawai
            $table->string('jabatan')->nullable();
            $table->string('no_hp')->nullable();
            $table->text('alamat')->nullable();
            $table->string('ttl')->nullable(); // Tempat Tanggal Lahir
            $table->year('tahun_masuk')->nullable();
            $table->enum('jenis_pegawai', ['guru', 'tenaga_kependidikan']);
            $table->timestamps();
        });

        // Tabel untuk file SK
        Schema::create('pegawai_sks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
            $table->string('nama_file');
            $table->string('path_file');
            $table->timestamps();
        });

        // Tabel untuk sertifikat
        Schema::create('pegawai_sertifikats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
            $table->string('nama_sertifikat');
            $table->string('path_file');
            $table->timestamps();
        });

        // Tabel untuk relasi guru dan mata pelajaran
        Schema::create('guru_mapels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
            $table->string('mata_pelajaran');
            $table->timestamps();
        });

        // Tabel detail tambahan khusus guru
        Schema::create('guru_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawais')->onDelete('cascade');
            $table->integer('jumlah_kelas_mengajar')->nullable();
            $table->boolean('wali_kelas')->default(false);
            $table->integer('jumlah_hari_mengajar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru_details');
        Schema::dropIfExists('guru_mapels');
        Schema::dropIfExists('pegawai_sertifikats');
        Schema::dropIfExists('pegawai_sks');
        Schema::dropIfExists('pegawais');
    }
};
