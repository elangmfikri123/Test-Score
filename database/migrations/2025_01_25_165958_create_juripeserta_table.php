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
        Schema::create('juripeserta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('juri_id')->constrained('juri')->onUpdate('cascade')->onDelete('cascade'); // Relasi ke juri
            $table->foreignId('peserta_id')->constrained('peserta')->onUpdate('cascade')->onDelete('cascade'); // Relasi ke peserta
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
        Schema::dropIfExists('juripeserta');
    }
};
