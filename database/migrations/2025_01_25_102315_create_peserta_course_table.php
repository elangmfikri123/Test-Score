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
        Schema::create('peserta_course', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('course')->onUpdate('cascade')->onDelete('cascade')->nullable();
            $table->foreignId('peserta_id')->constrained('peserta')->onUpdate('cascade')->onDelete('cascade')->nullable();
            $table->enum('status_pengerjaan', ['belum_mulai', 'sedang_dikerjakan', 'selesai'])->default('belum_mulai');
            $table->time('sisa_waktu')->nullable();
            $table->timestamp('start_exam')->nullable();
            $table->timestamp('end_exam')->nullable();
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
        Schema::dropIfExists('peserta_course');
    }
};
