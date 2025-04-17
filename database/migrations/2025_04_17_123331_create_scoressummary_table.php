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
        Schema::create('scoressummary', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formpenilaian_id')->constrained('formpenilaian')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('juri_id')->constrained('juri')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('peserta_id')->constrained('peserta')->onUpdate('cascade')->onDelete('cascade');
            $table->text('noted');
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
        Schema::dropIfExists('scoressummary');
    }
};
