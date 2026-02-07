<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswa_pindahan', function (Blueprint $table) {
            $table->enum('status', ['diterima','keluar'])
                  ->default('keluar')
                  ->after('status_keluar');
        });
    }

    public function down(): void
    {
        Schema::table('siswa_pindahan', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
