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
        Schema::create('submission_klhrs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maindealer_id')->nullable()->constrained('maindealer')->onUpdate('cascade')->onDelete('cascade');
            $table->string('link_klhr1')->nullable();
            $table->string('link_klhr2')->nullable();
            $table->string('link_klhr3')->nullable();
            $table->string('file_submission')->nullable();
            $table->string('file_ttdkanwil')->nullable();
            $table->string('file_dokumpelaksanaan')->nullable();
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
        Schema::dropIfExists('submission_klhrs');
    }
};
