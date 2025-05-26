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
        Schema::create('formpenilaian', function (Blueprint $table) {
            $table->id();
            $table->string('namaform')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('category')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('maxscore')->nullable();
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
        Schema::dropIfExists('formpenilaian');
    }
};
