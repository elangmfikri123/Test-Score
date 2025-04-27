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
        Schema::create('peserta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreignId('maindealer_id')->constrained('maindealer')->onUpdate('cascade')->onDelete('cascade')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('honda_id')->nullable();
            $table->string('nama')->nullable();
            $table->date('tanggal_hondaid')->nullable();
            $table->date('tanggal_awalbekerja')->nullable();
            $table->integer('lamabekerja_honda')->nullable();
            $table->integer('lamabekerja_dealer')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('no_hp_astrapay')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('ukuran_baju')->nullable();
            $table->string('pantangan_makanan')->nullable();
            $table->string('riwayat_penyakit')->nullable();
            $table->string('link_facebook')->nullable();
            $table->string('link_instagram')->nullable();
            $table->string('link_tiktok')->nullable();
            $table->string('created_by')->nullable();
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
        Schema::dropIfExists('peserta');
    }
};
