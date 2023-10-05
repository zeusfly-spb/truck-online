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
        Schema::create('calc_histories', function (Blueprint $table) {
            $table->id();

            // $table->unsignedBigInteger('user_id');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->unsignedBigInteger('container_id');
            // $table->foreign('container_id')->references('id')->on('containers')->onDelete('cascade');
            // $table->unsignedBigInteger('from_address_id');
            // $table->foreign('from_address_id')->references('id')->on('addresses')->onDelete('cascade');
            // $table->unsignedBigInteger('delivery_address_id');
            // $table->foreign('delivery_address_id')->references('id')->on('addresses')->onDelete('cascade');
            // $table->unsignedBigInteger('return_address_id');
            // $table->foreign('return_address_id')->references('id')->on('addresses')->onDelete('cascade');
            // $table->unsignedBigInteger('delivery2_address_id')->nullable();
            // $table->foreign('delivery2_address_id')->references('id')->on('addresses')->onDelete('cascade');
            // $table->unsignedBigInteger('return2_address_id')->nullable();
            // $table->foreign('return2_address_id')->references('id')->on('addresses')->onDelete('cascade');
            // $table->unsignedBigInteger('tax_id');
            // $table->foreign('tax_id')->references('id')->on('taxes')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('container_id')->index();
            $table->unsignedBigInteger('from_address_id')->index();
            $table->unsignedBigInteger('delivery_address_id')->index();
            $table->unsignedBigInteger('return_address_id')->index();
            $table->unsignedBigInteger('delivery2_address_id')->index();
            $table->unsignedBigInteger('company_from_id')->index();


            $table->double('price');
            $table->double('weight');
            $table->boolean('imo');
            $table->boolean('temp_reg');
            $table->boolean('is_international');
            $table->boolean('hidden')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calc_histories');
    }
};
