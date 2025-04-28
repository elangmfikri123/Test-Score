<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files_pesertas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id')->constrained('peserta')->onDelete('cascade')->nullable();
            $table->string('file_lampiranklhn')->nullable();
            $table->string('judul_project')->nullable();
            $table->string('tahun_pembuatan_project')->nullable();
            $table->string('file_project')->nullable();
            $table->string('foto_profil')->nullable();
            $table->string('ktp')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files_pesertas');
    }
};
