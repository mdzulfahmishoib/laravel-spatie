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
        Schema::create('setup_app', function (Blueprint $table) {
            $table->id();
            $table->string('nama_aplikasi');
            $table->string('deskripsi_aplikasi');
            $table->string('nama_instansi')->nullable();
            $table->string('alamat')->nullable();
            $table->string('logo_aplikasi')->nullable();
            $table->string('logo_instansi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setup_app');
    }
};
