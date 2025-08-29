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
    Schema::table('siswas', function (Blueprint $table) {
        $table->string('nis')->nullable();
        $table->string('no_ijazah')->nullable();
        $table->string('pendidikan_ayah')->nullable();
        $table->string('pendidikan_ibu')->nullable();
        $table->string('pekerjaan_ayah')->nullable();
        $table->string('pekerjaan_ibu')->nullable();
        $table->string('nik_ayah')->nullable();
        $table->string('nik_ibu')->nullable();
        $table->string('penghasilan_ayah')->nullable();
        $table->string('penghasilan_ibu')->nullable();
    });
}

public function down()
{
    Schema::table('siswas', function (Blueprint $table) {
        $table->dropColumn([
            'nis', 'no_ijazah', 'pendidikan_ayah', 'pendidikan_ibu',
            'pekerjaan_ayah', 'pekerjaan_ibu', 'nik_ayah', 'nik_ibu',
            'penghasilan_ayah', 'penghasilan_ibu',
        ]);
    });
}
};