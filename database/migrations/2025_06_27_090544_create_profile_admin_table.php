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
            Schema::create('profile_admin', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->string('foto')->nullable();
                $table->string('alamat')->nullable();
                $table->string('email')->nullable();  // email admin
                $table->string('nik')->nullable();    // NIK admin
                $table->string('no_hp')->nullable();  // No HP admin
                $table->timestamps();
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_admin');
    }
};
