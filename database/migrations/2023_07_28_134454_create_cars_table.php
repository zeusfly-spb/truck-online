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
      Schema::create('cars', function (Blueprint $table) {
        $table->id();
        $table->string('icon');
        $table->string('number');
        $table->string('mark_model');
        $table->string('sts');
        $table->string('sts_file_1');
        $table->string('sts_file_2');
        $table->string('max_weigth');
        //relation types
        $table->unsignedBigInteger('company_id');
        $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        $table->unsignedBigInteger('car_type_id');
        $table->foreign('car_type_id')->references('id')->on('car_types')->onDelete('cascade');
        $table->unsignedBigInteger('country_id');
        $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        $table->unsignedBigInteger('right_use_id');
        $table->foreign('right_use_id')->references('id')->on('right_uses')->onDelete('cascade');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
