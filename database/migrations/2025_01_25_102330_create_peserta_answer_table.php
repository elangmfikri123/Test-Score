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
        Schema::create('peserta_answer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_course_id')->constrained('peserta_course')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('peserta_id')->constrained('peserta')->onUpdate('cascade')->onDelete('cascade')->nullable();
            $table->foreignId('question_id')->constrained('question')->onUpdate('cascade')->onDelete('cascade')->nullable();
            $table->foreignId('answer_id')->constrained('answer')->onUpdate('cascade')->onDelete('cascade')->nullable();
            $table->boolean('is_correct')->default(false);
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
        Schema::dropIfExists('peserta_answer');
    }
};
